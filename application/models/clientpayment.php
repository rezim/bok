<?php
class clientpayment extends Model
{
    function getPayments($startDate, $endDate, $statementNb): array {

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

        return $this->query($query,null,false);
    }
}