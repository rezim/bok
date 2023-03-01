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

    function getagreements()
    {
        echo $this->clientinvoice->getAgreements();
    }

    function getinvoices()
    {
        $this->validatePostParams(['period', 'date_from', 'date_to']);

        $period = $_POST['period'];
        $dateFrom = $_POST['date_from'];
        $dateTo = $_POST['date_to'];

        if (isset($_POST['status']) && $_POST['status'] === 'not_paid_or_partial') {
            echo json_encode(
                $this->getNotPaidOrPartialInvoicesByDateRange($period, $dateFrom, $dateTo));
        } else {
            echo json_encode(
                $this->getInvoicesByDateRange($period, $dateFrom, $dateTo));
        }
    }

    function sendpaimentreminder()
    {
        if (!$_POST['client_id'] || !$_POST['client_nip'] || !$_POST['client_email']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "blędne parametery wejściowe";
            return;
        }

        try {
            // send all not paid invoices //$this->getOverdueInvoicesByClientId($_POST['client_id']);
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
        $this->validatePostParams($required);

        echo json_encode($this->removeInvoice($_POST['invoice_id']));
    }

    function addnewinvoice()
    {
        $required = ['kind', 'sell_date', 'issue_date', 'payment_to', 'buyer_name', 'buyer_tax_no',
            'buyer_email', 'buyer_post_code', 'buyer_city', 'buyer_street', 'positions',
            'show_discount', 'internal_note', 'additional_info', 'additional_info_desc'];

        $this->validatePostParams($required);

        echo json_encode(
            $this->addInvoice(
                $_POST['kind'], $_POST['number'], $_POST['sell_date'], $_POST['issue_date'], $_POST['payment_to'], $_POST['buyer_name'],
                $_POST['buyer_tax_no'], $_POST['buyer_email'], $_POST['buyer_post_code'], $_POST['buyer_city'], $_POST['buyer_street'],
                $_POST['recipient_id'], $_POST['positions'], $_POST['show_discount'], $_POST['internal_note'], $_POST['additional_info'],
                $_POST['additional_info_desc'])
        );
    }

    function addinvoicepayment()
    {
        $required = ['price', 'invoice_id', 'invoice_tax_no', 'client_id', 'paid_name', 'paid_date'];

        $this->validatePostParams($required);


//            $payment =   $this->addPayment(
//                    $_POST['price'],
//                    $_POST['invoice_id'],
//                    $_POST['client_id'],
//                    $_POST['invoice_tax_no'],
//                    $_POST['paid_name'],
//                    $_POST['paid_date'],
//                    $this->normalizeCurrencyValue($_POST['price']));

        $payment = $this->getPaymentById(6941634);

        if (!isset($payment)) {
            $this->internalServerError("Nie można dodać płatności");
        }

        $invoice = $this->getInvoiceById($payment['invoice_id']);

        if (!isset($invoice)) {
            $this->internalServerError("Nie można pobrać faktury dla zadanej płatności");
        }

        $client = $this->clientinvoice->getClientByTaxNb($invoice['buyer_tax_no']);

        if (!isset($client)) {
            $this->internalServerError("Nie można znaleźć klienta");
        }

        list('naliczacodsetki' => $client_create_interest_notes, 'rowid' => $client_id, 'nip' => $client_tax_nb) = $client;

        // TODO [TR]: for debug purposes only
        $client['mailfaktury'] = 'tregimowicz@gmail.com';

        if ($client_create_interest_notes) {

            $isInvoicePaid = $this->isInvoicePaid($invoice);

            if ($isInvoicePaid) {
                $lateDays = $this->getPaidInvoiceLateDays($invoice);
                if ($lateDays > 0) {
                    list('id' => $id, 'number' => $inv_number, 'buyer_tax_no' => $buyer_tax_no, 'sell_date' => $sell_date, 'payment_to' => $payment_to, 'view_url' => $inv_view_url) = $invoice;
                    $interestNote = $this->issueInterestNote($id, $inv_number, $buyer_tax_no, $client['mailfaktury'], $sell_date, $payment_to, $payment_to, $lateDays );

                    list('number' => $note_nb, 'amount' => $note_amount, 'path' => $note_path, 'timestamp' => $note_timestamp) = $interestNote;

                    $this->clientinvoice->createInterestNote($client_id, $client_tax_nb, $inv_number,
                        $note_nb, floatval($note_amount) * 100, $note_path, $inv_view_url, $note_timestamp);
                }
            }
        }


        echo json_encode($payment);
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
        $allInterestNotes = $this->resolveAllInterestNotes();
        $interestNotesCount = 0;
        foreach ($allInterestNotes as $nip => $notes) {

            $client = $this->clientinvoice->getClientByTaxNb($nip);
            list('rowid' => $client_id, 'nip' => $client_tax_nb) = $client;


            foreach ($notes as $note) {

                $interestNotesCount++;

                $invoices = $this->getInvoicesByQuery( $note['number'] );

                if (count($invoices) === 0) {
                    echo $note['number'] . ',';
                    continue;
                } else {

                    $invoices = $this->filterArrayByKeyValue($invoices, 'number', $note['number']);

                    if (count($invoices) !== 1) {
                        echo $note['number'] . ',';
                        continue;
                    }
                }

                if (!isset($invoices[0])) {
                    echo $note['number'];
                } else {
                    $invoice = $invoices[0];
                }

                list('number' => $inv_number, 'view_url' => $inv_view_url) = $invoice;


                list('number' => $note_nb, 'amount' => $note_amount, 'path' => $note_path, 'timestamp' => $note_timestamp) = $note;

                $success = preg_match("/paid-\(.*\)/", $note_path, $match);

                $paid_date = $success ? substr($match[0], 6, -1) : null;

                $paid = $paid_date ? 1 : 0;

                $result = $this->clientinvoice->createInterestNote($client_id, $client_tax_nb, $inv_number,
                    $note_nb, floatval($note_amount) * 100, $note_path, $inv_view_url, $note_timestamp, $paid, $paid_date);

                if (isset($result['status']) && $result['status'] !== 1) {
                    echo $note['number'] . $result['info'] . "<br />";
                }

            }
        }
        echo json_encode($allInterestNotes); // $this->clientinvoice->getInterestNotesGroupedByNip();
    }

    /**
     * addInterestNotesInvoice()
     *
     */
    function addinterestnotestoinvoice()
    {
        $this->validatePostParams(['invoice_id', 'nip']);

        echo json_encode($this->addNotPaidInterestNotesToInvoice($_POST['invoice_id'], $_POST['nip']));
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
            echo $this->splitPayments($_POST['client_id']);
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
}
