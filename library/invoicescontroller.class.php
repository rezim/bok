<?php

class InvoicesController extends Controller
{

    function __construct($model, $controller, $action, $queryString)
    {
        parent::__construct($model, $controller, $action, $queryString);
    }

    function __destruct()
    {
        parent::__destruct();
    }

    function getClientByTaxNo($clientTaxNo)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/clients.json?'
            . 'tax_no=' . $clientTaxNo
            . '&api_token=' . FAKTUROWNIA_APITOKEN;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        $client = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $client;
    }

    function getOverdueInvoicesByClientId($clientId)
    {
        $invoices = $this->getInvoicesByClientId($clientId, false);

        return array_filter($invoices, fn($invoice) => isset($invoice['overdue?']) && $invoice['overdue?'] == true);
    }

    function getInvoicesByClientId($clientId, $isPaid)
    {
        $invoices = array();
        $perPage = 100;

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'client_id=' . $clientId
            . '&status=' . (($isPaid) ? 'paid' : 'not_paid')
            . '&order=issue_date'
            . '&per_page=' . $perPage
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $invoices = array_merge($invoices, $data);
            $pageNb++;
        } while (count($data) == $perPage);

        curl_close($ch);

        return $invoices;
    }

    function getInvoicesByDateRange($period, $dateFrom, $dateTo, $additionalFilters = '')
    {

        $ch = curl_init();
        $perPage = 100;
//        $pageNb = 1;
//
//        $max_multi_calls_count = 50;

        $invoices = array();

//        $curl_arr = array();
        $mh = curl_multi_init();

        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'period=' . $period
            . '&date_from=' . $dateFrom
            . '&date_to=' . $dateTo
            . '&api_token=' . FAKTUROWNIA_APITOKEN
            . '&per_page=' . $perPage
            . '&order=issue_date'
            . $additionalFilters;

        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $invoices = array_merge($invoices, $data);
            $pageNb++;
        } while (count($data) == $perPage);

        curl_close($ch);

        return $invoices;
    }


    function getNotPaidInvoicesByDateRange($period, $dateFrom, $dateTo)
    {
        $invoices = $this->getInvoicesByDateRange($period, $dateFrom, $dateTo);

        if (!(is_array($invoices))) {
            // $invoices is a status of error return from getInvoicesByDateRange()
            return $invoices;
        }

        foreach ($invoices as $key => $element) {
            // remove paid invoices
            if ($element["paid"] === $element["price_gross"]) {
                unset($invoices[$key]);
            }
//            else {
//                // remove if paidTo date has not been exceeded
//                $today = new DateTime();
//                $paymentToDate = new DateTime($element["payment_to"]);
//                if ($paymentToDate > $today) {
//                    unset($invoices[$key]);
//                }
//            }
        }

        $keys_to_remove = ["view_url", "warehouse_id", "token"];
        foreach ($keys_to_remove as $key) {
            array_walk($invoices, function (&$v) use ($key) {
                unset($v[$key]);
            });
        }

        return $invoices;
    }

    function addInvoice($kind, $number, $sellDate, $issueDate, $paymentTo, $buyerName, $buyerTaxNo, $buyerEmail,
                        $buyerPostCode, $buyerCity, $buyerStreet, $recipientId, $positions, $showDiscount, $internalNote,
                        $additionalInfo, $additionalInfoDesc)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "invoice" => array(
                "kind" => $kind,
                "number" => $number,
                "sell_date" => $sellDate,
                "issue_date" => $issueDate,
                "payment_to" => $paymentTo,
                "buyer_name" => $buyerName,
                "buyer_tax_no" => $buyerTaxNo,
                "buyer_email" => $buyerEmail,
                "buyer_post_code" => $buyerPostCode,
                "buyer_city" => $buyerCity,
                "buyer_street" => $buyerStreet,
                "recipient_id" => $recipientId,
                "positions" => $positions,
                "show_discount" => $showDiscount,
                "internal_note" => $internalNote,
                "additional_info" => $additionalInfo,
                "additional_info_desc" => $additionalInfoDesc
            )
        );

        $data_string = json_encode($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $result;
    }

    function removeInvoice($invoiceId)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/invoices/' . $invoiceId . '.json';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN
        );

        $data_string = json_encode($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $result;
    }

    function addPayment($price, $invoiceId, $clientId, $invoiceTaxNo, $name, $paidDate, $description)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments.json';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "banking_payment" => array(
                "name" => $name,
                "price" => $price,
                "invoice_id" => $invoiceId,
                "client_id" => $clientId,
                "invoice_tax_no" => $invoiceTaxNo,
                "paid_date" => $paidDate,
                "description" => $description,
                "paid" => true,
                "kind" => "api"
            )
        );
        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if (floatval($result['overpaid']) > 0) {
            $this->splitPayments($clientId);
        }

        return $result;
    }

    function updatePaymentById($paymentId, $price)
    {

        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments/' . $paymentId . '.json?';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "banking_payment" => array(
                "price" => $price
            )
        );
        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }


    public function deletePaymentById($paymentId)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments/' . $paymentId . '.json?'
            . 'api_token=' . FAKTUROWNIA_APITOKEN;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    function getClientPayments($clientId, $dateFrom)
    {
        $payments = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments.json?'
            . 'client_id=' . $clientId
            . '&date_from=' . $dateFrom
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $payments = array_merge($payments, $data);
            $pageNb++;
        } while (count($data) == 50);

        curl_close($ch);

        return $payments;
    }

    function getAllOverpaidPayments($clientId = null)
    {
        $payments = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments.json?'
            . 'status=overpaid'
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        if ($clientId) {
            $url .= '&client_id=' . $clientId;
        }
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $payments = array_merge($payments, $data);
            $pageNb++;
        } while (count($data) == 50);

        curl_close($ch);

        return $payments;
    }

    function splitPayments($clientId)
    {

        $overPaidPayments = $this->getAllOverpaidPayments($clientId);

        foreach ($overPaidPayments as $payment) {
            $notPaidInvoices = $this->getInvoicesByClientId($clientId, false);

            if (count($notPaidInvoices) > 0) {
                $this->splitPayment($notPaidInvoices, $payment);
            }
        }

        return 'OK';
    }

    // split single payment
    function splitPayment($invoices, $payment)
    {
        if (count($invoices) > 0 && $payment) {
            $overpaid = $payment['overpaid'];
            $paidDate = $payment['paid_date'];
            $this->updatePaymentById(
                $payment['id'],
                floatval($payment['price']) - floatval($payment['overpaid'])
            );

            $idx = 0;
            do {
                $invoice = $invoices[$idx];
                $leftToPay = floatval($invoice['price_gross']) - floatval($invoice['paid']);

                // if not enough overpaid for the invoice or it is last invoice,
                // pay all remaining many
                if ($leftToPay > $overpaid || $idx === count($invoices) - 1) {
                    $leftToPay = $overpaid;
                }

                $this->addPayment(
                    $leftToPay,
                    $invoice['id'],
                    $invoice['client_id'],
                    $invoice['buyer_tax_no'],
                    'rozksiegowanie',
                    $paidDate,
                    ''
                );

                $overpaid -= $leftToPay;

                $idx++;
            } while ($overpaid > 0 && $idx < count($invoices));
        }
    }

    function normalizeCurrencyValue($value)
    {
        return str_replace(',', '.', $value);
    }

    function markInterestNoteAsPaid($buyerTaxNo, $fileName, $invoiceNb, $date)
    {
        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;
        $interestNoteNamePrefix = INTEREST_NOTE_NAME_PREFIX;
        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
        $filePath = "{$dir}{$fileName}";
        if (file_exists($filePath)) {
            $paidDir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
            $interestNotePaidPrefix = INTEREST_NOTE_PAID_FOLDER_NAME . '-';
            $renamedFilePath = "{$paidDir}{$interestNotePaidPrefix}({$date})-{$fileName}";
            rename($filePath, $renamedFilePath);

            $mailing = new mailing();

            $mailing->sendInterestNoteEmail(INTEREST_NOTE_SEND_TO_ACCOUNTING_OFFICE,
                "Nota odsetkowa do FV numer: {$invoiceNb}",
                date_format(date_create($date), 'm/Y'),
                array(array("path" => $renamedFilePath, "filename" => "{$interestNoteNamePrefix}{$fileName}"))
            );

            $customerMessage = "Nota odsetkowa {$fileName} została opłacona {$date} i wysłana do biura rachunkowego.";
            $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);
            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');
        }

        return $this->resolveInterestNotes($buyerTaxNo);
    }

    function removeNotPaidInterestNote($buyerTaxNo, $fileName, $invoiceNb, $date)
    {
        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;

        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
        $filePath = "{$dir}{$fileName}";
        if (file_exists($filePath)) {
            unlink($filePath);

            $customerMessage = "Nota odsetkowa {$fileName} została usunięta {$date}!.";
            $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);
            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');
        }

        return $this->resolveInterestNotes($buyerTaxNo);
    }

    function getInterestNoteUrl($invoiceNb)
    {
        $today = date("Y-m-d");
        $payment_days = 7;
        $due_date = date('Y-m-d', strtotime($today . " + {$payment_days} days"));
        $host = preg_replace("/^http:/i", "https:", FAKTUROWNIA_ENDPOINT);
        $token = FAKTUROWNIA_APITOKEN;
        return "{$host}/invoices/{$invoiceNb}.pdf?api_token={$token}&print_option=interest_note&interest_rate=&interest_type=legal&forced_payment_to={$due_date}";
    }

    function resolveInterestNotes($buyerTaxNo)
    {

        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;
        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";

        // return $this->attachInterestNotesToInvoice('158136955', $dir, ['nota_1.pdf', 'nota_2.pdf', 'nota_3.pdf', 'nota_4.pdf']);

        $noteNames = glob("$dir/*.pdf");

        $notesWithDate = array_map(function ($filePath) {

            $parsedInterestNote = $this->readInterestNote($filePath);

            $fileName = basename($filePath);
            $timestamp = filemtime($filePath);
            return array("name" => $fileName, "path" => $filePath, "date" => date("Y-m-d H:i:s", $timestamp), "timestamp" => $timestamp, "amount" => $parsedInterestNote['amount'], "text" => $parsedInterestNote["text"]);
        }, $noteNames);

        usort($notesWithDate, function ($a, $b) {
            return $b["timestamp"] - $a["timestamp"];
        });

        return $notesWithDate;
    }

    function resolveNotPaidInterestNotes($buyerTaxNo)
    {
        $filterPaidInterestNotes = function ($interestNote) {
            return !startsWith($interestNote['name'], 'paid-(');
        };

        return array_filter($this->resolveInterestNotes($buyerTaxNo), $filterPaidInterestNotes);
    }

    function readInterestNote($filePath)
    {
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($filePath);
        $textArr = array_map(fn($lineOfText) => preg_replace("/\s+/", "", $lineOfText), preg_split('/\r\n|\r|\n/', $pdf->getText()));

        $result = array();

        /**
         * ...
         * 47: "Razem"
         * 48: "1,61PLN"
         * 49: "Słownie"
         * ...
         */
        $amountPosition = array_search("Słownie", $textArr);

        $result['text'] = $textArr;


        if ($amountPosition && count($textArr) > 2 && $textArr[$amountPosition - 2] === "Razem") {
            $result['amount'] = floatval(str_replace(",", ".", $textArr[$amountPosition - 1]));
        } else {
            $result['amount'] = -1;
        }

        return $result;
    }


    function resolveAllInterestNotes()
    {
        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;
        $interestNoteDir = "./{$interestNoteFolderName}/";

        if (!is_dir($interestNoteDir)) {
            return [];
        }

        $clientNips = scandir($interestNoteDir);

        $nipToInterestNotesMap = array();
        array_walk($clientNips, function (&$nip, $key) use (&$nipToInterestNotesMap) {
            if ($nip !== '.' && $nip !== '..') {
                $nipToInterestNotesMap[$nip] = $this->resolveInterestNotes($nip);
            }
        });
        return $nipToInterestNotesMap;
    }

    function issueInterestNote($id, $number, $buyerTaxNo, $buyerEmail, $sellDate, $paymentTo, $paidDate, $isLateDays)
    {
        $url = $this->getInterestNoteUrl($id);

        $interestNoteFolderName = INTEREST_NOTE_FOLDER_NAME;
        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $normalizedInvoiceNumber = str_replace('/', '-', $number);
        $fileName = "{$normalizedInvoiceNumber}.pdf";
        $filePath = "{$dir}{$fileName}";

        $result = array('status' => 0, 'path' => $filePath, 'file_name' => $fileName);

        $mail = array(
            "mailTo" => INTEREST_NOTE_DEBUG_SEND_TO !== '' ? INTEREST_NOTE_DEBUG_SEND_TO : $buyerEmail,
            "message" => "Dzień Dobry,<br /><br /> W załączniku przesyłamy notę odsetkową do faktury vat numer: {$number}.<br />Termin płatności faktury: {$paymentTo},<br />Data płatności faktury: {$paidDate},<br />Opóźnienie w płatności dni: {$isLateDays}.<br /><br />Prosimy o terminowe płatności,<br />pozdrawiamy,<br />Otus.pl",
            "topic" => "Nota odsetkowa do faktury vat {$number}.",
            "attachments" => array(array("path" => $filePath, "filename" => $fileName))
        );

        // $customerMessage = "Wysłano notę odsetkową {$fileName} na adres email: {$mail['mailTo']}.";
        $customerMessage = "Wystawiono notę odsetkową {$fileName}.";
        $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);
        if (file_exists($filePath)) {
            if (INTEREST_NOTE_SEND_EMAIL_TO_CLIENT) {
                $mailing = new mailing();
                $mailing->sendInterestNoteEmail(
                    $mail['mailTo'],
                    $mail['message'],
                    $mail['topic'],
                    $mail['attachments']
                );
                unset($mailing);
            }

            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');

            return array_merge($result, array('status' => -1, 'message' => 'file already exists'));
        }

        // Use file_get_contents() function to get the file
        // from url and use file_put_contents() function to
        // save the file by using base name
        if (file_put_contents($filePath, file_get_contents($url))) {
            if (INTEREST_NOTE_SEND_EMAIL_TO_CLIENT) {
                $mailing = new mailing();
                $mailing->sendInterestNoteEmail(
                    $mail['mailTo'],
                    $mail['message'],
                    $mail['topic'],
                    $mail['attachments']
                );
                unset($mailing);
            }

            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');

            return array_merge($result, array('message' => 'file created successful'));
        } else {
            return array_merge($result, array('status' => -1, 'message' => 'file download failed'));
        }
    }


    function addNotPaidInterestNotesToInvoice($invoiceId, $buyerTaxNo)
    {
        $interestNotes = $this->resolveInterestNotes($buyerTaxNo);
        $filterPaidInterestNotes = function ($note) {
            $paidNotePrefix = INTEREST_NOTE_PAID_FOLDER_NAME . '-';
            $len = strlen($paidNotePrefix);
            return (substr($note['name'], 0, $len) !== $paidNotePrefix);
        };

        $notPaidInterestNotes = array_filter($interestNotes, $filterPaidInterestNotes);

        if (count($notPaidInterestNotes) > 0) {
            $firstNote = $notPaidInterestNotes[0];
            $notePath = str_replace($firstNote['name'], '', $firstNote['path']);
            $resolveNoteName = function ($note) {
                return $note['name'];
            };
            $this->attachInterestNotesToInvoice($invoiceId, $notePath, array_map($resolveNoteName, $notPaidInterestNotes));
        }

        return array("status" => "OK", "notes" => $notPaidInterestNotes);
    }

    function attachInterestNotesToInvoice($invoiceNumber, $attachmentPath, $attachmentNames)
    {
        // configuration
        $token = FAKTUROWNIA_APITOKEN;
        $httpHost = FAKTUROWNIA_ENDPOINT;

        $invoicesUrl = "{$httpHost}/invoices/{$invoiceNumber}";

        // resolve s3 bucket credentials
        $url = "{$invoicesUrl}/get_new_attachment_credentials.json?api_token={$token}";
        $result = curl_get($url);

        if (isset($result['error'])) {
            return array_merge($result, array("Could not resolve s3 bucket credentials for new attachment. Error: {$result['message']}"));
        }
        $s3BucketCredentials = json_decode($result, true);
        unset($s3BucketCredentials['url']); // extra input fields are forbidden by s3 policy

        foreach ($attachmentNames as $attachmentName) {
            $attachmentFilePath = "{$attachmentPath}{$attachmentName}";
            $attachementFileNameWithPrefix = INTEREST_NOTE_NAME_PREFIX . $attachmentName;

            // send file to amazon s3 bucket
            $curlFile = new CURLFile(realpath($attachmentFilePath), 'application/pdf', $attachementFileNameWithPrefix);
            $amazonS3BucketUrl = 'https://s3-eu-west-1.amazonaws.com/fs.firmlet.com';

            $data = array_merge($s3BucketCredentials, array('file' => $curlFile));
            $result = curl_post($amazonS3BucketUrl, $data, false);
            if (isset($result['error'])) {
                return array_merge($result, array("message" => "Could not send file to s3 bucket. Error: {$result['message']}"));
            }

            // assign attachment to the invoice
            $url = "{$invoicesUrl}/add_attachment.json?api_token={$token}&file_name={$attachementFileNameWithPrefix}";
            $result = curl_post($url);
            if (isset($result['error'])) {
                return array_merge($result, array("Could not assign attachment {$attachementFileNameWithPrefix} to invoice {$invoiceNumber}. Error: {$result['error']}"));
            }
        }

        // set attachments are visible for the user
        $url = "{$invoicesUrl}.json";
        $data = array(
            "api_token" => $token,
            "invoice" => array(
                "show_attachments" => true
            )
        );
        $result = curl_put($url, $data);
        if (isset($result['error'])) {
            return array_merge($result, array("Could set attachments to be visible to the user for invoice {$invoiceNumber}. Error: {$result['error']}"));
        }

        return array("message" => "OK");
    }


    function sendOverduePaymentsReminder($invoices, $interestNotes, $buyerTaxNo)
    {

        $mailingBody = '';
        $fmt = new NumberFormatter('pl_PL', NumberFormatter::CURRENCY);
        $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'zł');
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

        if (count($invoices) > 0) {

            $invoicesAmount = array_sum(array_map(function ($note) {
                return floatval($note['price_gross']) - floatval($note['paid']);
            }, $invoices));

            $invoicesSummary = join('<br/>', array_map(function ($invoice) use (&$fmt) {
                $calculatedAmount = $fmt->format(floatval($invoice['price_gross']) - floatval($invoice['paid']));
                return "{$invoice['number']} na kwotę {$calculatedAmount} termin płatności {$invoice['payment_to']}";
            },
                $invoices));

            $mailingBody .= "$invoicesSummary<br /><br />pozostało do zapłaty faktury: <b>{$fmt->format($invoicesAmount)}</b><br /><br />";
        }

        if (count($interestNotes) > 0) {
            $interestNotesAmount = array_sum(array_map(function ($note) use (&$fmt) {
                return $fmt->format($note['amount']);
            }, $interestNotes));

            $interestNotesSummary = join('<br/>', array_map(function ($note) {
                $normalizedName = substr($note['name'], 0, -4);
                return "nota odsetkowa $normalizedName na kwotę {$note['amount']}";
            },
                $interestNotes));

            $mailingBody .= "$interestNotesSummary<br /><br />pozostało do zapłaty noty: <b>{$fmt->format($interestNotesAmount)}</b><br /><br />";
        }

        $customerMessage = '';
        if ($mailingBody !== '') {

            $overdueAmount = $fmt->format($invoicesAmount + $interestNotesAmount);

            $mailingBody = "Bardzo proszę o uregulowanie poniższej kwoty: <b>$overdueAmount</b> (Łącznie do zapłaty faktury i noty odsetkowe)<br /><br />" . $mailingBody;

            $mailing = new mailing();
            $mailing->sendNewOverduePaymentsMail(
                'tregimowicz@gmail.com',
                $mailingBody,
                "Przypomnienie o zaległych płatnościach"
            );
            unset($mailing);


            $customerMessage = "Wiadomość o zaległości w wysokości $overdueAmount, została wysłana do klienta.";
        } else {
            $customerMessage = "Klient nie posiada zaległości, wiadomość nie została wysłana.";

        }
        $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);
        $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');
    }

}

function curl_get($url, $useProxy = USE_PROXY)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    if ($useProxy) {
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response = array("error" => curl_errno($ch), "message" => curl_error($ch));
    }
    curl_close($ch);

    return $response;
}

function curl_post($url, $data = array(), $useProxy = USE_PROXY)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    if ($useProxy) {
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response = array("error" => curl_errno($ch), "message" => curl_error($ch));
    }
    curl_close($ch);

    return $response;
}

function curl_put($url, $data, $useProxy = USE_PROXY)
{
    $ch = curl_init();

    if ($useProxy) {
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );
    if (USE_PROXY) {
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response = array("error" => curl_errno($ch), "message" => curl_error($ch));
    }
    curl_close($ch);

    return $response;
}