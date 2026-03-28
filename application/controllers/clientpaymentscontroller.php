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

            usort($notPaidInvoices, function ($a, $b) {
                $aDate = $a['issue_date'] ?? $a['sell_date'] ?? $a['created_at'] ?? '';
                $bDate = $b['issue_date'] ?? $b['sell_date'] ?? $b['created_at'] ?? '';

                return strcmp((string)$aDate, (string)$bDate);
            });

            $invoiceKeys = array_map(function ($invoice) {
                return $invoice['id'];
            }, $notPaidInvoices);
            $notPaidInvoices = array_combine($invoiceKeys, $notPaidInvoices);

            if (count($notPaidInvoices) > 0) {
                $price = $payment['amount'] / 100;

                $invoiceIds = array_values(array_map(function ($invoice) {
                    return $invoice['id'];
                }, $notPaidInvoices));
                $firstInvoice = reset($notPaidInvoices);
                $paymentName = isset($firstInvoice['number'])
                    ? "Płatność za FV numer {$firstInvoice['number']} - (automatyczna)"
                    : 'Płatność automatyczna';

                $externalPayments = $this->addPayment($price, $invoiceIds, $extClientId, $tax_no, $paymentName, $payment['date'], $price);

                $processedPayments = array();
                foreach ($externalPayments as $externalPayment) {
                    if (!is_array($externalPayment) || !isset($externalPayment['id']) || empty($externalPayment['id'])) {
                        continue;
                    }

                    $linkedInvoices = array();
                    if (isset($externalPayment['invoices']) && is_array($externalPayment['invoices']) && count($externalPayment['invoices']) > 0) {
                        $linkedInvoices = $externalPayment['invoices'];
                    } elseif (isset($externalPayment['invoice_id']) && !empty($externalPayment['invoice_id'])) {
                        $linkedInvoices[] = array('id' => $externalPayment['invoice_id']);
                    }

                    foreach ($linkedInvoices as $linkedInvoice) {
                        $linkedInvoiceId = isset($linkedInvoice['id']) ? $linkedInvoice['id'] : null;
                        if (empty($linkedInvoiceId)) {
                            continue;
                        }

                        $processedPayments[] = array(
                            "rowid_payments" => $payment['rowid'],
                            "ext_invoice_id" => $linkedInvoiceId,
                            "ext_invoice_nb" => isset($notPaidInvoices[$linkedInvoiceId]['number']) ? $notPaidInvoices[$linkedInvoiceId]['number'] : 'unknown',
                            "ext_payment_id" => $externalPayment['id'],
                            "ext_payment_name" => $externalPayment['name'],
                            "ext_payment_desc" => $externalPayment['description']
                        );
                    }
                }

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
