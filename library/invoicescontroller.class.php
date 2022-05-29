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

    function geInvoicesByClientId($clientId, $isPaid)
    {
        $invoices = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'client_id=' . $clientId
            . '&status=' . (($isPaid) ? 'paid' : 'not_paid')
            . '&order=issue_date'
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
        } while (count($data) == 50);

        curl_close($ch);

        return $invoices;
    }

    function getInvoicesByDateRange($period, $dateFrom, $dateTo)
    {

        $max_multi_calls_count = 50;

        $invoices = array();

        $curl_arr = array();
        $mh = curl_multi_init();

        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'period=' . $period
            . '&date_from=' . $dateFrom
            . '&date_to=' . $dateTo
            . '&api_token=' . FAKTUROWNIA_APITOKEN;

        do {
            for ($i = 0; $i < $max_multi_calls_count; $i++) {

                $curl_arr[$i] = curl_init($url . '&page=' . $pageNb);
                curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
                if (USE_PROXY) {
                    curl_setopt($curl_arr[$i], CURLOPT_PROXY, '127.0.0.1:8888');
                }
                curl_multi_add_handle($mh, $curl_arr[$i]);

                $pageNb++;
            }

            do {
                $status = curl_multi_exec($mh, $running);
            } while ($running > 0 && $status === CURLM_OK);


            if ($status === CURLM_OK) {
                for ($i = 0; $i < $max_multi_calls_count; $i++) {
                    $results[] = curl_multi_getcontent($curl_arr[$i]);

                    curl_multi_remove_handle($mh, $curl_arr[$i]);

                    $data = json_decode(curl_multi_getcontent($curl_arr[$i]), true);

                    $invoices = array_merge($invoices, $data);
                }
            }
        } while (count($invoices) === ($pageNb - 1) * 50 && $status === CURLM_OK);

        curl_multi_close($mh);

        return ($status === CURLM_OK) ? $invoices : $status;
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
            $notPaidInvoices = $this->geInvoicesByClientId($clientId, false);

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
        $dir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
        $filePath = "{$dir}{$fileName}";
        if (file_exists($filePath)) {
            $paidDir = "./{$interestNoteFolderName}/{$buyerTaxNo}/";
            if (!is_dir($paidDir)) {
                mkdir($paidDir, 0777, true);
            }
            $interestNotePaidPrefix = INTEREST_NOTE_PAID_FOLDER_NAME . '-';
            $renamedFilePath = "{$paidDir}{$interestNotePaidPrefix}({$date})-{$fileName}";
            rename($filePath, $renamedFilePath);

            $mailing = new mailing();

            $mailing->sendInterestNoteEmail(INTEREST_NOTE_SEND_TO_ACCOUNTING_OFFICE,
                "Nota odsetkowa do FV numer: {$invoiceNb}",
                date_format(date_create($date), 'm/Y'),
                array(array("path" => $renamedFilePath, "filename" => "nota-$fileName"))
            );

            $customerMessage = "Nota odsetkowa {$fileName} została opłacona {$date} i wysłana do biura rachunkowego.";
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
            $fileName = basename($filePath);
            $timestamp = filemtime($filePath);
            return array("name" => $fileName, "path" => $filePath, "date" => date("Y-m-d H:i:s", $timestamp), "timestamp" => $timestamp);
        }, $noteNames);

        usort($notesWithDate, function ($a, $b) {
            return $b["timestamp"] - $a["timestamp"];
        });

        return $notesWithDate;
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

        $customerMessage = "Wysłano notę odsetkową {$fileName} na adres email: {$mail['mailTo']}.";
        $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);
        if (file_exists($filePath)) {
            $mailing = new mailing();
            $mailing->sendInterestNoteEmail(
                $mail['mailTo'],
                $mail['message'],
                $mail['topic'],
                $mail['attachments']
            );
            unset($mailing);

            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');

            return array_merge($result, array('status' => -1, 'message' => 'file already exists'));
        }

        // Use file_get_contents() function to get the file
        // from url and use file_put_contents() function to
        // save the file by using base name
        if (file_put_contents($filePath, file_get_contents($url))) {
            $mailing = new mailing();
            $mailing->sendInterestNoteEmail(
                $mail['mailTo'],
                $mail['message'],
                $mail['topic'],
                $mail['attachments']
            );
            unset($mailing);

            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');

            return array_merge($result, array('message' => 'file created successful'));
        } else {
            return array_merge($result, array('status' => -1, 'message' => 'file download failed'));
        }
    }


    function attachInterestNotesToInvoice($invoiceNumber, $attachmentPath, $attachmentNames) {
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

            // send file to amazon s3 bucket
            $curlFile = new CURLFile(realpath($attachmentFilePath), 'application/pdf');
            $amazonS3BucketUrl = 'https://s3-eu-west-1.amazonaws.com/fs.firmlet.com';

            $data = array_merge($s3BucketCredentials, array('file' => $curlFile));
            $result = curl_post($amazonS3BucketUrl, $data, false);
            if (isset($result['error'])) {
                return array_merge($result, array("message" => "Could not send file to s3 bucket. Error: {$result['message']}"));
            }

            // assign attachment to the invoice
            $url = "{$invoicesUrl}/add_attachment.json?api_token={$token}&file_name={$attachmentName}";
            $result = curl_post($url);
            if (isset($result['error'])) {
                return array_merge($result, array("Could not assign attachment {$attachmentName} to invoice {$invoiceNumber}. Error: {$result['error']}"));
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