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

        $topic = 'Raport platnosci za miesiac ' . $monthName . '.';

        $message = 'Dzień Dobry,' . '<br/><br/>' .
            'W załączeniu znajduje się plik z raportem.<br/><br/>' .
            'Pozdrawiamy,' . '<br/>' .
            'Zespół Otus.pl';

        $attachments = [["path" => $fileCSV, "filename" => $fileCSV]];

        $mailTo = $_SESSION['appConfig']['email_raportu_platnosci'];

        $mailing = new mailing();
        $mailing->sendNewMail($mailTo, $message, $topic, $attachments, $mailFrom = null, $mailFromName = null);
        unset($mailing);

        unlink($fileCSV);

        echo json_encode("OK");
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

        foreach ($notProcessedPayments as $idx => $payment) {
            try {
                $tax_no = isset($payment['nip']) ? $payment['nip'] : null;
                $paymentRowId = isset($payment['rowid']) ? $payment['rowid'] : 'unknown';

                if ($tax_no != '9102113580') {
                    $extClient = $this->getClientByTaxNo($tax_no);

                    if (empty($extClient) || !isset($extClient[0]['id'])) {
                        error_log('[clientpaymentsController::addClientsPayments] External client not found. payment_rowid=' . $paymentRowId . ', tax_no=' . (string)$tax_no);
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
                    $equalPriceInvoicesCount = count($equalPriceInvoices);
                    $invoice = $equalPriceInvoicesCount > 0 ? array_values($equalPriceInvoices)[0] : array_values($notPaidInvoices)[0];

                    $externalPayments = $this->addPayment($price, $invoice['id'], $extClientId, $tax_no, "Płatność za FV numer {$invoice['number']} - (automatyczna)", $payment['date'], $price);

                    if (!is_array($externalPayments) || count($externalPayments) === 0) {
                        error_log('[clientpaymentsController::addClientsPayments] Empty addPayment response. payment_rowid=' . $paymentRowId);
                        continue;
                    }

                    if (isset($externalPayments[0]['code']) && $externalPayments[0]['code'] === 'error') {
                        $errorPayload = json_encode($externalPayments[0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                        if ($errorPayload === false) {
                            $errorPayload = var_export($externalPayments[0], true);
                        }
                        error_log('[clientpaymentsController::addClientsPayments] addPayment error. payment_rowid=' . $paymentRowId . ', payload=' . $errorPayload);
                        continue;
                    }

                    $externalPayments = array_values(array_filter($externalPayments, function ($externalPayment) {
                        return is_array($externalPayment)
                            && isset($externalPayment['invoice_id'])
                            && !empty($externalPayment['invoice_id'])
                            && isset($externalPayment['id'])
                            && !empty($externalPayment['id']);
                    }));

                    if (count($externalPayments) === 0) {
                        error_log('[clientpaymentsController::addClientsPayments] Payment created but not linked to invoice. payment_rowid=' . $paymentRowId . ', expected_invoice_id=' . (string)$invoice['id']);
                        continue;
                    }

                    $processedPayments = array_map(function ($externalPayment) use (&$payment, &$notPaidInvoices) {
                        $invoiceId = $externalPayment['invoice_id'];
                        $invoiceNumber = isset($notPaidInvoices[$invoiceId]['number']) ? $notPaidInvoices[$invoiceId]['number'] : 'unknown';
                        return array(
                            "rowid_payments" => $payment['rowid'],
                            "ext_invoice_id" => $invoiceId,
                            "ext_invoice_nb" => $invoiceNumber,
                            "ext_payment_id" => $externalPayment['id'],
                            "ext_payment_name" => $externalPayment['name'],
                            "ext_payment_desc" => $externalPayment['description']
                        );
                    }, $externalPayments);

                    $this->clientpayment->addProcessedPayments($processedPayments);

                    array_push($allNewProcessedPayments, $payment);
                }
            } catch (Throwable $e) {
                error_log('[clientpaymentsController::addClientsPayments] Exception for payment_rowid=' . $paymentRowId . ': ' . $e->getMessage());
            }
        }
        // check once again after processing operation is done, to get list of all not processed
        $notProcessedPayments = $this->clientpayment->getNotProcessedPaymentsFromDate($PROCESSED_PAYMENTS_START_DATE);

        return array("succeedProcessedPayments" => $allNewProcessedPayments, "notProcessedPayments" => $notProcessedPayments);
    }

}
