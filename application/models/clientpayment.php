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
        $query = "SELECT p.*, substring(p.recipient_acount, -10) as nip, count(pp.rowid_payments) as ext_payments_count
                  FROM `payments` p left outer join payments_processed pp on p.rowid = pp.rowid_payments
                  WHERE date >= '${startDate}'
                  GROUP BY pp.rowid_payments
                  HAVING count(pp.rowid_payments) = 0";

        return $this->query($query, null, false);
    }

    function addProcessedPayments($processedPayments)
    {
        $results = array();
        foreach ($processedPayments as $processedPayment) {
            // check if we already have processed payments for given payment
            $query = "Select * From `payments_processed` WHERE rowid_payments = {$processedPayment['rowid_payments']} and ext_payment_id = {$processedPayment['ext_payment_id']}";
            $result = ($this->query($query, null, false));
            if (count($result) > 0) {

                // remove processed payments if already exists
                $this->update("DELETE FROM `payments_processed` WHERE rowid_payments = ? and ext_payment_id = ?", 'ii', array($processedPayment['rowid_payments'], $processedPayment['ext_payment_id']));

            }

            $fieldNamesWihTypes = array(
                "rowid_payments" => "integer",
                "ext_invoice_id" => "integer",
                "ext_invoice_nb" => "string",
                "ext_payment_id" => "integer",
                "ext_payment_name" => "string",
                "ext_payment_desc" => "string"
            );
            $result = $this->insertIntoTable("payments_processed", $fieldNamesWihTypes, $processedPayment);

            $results[] = $result;
        }

        return $results;
    }
}