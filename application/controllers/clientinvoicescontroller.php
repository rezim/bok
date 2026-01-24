<?php

class clientinvoicesController extends InvoicesController
{
    function show()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));

        $smarty->assign('fakturownia_conf_file_path', ROOT . DS . 'config' . DS . 'fakturownia.conf');
    }


    function deptors() {

    }

    function deptorsdata() {
        global $smarty;
        $clientName = isset($_POST['filterklient']) ? trim((string)$_POST['filterklient']) : null;
        $clientNip  = isset($_POST['filternip'])    ? trim((string)$_POST['filternip'])    : null;
        $invoiceNo  = isset($_POST['filtervat'])    ? trim((string)$_POST['filtervat'])    : null;

        // Normalize empty strings to null (so they don't affect filtering)
        $clientName = ($clientName === '') ? null : $clientName;
        $clientNip  = ($clientNip === '')  ? null : $clientNip;
        $invoiceNo  = ($invoiceNo === '')  ? null : $invoiceNo;

        $invoices = $this->getNotPaidInvoices($clientName, $clientNip, $invoiceNo);

        $agreements = $this->clientinvoice->getAgreementsArray();
        $clients = $this->buildUnpaidAccordionModel($invoices, $agreements);
        $fakturowniaEndpoint = FAKTUROWNIA_ENDPOINT;
        $fakturowniaEndpoint = preg_replace('#^http://#', 'https://', $fakturowniaEndpoint);
        $smarty->assign('FAKTUROWNIA_ENDPOINT', $fakturowniaEndpoint);
        $smarty->assign('FAKTUROWNIA_APITOKEN', FAKTUROWNIA_APITOKEN);
        $smarty->assign('clients', $clients);
    }

    function vindication()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));
    }

    function vindicationdata()
    {
        global $smarty;
        $this->clientinvoice->populateWithPost();
        $agreements = $this->clientinvoice->getPaymentMonitoredAgreements();

        if (count($agreements) === 0) {
            $smarty->assign('isEmptyMessage', 'Dla podanych filtrów nie ma żadnych danych do wyświetlenia.');
        } else {
            $columnNames = array_keys($agreements[0]);

            $columnSummaries = array_map(fn($columnName) => array_sum(array_map(fn($val) => is_numeric($val) ? $val : 0, array_column($agreements, $columnName))), $columnNames);

            $smarty->assign('columnNames', $columnNames);
            $smarty->assign('columnSummaries', $columnSummaries);
            $smarty->assign('data', $agreements);
        }
    }

    function getagreements()
    {
        echo $this->clientinvoice->getAgreements();
    }

    function getinvoices()
    {
        if ($_POST['period'] && $_POST['date_from'] && $_POST['date_to']) {
            $filters = '';
            if (isset($_POST['filters'])) {
                $filters = $_POST['filters'];
            }
            echo json_encode(
                $this->getInvoicesByDateRange($_POST['period'], $_POST['date_from'], $_POST['date_to'], $filters)
            );
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getNotPaid()
    {
        echo json_encode($this->getNotPaidInvoices());
    }

    function sendpaimentreminder()
    {
        if (!$_POST['client_id'] || !$_POST['client_nip'] || !$_POST['client_email']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "blędne parametery wejściowe";
            return;
        }

        try {
            $clientOverdueInvoices = array_reverse($this->getInvoicesByClientId($_POST['client_id'], false));

            $clientInterestNotes = $this->resolveNotPaidInterestNotes($_POST['client_nip']);

            $clientEmail = $_POST['client_email'];

            $this->sendOverduePaymentsReminder($clientOverdueInvoices, $clientInterestNotes, $_POST['client_nip'], $clientEmail);

            echo "OK";
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo $e->getMessage();
        }
    }

    function getpayments()
    {
        if ($_POST['client_id'] && $_POST['date_from']) {
            echo json_encode($this->getClientPayments($_POST['client_id'], $_POST['date_from']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getoverpaidpayments()
    {
        if (isset($_POST['client_id'])) {
            echo json_encode($this->getAllOverpaidPayments($_POST['client_id']));
        } else {
            echo json_encode($this->getAllOverpaidPayments());
        }
    }

    function removeinvoicebyid()
    {
        $required = ['invoice_id'];
        if ($this->validatePostParams($required)) {
            echo json_encode($this->removeInvoice($_POST['invoice_id']));
        }
    }

    function addnewinvoice()
    {
        $required = ['kind', 'sell_date', 'issue_date', 'payment_to',
            'buyer_email', 'buyer_post_code', 'buyer_city', 'buyer_street', 'positions',
            'show_discount', 'internal_note', 'additional_info', 'additional_info_desc', 'buyer_tax_no', 'buyer_name'];

        if ($this->validatePostParams($required)) {

            $invoice = $this->addInvoice(
                $_POST['kind'], $_POST['number'], $_POST['sell_date'], $_POST['issue_date'], $_POST['payment_to'], $_POST['buyer_name'],
                $_POST['buyer_tax_no'], $_POST['buyer_email'], $_POST['buyer_post_code'], $_POST['buyer_city'], $_POST['buyer_street'],
                $_POST['recipient_id'], $_POST['positions'], $_POST['show_discount'], $_POST['internal_note'], $_POST['additional_info'],
                $_POST['additional_info_desc']);

            if ($invoice) {
                echo json_encode($invoice);
            } else {
                echo "Podany identyfikator klienta nie jest NIP-em ani PESELEM: " . $_POST['buyer_tax_no'];
                http_response_code(400);
            }
        }

    }

    function addinvoicepayment()
    {
        if ($_POST['price'] && $_POST['invoice_id'] && $_POST['invoice_tax_no'] && $_POST['client_id'] && $_POST['paid_name'] && $_POST['paid_date']) {
            echo json_encode(
                $this->addPayment(
                    $_POST['price'],
                    $_POST['invoice_id'],
                    $_POST['client_id'],
                    $_POST['invoice_tax_no'],
                    $_POST['paid_name'],
                    $_POST['paid_date'],
                    $this->normalizeCurrencyValue($_POST['price'])
                )
            );
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function interestnotehasbeenpaid()
    {
        if ($_POST['nip'] && $_POST['name'] && $_POST['number'] && $_POST['date']) {
            echo json_encode($this->markInterestNoteAsPaid($_POST['nip'], $_POST['name'], $_POST['number'], $_POST['date']));
        } else {
            echo "błędne parametry wyjściowe";
        }
    }

    function removeinterestnote()
    {
        if ($_POST['nip'] && $_POST['name'] && $_POST['number'] && $_POST['date']) {
            echo json_encode($this->removeNotPaidInterestNote($_POST['nip'], $_POST['name'], $_POST['number'], $_POST['date']));
        } else {
            echo "błędne parametry wyjściowe";
        }
    }

    /**
     * getInterestNotes()
     * get interest notes by client NIP
     */
//    function getinterestnotes()
//    {
//        $nip = $_POST['nip'];
//        if ($nip) {
//            echo json_encode($this->clientinvoice->getInterestNotesByNip($nip));
//        } else {
//            echo "błędne parametry wyjściowe";
//        }
//    }
    function getinterestnotes()
    {
        if ($_POST['nip']) {
            echo json_encode($this->resolveInterestNotes($_POST['nip']));
        } else {
            echo "błędne parametry wyjściowe";
        }
    }

    function getallinterestnotes()
    {
        if (DISABLE_INTEREST_NOTES) {
            return json_encode([]);
        }
        echo json_encode($this->resolveAllInterestNotes());
    }

//    function getallinterestnotes()
//    {
//
//        if (DISABLE_INTEREST_NOTES) {
//            return json_encode([]);
//        }
//
//        $allInterestNotes = $this->clientinvoice->getInterestNotes();
//
//        $groupedByNip = array();
//        foreach ($allInterestNotes as $interestNote) {
//            $groupedByNip[$interestNote['nip']][] = $interestNote;
//        }
//
//        echo json_encode($groupedByNip);
//    }

    function moveInterestNotesFromFileIntoDB()
    {
        $allInterestNotes = array_merge(...$this->resolveAllInterestNotes());

        $externalClients = array();

        foreach ($allInterestNotes as $interestNote) {
            $clientNip = $interestNote['nip'];
            if (!isset($externalClients[$clientNip])) {
                $externalClients[$clientNip] = $this->getClientByTaxNo($clientNip);
            }
            $invoiceNb = $interestNote['number'];
            $invoice = $this->getInvoiceByNumber($invoiceNb);

            $invoicePaidDate = $invoice ? $invoice['paid_date'] : null;

            $externalClient = $externalClients[$clientNip];
            $externalClientId = $externalClient ? $externalClient[0]['id'] : -1;
            $fileName = $interestNote['name'];
            $filePath = $interestNote['path'];
            $issueDate = $interestNote['issueDate'];
            $paymentToDate = $interestNote['paymentToDate']; // termin płatności
            $paidDate = $interestNote['paidDate'];
            $amount = $interestNote['amount'];
            $paid = $interestNote['paid']; // false
            $invoiceIssueDate = $interestNote["invoiceIssueDate"];
            $invoicePaymentToDate = $interestNote["invoicePaidDate"];
            $invoiceAmount = $interestNote["invoiceAmount"];
            $interestNotePaidDate = $this->getInterestNotePaidDate($fileName);

            $this->clientinvoice->createInterestNote($clientNip, $externalClientId, $clientNip, $fileName, $filePath, $issueDate, $paymentToDate, $paidDate, $amount, $invoiceNb,
                $invoiceIssueDate, $invoicePaymentToDate, $invoicePaidDate, $invoiceAmount, $interestNotePaidDate,
                $paid);
        }


        echo json_encode($this->resolveAllInterestNotes());
    }

    function generateMissingInterestNotes()
    {
        $allOverdueInvoices = $this->getInvoicesByDateRange('more', '2023-07-01', '2023-11-30', $additionalFilters = '&status=overdue_paid');

        $clients = $this->clientinvoice->getClientsWithChargeInterest();

        $clientsGroupedByNip = array();
        foreach ($clients as $client) {
            $clientsGroupedByNip[$client['nip']][] = $client;
        }

        $allInterestNotes = $this->clientinvoice->getInterestNotes();

        $groupedByInvoiceNb = array();
        foreach ($allInterestNotes as $interestNote) {
            $groupedByInvoiceNb[$interestNote['invoice_nb']][] = $interestNote;
        }

        $count = 0;

        foreach ($allOverdueInvoices as $invoice) {
            if (!isset($groupedByInvoiceNb[$invoice['number']]) && isset($clientsGroupedByNip[$invoice['buyer_tax_no']])) {

                $id = $invoice['id'];
                $number = $invoice['number'];
                $buyerTaxNo = $invoice['buyer_tax_no'];
                $sellDate = $invoice['sell_date'];
                $paymentTo = $invoice['payment_to'];
                $paidDate = $invoice['paid_date'];

                $date1 = new DateTime($invoice['payment_to']);
                $date2 = new DateTime($paidDate);
                $interval = $date1->diff($date2);
                $isLateDays = $interval->days;

//                const {id, number, buyer_tax_no, sell_date, payment_to, paid_date, is_late_days} = invoice;
                $this->issueInterestNote($id, $number, $buyerTaxNo, '', $sellDate, $paymentTo, $paidDate, $isLateDays);
                $count++;
            }
        }

        echo $count;

        return;
    }

    /**
     * addInterestNotesInvoice()
     *
     */
    function addinterestnotestoinvoice()
    {

        $required = ['invoice_id', 'nip'];

        if ($this->validatePostParams($required)) {

            if ($_POST['invoice_id'] && $_POST['nip']) {
                echo json_encode($this->addNotPaidInterestNotesToInvoice($_POST['invoice_id'], $_POST['nip']));
            } else {
                echo "błędne parametry wyjściowe";
            }

        }
    }

    function generateinterestnote()
    {
        if ($_POST['id'] && $_POST['number'] && $_POST['buyer_tax_no'] && $_POST['sell_date'] && $_POST['payment_to'] && $_POST['is_late_days']) {
            echo json_encode($this->issueInterestNote($_POST['id'], $_POST['number'], $_POST['buyer_tax_no'], $_POST['buyer_email'], $_POST['sell_date'], $_POST['payment_to'], $_POST['paid_date'], $_POST['is_late_days']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function addpaymentclientmessage()
    {
        if ($_POST['client_nip'] && $_POST['message_date'] && $_POST['message']) {
            echo $this->clientinvoice->addPaymentMessage($_POST, 'payments_messages');
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function removeclientmessage()
    {
        if ($_POST['rowid']) {
            echo $this->clientinvoice->removePaymentMessage($_POST['rowid']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getpaymentclientmessages()
    {
        if ($_POST['client_nip']) {
            echo $this->clientinvoice->getPaymentMessages($_POST['client_nip']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function splitclientpayments()
    {
        if (isset($_POST['client_id'])) {
            echo json_encode($this->splitPayments($_POST['client_id']));
        } else {
            echo "clientId is required";
        }
    }

    function deleteinvoicepayment()
    {
        if ($_POST['payment_id']) {
            echo json_encode($this->deletePaymentById($_POST['payment_id']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function updateinvoicepayment()
    {
        if ($_POST['payment_id'] && $_POST['price']) {
            echo json_encode($this->updatePaymentById($_POST['payment_id'], $_POST['price']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }


    function showclient()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));
        $smarty->assign('clientNIP', $this->_queryString[0]);
    }

    function showclientdata()
    {
        global $smarty;
        $clientTaxNo = $_POST['clientNIP'];
        $dateFrom = $_POST['startDate'];
        $dateTo = $_POST['endDate'];

        $invoices = $this->getInvoicesByClientTaxNo($clientTaxNo, $dateFrom, $dateTo);

        $client = $this->clientinvoice->getClientByTaxNb($clientTaxNo, $activeOnly = false);
        $smarty->assign('client', $client);

        $invoices = array_map(
            fn($invoice) => array(
                'data' => $invoice['issue_date'],
                'winien' => $invoice['price_gross'],
                'ma' => null,
                'treść' => $invoice['number'],
                'uwagi' => '',
                'className' => 'text-danger'), $invoices);

        $clientId = $this->getClientIdByTaxNo($clientTaxNo);
        $payments = $this->getClientPayments($clientId, $dateFrom, $dateTo);

        $notProcessedPayments = $this->clientinvoice->getNotProcessedPaymentsByClientTaxNo($clientTaxNo, $dateFrom, $dateTo);


        $notProcessedPayments = array_map(
            fn($payment) => array(
                'data' => $payment['issue_date'],
                'winien' => null,
                'ma' => $payment['price_gross'],
                'treść' => $payment['content'],
                'uwagi' => 'Nieprzeprocesowana!',
                'className' => 'text-secondary'),
            $notProcessedPayments);

        $payments = array_map(
            fn($payment) => array(
                'data' => (new DateTime($payment['paid_date']))->format('Y-m-d'),
                'winien' => null,
                'ma' => $payment['price'],
                'treść' => $payment['name'],
                'uwagi' => '',
                'className' => 'text-success'), $payments);

        $payments = array_merge($payments, $notProcessedPayments);
        $accountingSettlements = array_merge($invoices, $payments);

        if (empty($accountingSettlements)) {
            $smarty->assign('isEmptyMessage', 'Dla podanego zakresu dat nie ma żadnych dokumentów.');
            return;
        }

        usort($accountingSettlements, fn($a, $b) => strcmp($b['data'], $a['data']));

        $ROW_CLASS_NAME = 'className';

        $columnNames = array_filter(array_keys($accountingSettlements[0]), fn($key) => $key !== $ROW_CLASS_NAME);

        $columnSummaries = array_map(fn($columnName) => array_sum(array_map(fn($val) => is_numeric($val) ? $val : 0, array_column($accountingSettlements, $columnName))), $columnNames);

        $columnSummaries[count($columnSummaries) - 2] = round($columnSummaries[count($columnSummaries) - 3] - $columnSummaries[count($columnSummaries) - 4], 2);

        $smarty->assign('columnNames', $columnNames);
        $smarty->assign('columnSummaries', $columnSummaries);
        $smarty->assign('accountingSettlements', $accountingSettlements);
        $smarty->assign('rowClassName', $ROW_CLASS_NAME);
    }

    function importinvoices()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            echo json_encode($this->clientinvoice->pullAllInvoices());
        }
    }

    function buildUnpaidAccordionModel(array $invoices, array $agreements): array
    {
        // 1) Zbuduj indeks umów po NIP (client_nip)
        $agreementsByNip = [];
        foreach ($agreements as $agr) {
            if (!is_array($agr)) {
                continue;
            }

            $nip = $this->normalizeNip($agr['client_nip'] ?? null);
            if ($nip === null) {
                continue;
            }

            // If there are multiple agreements for the same NIP, pick the "best" one:
            // prefer an active agreement (agreement_isactive == 1), otherwise keep the first one.
            if (!isset($agreementsByNip[$nip])) {
                $agreementsByNip[$nip] = $agr;
            } else {
                $currActive = !empty($agreementsByNip[$nip]['agreement_isactive']);
                $newActive  = !empty($agr['agreement_isactive']);
                if (!$currActive && $newActive) {
                    $agreementsByNip[$nip] = $agr;
                }
            }
        }

        $map = []; // clientId => client data

        foreach ($invoices as $inv) {
            $clientId = (string)($inv['client_id'] ?? '');
            if ($clientId === '') {
                continue;
            }

            $fallbackName = $inv['buyer_name'] ?? ('Client #' . $clientId);
            $buyerNip = $this->normalizeNip($inv['buyer_tax_no'] ?? null);

            // Amounts from the API are strings, e.g. "405.9" / "0.0"
            $priceGross = (float)($inv['price_gross'] ?? 0);
            $paid       = (float)($inv['paid'] ?? 0);
            $amountDue  = max(0.0, $priceGross - $paid);

            if ($amountDue <= 0.00001) {
                continue;
            }

            $currency = $inv['currency'] ?? 'PLN';

            if (!isset($map[$clientId])) {
                $map[$clientId] = [
                    'client_id' => $clientId,
                    'client_name' => $fallbackName,     // may be overridden by agreement
                    'client_nip' => $buyerNip,          // exposed for Smarty; may be overridden by agreement
                    'client_phone' => null,             // may be overridden by agreement if not empty
                    'agreement_client_id' => null,      // may be overridden by agreement if not empty
                    '_phone_ts' => 0,                   // internal
                    '_agreement_bound' => false,        // internal (avoid repeating binding)
                    'unpaid_count' => 0,
                    'unpaid_sum' => 0.0,
                    'currency' => $currency,
                    'oldest_due_date' => null,
                    'invoices' => [],
                ];
            } elseif ($map[$clientId]['client_nip'] === null && $buyerNip !== null) {
                // Fallback: if we didn't capture NIP earlier, take it from the invoice
                $map[$clientId]['client_nip'] = $buyerNip;
            }

            // 2) Bind agreement data (only once per clientId)
            if (
                !$map[$clientId]['_agreement_bound']
                && $buyerNip !== null
                && isset($agreementsByNip[$buyerNip])
            ) {
                $agr = $agreementsByNip[$buyerNip];

                $agrClientId = $agr['client_id'] ?? null; // or: $agr['rowid'] ?? null;
                if ($agrClientId !== null && $agrClientId !== '') {
                    $map[$clientId]['agreement_client_id'] = (string)$agrClientId;
                }

                // Prefer NIP from agreement (normalized) as the canonical one for the view
                $agrNip = $this->normalizeNip($agr['client_nip'] ?? null);
                if ($agrNip !== null) {
                    $map[$clientId]['client_nip'] = $agrNip;
                }

                // Name: take from agreement['client_name']
                if (!empty($agr['client_name'])) {
                    $map[$clientId]['client_name'] = $agr['client_name'];
                }

                // Phone: take from agreement['client_phone'] if not empty
                $agrPhone = trim((string)($agr['client_phone'] ?? ''));
                if ($agrPhone !== '') {
                    $map[$clientId]['client_phone'] = $agrPhone;
                    // Set _phone_ts high so invoice phone won't override it
                    $map[$clientId]['_phone_ts'] = PHP_INT_MAX;
                }

                $map[$clientId]['_agreement_bound'] = true;
            }

            $map[$clientId]['unpaid_count']++;
            $map[$clientId]['unpaid_sum'] += $amountDue;

            $due = $inv['payment_to'] ?? null;
            if ($due && (!$map[$clientId]['oldest_due_date'] || $due < $map[$clientId]['oldest_due_date'])) {
                $map[$clientId]['oldest_due_date'] = $due;
            }

            // 3) Fallback: phone from the newest invoice, only if we don't have agreement phone
            if ($map[$clientId]['_phone_ts'] !== PHP_INT_MAX) {
                $ts = $this->invoiceTimestampForPhone($inv);
                if ($ts >= $map[$clientId]['_phone_ts']) {
                    $phone = $this->buildInvoicePhoneString($inv);
                    if ($phone !== null) {
                        $map[$clientId]['client_phone'] = $phone;
                        $map[$clientId]['_phone_ts'] = $ts;
                    } elseif ($map[$clientId]['client_phone'] === null) {
                        $map[$clientId]['_phone_ts'] = $ts;
                    }
                }
            }

            // view_url
            $viewUrl = $inv['view_url'] ?? null;
            if (!empty($viewUrl)) {
                $viewUrl = fakturowniaUrl($viewUrl);
            }

            // payment status
            if (!empty($inv['cancelled'])) {
                $statusLabel = 'Anulowana';
                $statusType = 'cancelled';
            } elseif (!empty($inv['overdue?'])) {
                $statusLabel = 'Przeterminowana';
                $statusType = 'overdue';
            } elseif ((float)($inv['paid'] ?? 0) > 0) {
                $statusLabel = 'Częściowo opłacona';
                $statusType = 'partial';
            } else {
                $statusLabel = 'Nieopłacona';
                $statusType = 'issued';
            }

            $map[$clientId]['invoices'][] = [
                'id' => $inv['id'] ?? null,
                'number' => $inv['number'] ?? null,
                'issue_date' => $inv['issue_date'] ?? null,
                'sell_date' => $inv['sell_date'] ?? null,
                'due_date' => $inv['payment_to'] ?? null,
                'amount_due' => $amountDue,
                'price_gross' => $priceGross,
                'paid' => $paid,
                'currency' => $currency,
                'view_url' => $viewUrl,
                'payment_status' => $statusLabel,
                'payment_status_type' => $statusType,
            ];
        }

        // cleanup internal fields
        $clients = array_values($map);
        foreach ($clients as &$c) {
            unset($c['_phone_ts'], $c['_agreement_bound']);
        }
        unset($c);

        // Sort: 1) unpaid_count desc, 2) unpaid_sum desc, 3) name asc
        usort($clients, function ($a, $b) {
            $cmp = $b['unpaid_count'] <=> $a['unpaid_count'];
            if ($cmp !== 0) return $cmp;

            $cmp = $b['unpaid_sum'] <=> $a['unpaid_sum'];
            if ($cmp !== 0) return $cmp;

            return strcmp($a['client_name'], $b['client_name']);
        });

        // Sort invoices per client - newest first
        foreach ($clients as &$c) {
            usort($c['invoices'], function ($a, $b) {
                $aDate = $a['issue_date'] ?? $a['sell_date'] ?? $a['due_date'] ?? '';
                $bDate = $b['issue_date'] ?? $b['sell_date'] ?? $b['due_date'] ?? '';
                return $bDate <=> $aDate;
            });
        }
        unset($c);

        return $clients;
    }

    /**
     * Normalizuje NIP do samych cyfr, np. "899-247-56-20" => "8992475620".
     * Zwraca null jeśli brak/za krótki.
     */
    function normalizeNip($nip): ?string
    {
        if (empty($nip)) {
            return null;
        }
        $digits = preg_replace('/\D+/', '', (string)$nip);
        if ($digits === '') {
            return null;
        }
        return $digits;
    }

    /**
     * Timestamp "najnowszej faktury" do wyboru telefonu.
     * Priorytet: issue_date -> sell_date -> created_at
     */
    function invoiceTimestampForPhone(array $inv): int
    {
        foreach (['issue_date', 'sell_date', 'created_at'] as $key) {
            if (!empty($inv[$key]) && is_string($inv[$key])) {
                $ts = strtotime($inv[$key]);
                if ($ts !== false) {
                    return $ts;
                }
            }
        }
        return 0;
    }

    /**
     * Zwraca string z telefonami z JEDNEJ faktury:
     * - buyer_mobile_phone + buyer_phone
     * - obsługa wielu numerów w jednym polu (separator: , ; / |)
     * - deduplikacja, trim, join ", "
     */
    function buildInvoicePhoneString(array $inv): ?string
    {
        $phones = [];

        foreach (['buyer_mobile_phone', 'buyer_phone'] as $key) {
            if (empty($inv[$key]) || !is_string($inv[$key])) {
                continue;
            }

            $parts = preg_split('/[;,\/\|]+/', $inv[$key]) ?: [];
            foreach ($parts as $p) {
                $p = trim(preg_replace('/\s+/', ' ', $p));
                if ($p !== '') {
                    $phones[] = $p;
                }
            }
        }

        $phones = array_values(array_unique($phones));

        return $phones ? implode(', ', $phones) : null;
    }

}
