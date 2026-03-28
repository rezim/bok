<?php

class clientpayment extends Model
{
    function getPayments($startDate, $endDate, $statementNb): array
    {

        $query = "SELECT 
                    '${statementNb}' as 'Numer wyciągu',
                    DATE_FORMAT(date, \"%d-%m-%Y\") as 'Data ksiegowania',
                    DATE_FORMAT(date, \"%d-%m-%Y\") as 'Data operacji (transakcji)',
                    CONCAT('\"',details,'\"') as 'Tytuł operacji',
                    'Santander Bank Polska S.A.' as 'Dane strony operacji (beneficjenta)',
                    recipient_acount as 'Rachunek strony operacji',
                    '' as 'Kurs wymiany',
                    '' as 'Kwota drugiej strony',
                    '' as 'Typ operacji',
                    '' as 'Dane SEPA',
                    '' as 'Kwota WN',
                    CONCAT('\"',FORMAT(amount/100, 2, 'pl_PL'),'\"') as 'Kwota MA',
                    '' as 'Saldo',
                    ROW_NUMBER() OVER (),
                    'N' as 'Zmiana salda'
                    FROM `payments` 
                    where date >= '${startDate}' and date <= '${endDate}'";

        return $this->query($query, null, false);
    }

    function getClientTaxNbsFromPayments($tax_no = null): array
    {
        $where = $tax_no ? "WHERE substr(`recipient_acount`,17) = '${tax_no}'" : "";
        $query = "SELECT
                    count(*) as count, substr(`recipient_acount`,17) as nip
                    FROM `payments` 
                    {$where}                    
                    GROUP BY recipient_acount 
                    ORDER BY count(*) desc";

        return $this->query($query, null, false);
    }

    function updatePaymentsWithExternalInvoiceAndPayments(string $paidDate, int $amount, string $account, string $invoice_nb, string $payment_nb)
    {
        $query = "select * from payments where date='{$paidDate}' and amount={$amount} and recipient_acount='{$account}' and invoice_nb is null and payment_nb is null";

        $existingResults = $this->query($query);

        if (count($existingResults) > 0) {
            $rowId = $existingResults[0]['rowid'];

            $updateResult = $this->update("update payments set `invoice_nb`=?, `payment_nb`=? where `rowid`=?", 'ssi', array($invoice_nb, $payment_nb, $rowId));

            $updateResult['status'] = count($existingResults);

            return $updateResult;

        } else {
            return "Payment Not Exists, account {$account} paidDate {$paidDate} amount {$amount} invoice {$invoice_nb} payment {$payment_nb}";
        }

    }

    function getPaymentsByDateRange($startDate, $endDate)
    {
        $query = "SELECT *, substring(recipient_acount, -10) as nip FROM `payments`
                    where date >= '${startDate}' and date <= '${endDate}'";

        return $this->query($query, null, false);
    }

    function getNotProcessedPaymentsFromDate($startDate)
    {
        $query = "SELECT p.*, substring(p.recipient_acount, -10) as nip, pp.rowid_payments 
                  FROM `payments` p left outer join payments_processed pp on p.rowid = pp.rowid_payments 
                  WHERE date >= '${startDate}' and pp.rowid_payments is NULL;";

        return $this->query($query, null, false);
    }

    function addProcessedPayments($processedPayments)
    {
        $runId = uniqid('add_processed_payments_', true);
        error_log(sprintf(
            '[clientpayment::addProcessedPayments][%s] START count=%d',
            $runId,
            is_array($processedPayments) ? count($processedPayments) : 0
        ));

        $results = array();
        foreach ($processedPayments as $idx => $processedPayment) {
            try {
                $rowidPayments = isset($processedPayment['rowid_payments']) ? (int)$processedPayment['rowid_payments'] : 0;
                $extPaymentId = isset($processedPayment['ext_payment_id']) ? (int)$processedPayment['ext_payment_id'] : 0;
                $extInvoiceId = isset($processedPayment['ext_invoice_id']) ? (int)$processedPayment['ext_invoice_id'] : 0;
                $extInvoiceNb = isset($processedPayment['ext_invoice_nb']) ? (string)$processedPayment['ext_invoice_nb'] : 'unknown';

                error_log(sprintf(
                    '[clientpayment::addProcessedPayments][%s] Row idx=%d rowid_payments=%d ext_payment_id=%d ext_invoice_id=%d ext_invoice_nb=%s',
                    $runId,
                    $idx,
                    $rowidPayments,
                    $extPaymentId,
                    $extInvoiceId,
                    $extInvoiceNb
                ));

                if ($rowidPayments <= 0 || $extPaymentId <= 0) {
                    error_log(sprintf(
                        '[clientpayment::addProcessedPayments][%s] INVALID IDENTIFIERS idx=%d rowid_payments=%s ext_payment_id=%s',
                        $runId,
                        $idx,
                        isset($processedPayment['rowid_payments']) ? (string)$processedPayment['rowid_payments'] : 'missing',
                        isset($processedPayment['ext_payment_id']) ? (string)$processedPayment['ext_payment_id'] : 'missing'
                    ));
                    $results[] = array(
                        'status' => 0,
                        'info' => 'Invalid identifiers in processed payment payload',
                        'idx' => $idx
                    );
                    continue;
                }

                // check if we already have processed payments for given payment
                $existingResults = $this->selectWithPDO(
                    'SELECT rowid FROM payments_processed WHERE rowid_payments = :rowid_payments AND ext_payment_id = :ext_payment_id AND ext_invoice_id = :ext_invoice_id',
                    array(
                        ':rowid_payments' => $rowidPayments,
                        ':ext_payment_id' => $extPaymentId,
                        ':ext_invoice_id' => $extInvoiceId,
                    )
                );

                $existingCount = is_array($existingResults) ? count($existingResults) : 0;
                error_log(sprintf(
                    '[clientpayment::addProcessedPayments][%s] Existing processed rows=%d for rowid_payments=%d ext_payment_id=%d ext_invoice_id=%d',
                    $runId,
                    $existingCount,
                    $rowidPayments,
                    $extPaymentId,
                    $extInvoiceId
                ));

                if ($existingCount > 0) {
                    // remove processed payments if already exists
                    $deleteResult = $this->update(
                        'DELETE FROM `payments_processed` WHERE rowid_payments = ? and ext_payment_id = ? and ext_invoice_id = ?',
                        'iii',
                        array($rowidPayments, $extPaymentId, $extInvoiceId)
                    );
                    error_log(sprintf(
                        '[clientpayment::addProcessedPayments][%s] Delete existing result status=%s rows_affected=%s info=%s',
                        $runId,
                        isset($deleteResult['status']) ? (string)$deleteResult['status'] : 'unknown',
                        isset($deleteResult['rows_affected']) ? (string)$deleteResult['rows_affected'] : 'unknown',
                        isset($deleteResult['info']) ? (string)$deleteResult['info'] : 'unknown'
                    ));
                }

                $fieldNamesWihTypes = array(
                    'rowid_payments' => 'integer',
                    'ext_invoice_id' => 'integer',
                    'ext_invoice_nb' => 'string',
                    'ext_payment_id' => 'integer',
                    'ext_payment_name' => 'string',
                    'ext_payment_desc' => 'string'
                );
                $insertResult = $this->insertIntoTable('payments_processed', $fieldNamesWihTypes, $processedPayment);

                error_log(sprintf(
                    '[clientpayment::addProcessedPayments][%s] Insert result status=%s rowid=%s info=%s',
                    $runId,
                    isset($insertResult['status']) ? (string)$insertResult['status'] : 'unknown',
                    isset($insertResult['rowid']) ? (string)$insertResult['rowid'] : 'unknown',
                    isset($insertResult['info']) ? (string)$insertResult['info'] : 'unknown'
                ));

                if (isset($insertResult['status']) && (int)$insertResult['status'] !== 1) {
                    error_log(sprintf(
                        '[clientpayment::addProcessedPayments][%s] Insert query failure details query=%s',
                        $runId,
                        isset($insertResult['query']) ? (string)$insertResult['query'] : 'unknown'
                    ));
                }

                $results[] = $insertResult;
            } catch (Throwable $e) {
                error_log(sprintf(
                    '[clientpayment::addProcessedPayments][%s] EXCEPTION idx=%d rowid_payments=%s ext_payment_id=%s message=%s at %s:%d',
                    $runId,
                    $idx,
                    isset($processedPayment['rowid_payments']) ? (string)$processedPayment['rowid_payments'] : 'unknown',
                    isset($processedPayment['ext_payment_id']) ? (string)$processedPayment['ext_payment_id'] : 'unknown',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                ));
                error_log(sprintf(
                    '[clientpayment::addProcessedPayments][%s] EXCEPTION TRACE: %s',
                    $runId,
                    $e->getTraceAsString()
                ));

                $results[] = array(
                    'status' => 0,
                    'info' => $e->getMessage(),
                    'idx' => $idx
                );
            }
        }

        error_log(sprintf(
            '[clientpayment::addProcessedPayments][%s] END result_count=%d',
            $runId,
            count($results)
        ));

        return $results;
    }
}