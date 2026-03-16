<?php

class clientpaymentsController extends InvoicesController
{
    function sendpaymentsreport()
    {
        global $smarty;
        global $months;

        $today = date('Y-m-d');
        $previousMonth = date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $firstDayOfPreviousMonth = date('Y-m-01', strtotime($previousMonth));
        $lastDayOfPreviousMonth = date('Y-m-t', strtotime($previousMonth));

        $date = new DateTime($firstDayOfPreviousMonth);
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $statementNumber = $year . '/' . str_pad($month, 3, '0', STR_PAD_LEFT);
        $headerDate = implode("-", array($day, $month, $year));
        $monthName = $months[$month];

        $csvContent = $this->clientpayment->getPayments($firstDayOfPreviousMonth, $lastDayOfPreviousMonth, $statementNumber);

        $csvHeader = array($statementNumber, $headerDate, $headerDate, null, null, '86 1090 2398 0000 0001 5252 1901', 'PLN', null, null, null, null, null, null, count($csvContent), 'N');

        $fileCSV = 'Raport ' . $monthName . '.csv';

        $this->createCSVFile($fileCSV, $csvHeader, $csvContent);

        // Send file as download instead of email
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $fileCSV . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        readfile($fileCSV);
        
        unlink($fileCSV);
        exit;
    }

    function createCSVFile(&$fileName, $header, $content)
    {
        $handle = fopen($fileName, 'w');

        fputs($handle, implode(',', $header) . "\n");
        foreach ($content as $row) {
            fputs($handle, implode(',', $row) . "\n");
        }

        fclose($handle);
    }

    function getpaymentsbyclients()
    {
        $dateFrom = '2023-01-01';
        $clients = $this->clientpayment->getClientTaxNbsFromPayments('8992901258'); // '8361676510';

        foreach ($clients as $client) {
            $tax_no = $client['nip'];
            $extClient = $this->getClientByTaxNo($tax_no);
            if (count($extClient) === 1) {
                $extClientId = $extClient[0]['id'];
                $invoices = $this->getAllInvoices("client_id={$extClientId}&date_from={$dateFrom}");
                $invoiceKeys = array_map(function ($invoice) {
                    return $invoice['id'];
                }, $invoices);
                $invoices = array_combine($invoiceKeys, $invoices);

                $payments = $this->getClientPayments($extClientId, $dateFrom);

                $paymentAndInvoice = array();

                foreach ($payments as $payment) {
                    $paymentId = $payment['id'];
                    $invoiceId = $payment['invoice_id'];
                    $invoice = $invoices[$invoiceId];
                    $account = $invoice['buyer_mass_payment_code'];

                    $results = array();

                    if (strpos($account, 'SANTANDER') === 0) {

                        $paidDate = $invoice['paid_date'];
                        $amount = intval(floatval($invoice['paid']) * 100);
                        $account = str_replace(array("SANTANDER", " "), "", $account);

                        $updateResult = $this->clientpayment->updatePaymentsWithExternalInvoiceAndPayments($paidDate, $amount, $account, $invoiceId, $paymentId);

                        array_push($paymentAndInvoice, $updateResult);
                    }

                }

                echo json_encode(array("updates" => $paymentAndInvoice, "payments" => $payments, "invoices" => $invoices));
            }
        }


//        echo(json_encode($clients));
    }

    function addClientsPayments()
    {
        // this is because for older payments we do not have records in `payments_processed` table,
        // therefore we do not know if they were processed or not
        $PROCESSED_PAYMENTS_START_DATE = PROCESSED_PAYMENTS_START_DATE;

        $notProcessedPayments = $this->clientpayment->getNotProcessedPaymentsFromDate($PROCESSED_PAYMENTS_START_DATE);

        $allNewProcessedPayments = array();

        foreach ($notProcessedPayments as $payment) {

            $tax_no = $payment['nip'];

            if ($tax_no != '9102113580') {
                $extClient = $this->getClientByTaxNo($tax_no);
                if (empty($extClient) || !isset($extClient[0]['id'])) {
                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments] External client not found for tax_no=%s, payment_rowid=%s, payment_date=%s, payment_amount=%s',
                        $tax_no,
                        isset($payment['rowid']) ? $payment['rowid'] : 'unknown',
                        isset($payment['date']) ? $payment['date'] : 'unknown',
                        isset($payment['amount']) ? $payment['amount'] : 'unknown'
                    ));
                    continue;
                }
                $extClientId = $extClient[0]['id'];
            } else {
                $extClientId = '158948316';
            }
            $notPaidInvoices = $this->getInvoicesByClientId($extClientId, false);

            $invoiceKeys = array_map(function ($invoice) {
                return $invoice['id'];
            }, $notPaidInvoices);
            $notPaidInvoices = array_combine($invoiceKeys, $notPaidInvoices);

            if (count($notPaidInvoices) > 0) {
                $price = $payment['amount'] / 100;

                $equalPriceInvoices = array_filter($notPaidInvoices, fn($inv) => floatval($inv['price_gross']) == $price && floatval($inv['paid'] == 0));
                $invoice = count($equalPriceInvoices) > 0 ? array_values($equalPriceInvoices)[0] : array_values($notPaidInvoices)[0];

                $externalPayments = $this->addPayment($price, $invoice['id'], $extClientId, $tax_no, "Płatność za FV numer {$invoice['number']} - (automatyczna)", $payment['date'], $price);

                $processedPayments = array_values(array_filter(array_map(function ($externalPayment) use (&$payment, &$notPaidInvoices) {
                    $invoiceId = isset($externalPayment['invoice_id']) ? $externalPayment['invoice_id'] : null;

                    if (empty($invoiceId)) {
                        return null;
                    }

                    return array(
                        "rowid_payments" => $payment['rowid'],
                        "ext_invoice_id" => $invoiceId,
                        "ext_invoice_nb" => isset($notPaidInvoices[$invoiceId]['number']) ? $notPaidInvoices[$invoiceId]['number'] : 'unknown',
                        "ext_payment_id" => $externalPayment['id'],
                        "ext_payment_name" => $externalPayment['name'],
                        "ext_payment_desc" => $externalPayment['description']
                    );
                }, $externalPayments)));

                if (count($processedPayments) > 0) {
                    $this->clientpayment->addProcessedPayments($processedPayments);
                }

                array_push($allNewProcessedPayments, $payment);
            }
        }
        // check once again after processing operation is done, to get list of all not processed
        $notProcessedPayments = $this->clientpayment->getNotProcessedPaymentsFromDate($PROCESSED_PAYMENTS_START_DATE);

        return array("succeedProcessedPayments" => $allNewProcessedPayments, "notProcessedPayments" => $notProcessedPayments);
    }

}
