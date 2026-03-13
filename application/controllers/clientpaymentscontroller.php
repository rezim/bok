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
        $runId = uniqid('client_payments_', true);
        $startedAt = microtime(true);

        // this is because for older payments we do not have records in `payments_processed` table,
        // therefore we do not know if they were processed or not
        $PROCESSED_PAYMENTS_START_DATE = PROCESSED_PAYMENTS_START_DATE;

        error_log(sprintf(
            '[clientpaymentsController::addClientsPayments][%s] START. PROCESSED_PAYMENTS_START_DATE=%s',
            $runId,
            $PROCESSED_PAYMENTS_START_DATE
        ));

        $notProcessedPayments = $this->clientpayment->getNotProcessedPaymentsFromDate($PROCESSED_PAYMENTS_START_DATE);
        error_log(sprintf(
            '[clientpaymentsController::addClientsPayments][%s] Loaded not processed payments count=%d',
            $runId,
            is_array($notProcessedPayments) ? count($notProcessedPayments) : 0
        ));

        $allNewProcessedPayments = array();

        foreach ($notProcessedPayments as $idx => $payment) {
            try {
                $tax_no = isset($payment['nip']) ? $payment['nip'] : null;
                $paymentRowId = isset($payment['rowid']) ? $payment['rowid'] : 'unknown';
                $paymentDate = isset($payment['date']) ? $payment['date'] : 'unknown';
                $paymentAmountCents = isset($payment['amount']) ? $payment['amount'] : 'unknown';

                error_log(sprintf(
                    '[clientpaymentsController::addClientsPayments][%s] Processing payment idx=%d rowid=%s nip=%s date=%s amount_cents=%s',
                    $runId,
                    $idx,
                    $paymentRowId,
                    (string)$tax_no,
                    $paymentDate,
                    (string)$paymentAmountCents
                ));

                if ($tax_no != '9102113580') {
                    $extClient = $this->getClientByTaxNo($tax_no);
                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] getClientByTaxNo(%s) returned count=%d',
                        $runId,
                        (string)$tax_no,
                        is_array($extClient) ? count($extClient) : 0
                    ));

                    if (empty($extClient) || !isset($extClient[0]['id'])) {
                        error_log(sprintf(
                            '[clientpaymentsController::addClientsPayments][%s] External client not found for tax_no=%s, payment_rowid=%s, payment_date=%s, payment_amount=%s',
                            $runId,
                            (string)$tax_no,
                            $paymentRowId,
                            $paymentDate,
                            (string)$paymentAmountCents
                        ));
                        continue;
                    }
                    $extClientId = $extClient[0]['id'];
                } else {
                    $extClientId = '158948316';
                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] Using hardcoded extClientId=%s for tax_no=%s',
                        $runId,
                        $extClientId,
                        (string)$tax_no
                    ));
                }

                error_log(sprintf(
                    '[clientpaymentsController::addClientsPayments][%s] Selected extClientId=%s for payment_rowid=%s',
                    $runId,
                    (string)$extClientId,
                    $paymentRowId
                ));

                $notPaidInvoices = $this->getInvoicesByClientId($extClientId, false);
                error_log(sprintf(
                    '[clientpaymentsController::addClientsPayments][%s] getInvoicesByClientId(%s, false) returned count=%d',
                    $runId,
                    (string)$extClientId,
                    is_array($notPaidInvoices) ? count($notPaidInvoices) : 0
                ));

                $invoiceKeys = array_map(function ($invoice) {
                    return $invoice['id'];
                }, $notPaidInvoices);
                $notPaidInvoices = array_combine($invoiceKeys, $notPaidInvoices);

                if (count($notPaidInvoices) > 0) {
                    $price = $payment['amount'] / 100;
                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] Calculated price=%s from amount_cents=%s for payment_rowid=%s',
                        $runId,
                        (string)$price,
                        (string)$paymentAmountCents,
                        $paymentRowId
                    ));

                    $equalPriceInvoices = array_filter($notPaidInvoices, fn($inv) => floatval($inv['price_gross']) == $price && floatval($inv['paid'] == 0));
                    $equalPriceInvoicesCount = count($equalPriceInvoices);
                    $invoice = $equalPriceInvoicesCount > 0 ? array_values($equalPriceInvoices)[0] : array_values($notPaidInvoices)[0];

                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] Chosen invoice id=%s number=%s equal_price_candidates=%d total_not_paid=%d',
                        $runId,
                        isset($invoice['id']) ? (string)$invoice['id'] : 'unknown',
                        isset($invoice['number']) ? (string)$invoice['number'] : 'unknown',
                        $equalPriceInvoicesCount,
                        count($notPaidInvoices)
                    ));

                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] Calling addPayment(price=%s, invoice_id=%s, extClientId=%s, tax_no=%s, payment_date=%s)',
                        $runId,
                        (string)$price,
                        isset($invoice['id']) ? (string)$invoice['id'] : 'unknown',
                        (string)$extClientId,
                        (string)$tax_no,
                        $paymentDate
                    ));

                    $externalPayments = $this->addPayment($price, $invoice['id'], $extClientId, $tax_no, "Płatność za FV numer {$invoice['number']} - (automatyczna)", $payment['date'], $price);
                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] addPayment returned type=%s count=%d for payment_rowid=%s',
                        $runId,
                        gettype($externalPayments),
                        is_array($externalPayments) ? count($externalPayments) : 0,
                        $paymentRowId
                    ));

                    if (!is_array($externalPayments) || count($externalPayments) === 0) {
                        error_log(sprintf(
                            '[clientpaymentsController::addClientsPayments][%s] No external payments created for payment_rowid=%s',
                            $runId,
                            $paymentRowId
                        ));
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

                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] Prepared processedPayments count=%d for payment_rowid=%s',
                        $runId,
                        count($processedPayments),
                        $paymentRowId
                    ));

                    $this->clientpayment->addProcessedPayments($processedPayments);
                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] addProcessedPayments done for payment_rowid=%s',
                        $runId,
                        $paymentRowId
                    ));

                    array_push($allNewProcessedPayments, $payment);
                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] Payment marked as successfully processed. payment_rowid=%s total_success=%d',
                        $runId,
                        $paymentRowId,
                        count($allNewProcessedPayments)
                    ));
                } else {
                    error_log(sprintf(
                        '[clientpaymentsController::addClientsPayments][%s] No unpaid invoices found for extClientId=%s and payment_rowid=%s',
                        $runId,
                        (string)$extClientId,
                        $paymentRowId
                    ));
                }
            } catch (Throwable $e) {
                error_log(sprintf(
                    '[clientpaymentsController::addClientsPayments][%s] EXCEPTION while processing payment idx=%d rowid=%s: %s at %s:%d',
                    $runId,
                    isset($idx) ? $idx : -1,
                    isset($payment['rowid']) ? $payment['rowid'] : 'unknown',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                ));
                error_log(sprintf(
                    '[clientpaymentsController::addClientsPayments][%s] EXCEPTION TRACE: %s',
                    $runId,
                    $e->getTraceAsString()
                ));
            }
        }
        // check once again after processing operation is done, to get list of all not processed
        $notProcessedPayments = $this->clientpayment->getNotProcessedPaymentsFromDate($PROCESSED_PAYMENTS_START_DATE);

        error_log(sprintf(
            '[clientpaymentsController::addClientsPayments][%s] END. succeedProcessedPayments=%d notProcessedPayments=%d duration_seconds=%.3f',
            $runId,
            count($allNewProcessedPayments),
            is_array($notProcessedPayments) ? count($notProcessedPayments) : 0,
            microtime(true) - $startedAt
        ));

        return array("succeedProcessedPayments" => $allNewProcessedPayments, "notProcessedPayments" => $notProcessedPayments);
    }

}
