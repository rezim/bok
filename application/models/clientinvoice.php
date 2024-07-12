<?php

class clientinvoice extends Model
{
    protected $dataod = '', $datado = '', $filterklient = '', $filterdrukarka = '', $nazwakrotka = '';

    function getAgreements()
    {
        $query =
            "select c.rowid as client_id, c.nazwapelna as client_name, c.nip as client_nip, c.telefon as client_phone, c.mailfaktury as client_mailfaktury,
                    c.naliczacodsetki as client_naliczacodsetki, c.monitoringplatnosci as client_monitoringplatnosci,
                    a.nrumowy as agreement_id, a.rowid as agreement_rowid, c.terminplatnosci as agreement_paymentdate,
                    a.activity as agreement_isactive
             from agreements a inner join clients c on a.rowidclient = c.rowid
             where c.nip <> '0000000000' OR (c.nip = '0000000000' AND a.activity = 1)
             order by nazwakrotka";
        return json_encode($this->query($query, null, false));
    }

    function getPaymentMonitoredAgreements()
    {
        $query =
            "select c.rowid as client_id, c.nazwapelna as client_name, c.nip as client_nip, c.telefon as client_phone, c.mailfaktury as client_mailfaktury,
                    c.naliczacodsetki as client_naliczacodsetki,
                    a.nrumowy as agreement_id, a.rowid as agreement_rowid, c.terminplatnosci as agreement_paymentdate,
                    a.activity as agreement_isactive
             from agreements a inner join clients c on a.rowidclient = c.rowid
             where c.nip <> '0000000000' OR (c.nip = '0000000000' AND a.activity = 1) and c.monitoringplatnosci = 1
             order by nazwakrotka";
        return $this->query($query, null, false);
    }


    function addPaymentMessage($postParams, $tableName)
    {
        $postParams['active'] = 1;
        $postParams['owner'] = $_SESSION['user']['imie'] . ' ' . $_SESSION['user']['nazwisko'];
        $result = $this->insertFromPostParams($postParams, $tableName);

        $query = "select * from {$tableName} where rowid={$result['rowid']}";
        return json_encode($this->query($query, null, false));
    }

    function removePaymentMessage($rowid)
    {
        return $this->update
        (
            "update `payments_messages` 
                   set `active`=0
                   where `rowid`=?"
            , 'i',
            array
            (
                $rowid
            )
        );
    }

    function getPaymentMessages($client_nip)
    {
        $query = "select * from payments_messages where client_nip='{$client_nip}' and active = 1 order by message_date desc, created desc";
        return json_encode($this->query($query, null, false));
    }

    function getTrackedDeptors()
    {
        $query = "select nip from clients where monitoringplatnosci=1";
        return $this->query($query, null, false);
    }

    function getInterestNotes() {
        $query = "select * from interest_notes";

        return $this->query($query, null, false);
    }

    function getInterestNotesByNip($nip) {
        $query = "select * from interest_notes where nip='{$nip}'";

        return $this->query($query, null, false);
    }

    function createInterestNote($clientTaxNb, $externalClientId, $nip, $fileName, $filePath, $issueDate, $paymentToDate, $paidDate, $amount, $invoiceNb, $invoiceIssueDate, $invoicePaymentToDate, $invoicePaidDate, $invoiceAmount, $interestNotePaidDate,  $paid)
    {
        $getInterestNoteByFilePathAndInvoiceNb = "select * from interest_notes where file_path='{$filePath}' and invoice_nb='{$invoiceNb}'";

        $interestNoteExists = count($this->query($getInterestNoteByFilePathAndInvoiceNb)) > 0;

        if ($interestNoteExists) {
            return;
        }

        $client = $this->getClientByTaxNb($clientTaxNb, false);

        if (!$client) {
            return "Nie można pobrać klienta po NIP: " . $clientTaxNb;
        }

        $interestNote = array(
            'rowidclient' => $client['rowid'],
            'externalclientid' => $externalClientId,
            'nip' => $nip,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'issue_date' => $issueDate,
            'payment_to_date' => $paymentToDate,
            'paid_date' => $paidDate,
            'amount' => $amount,
            'invoice_nb' => $invoiceNb,
            'invoice_issue_date' => $invoiceIssueDate,
            'invoice_payment_to_date' => $invoicePaymentToDate,
            'invoice_paid_date' => $invoicePaidDate,
            'invoice_amount' => $invoiceAmount,
            'interest_note_paid_date' => $interestNotePaidDate,
            'paid' => $paid
        );

        $namesWihTypes = array(
            'rowidclient' => 'integer',
            'externalclientid' => 'integer',
            'nip' => 'string',
            'file_name' => 'string',
            'file_path' => 'string',
            'issue_date' => 'date',
            'payment_to_date' => 'date',
            'paid_date' => 'date',
            'amount' => 'currency',
            'invoice_nb' => 'string',
            'invoice_issue_date' => 'date',
            'invoice_payment_to_date' => 'date',
            'invoice_paid_date' => 'date',
            'invoice_amount' => 'currency',
            'interest_note_paid_date' => 'date',
            'paid' => 'boolean'
        );

        return $this->insertIntoTable('interest_notes', $namesWihTypes, $interestNote);
    }

    function getClientByTaxNb($clientTaxNb, $activeOnly = true)
    {
        $query = "select * from clients where nip={$clientTaxNb}";
        if ($activeOnly === true) {
            $query .= " and activity=1";
        }
        $clients = $this->query($query, null, false);

        if (!count($clients) == 1) {
            return null;
        }

        return $clients[0];
    }

    function getClientAccountNb($clientTaxNb)
    {
        $client = $this->getClientByTaxNb($clientTaxNb);

        if (!$client) {
            return;
        }

        return $this->formatIBAN($client["numerrachunku"]);

    }


    function formatIBAN($iban)
    {
        // remove whitespaces before formatting, it could happen iban is already formatted
        $iban = preg_replace('/\s+/', '', $iban);

        $controlNb = substr($iban, 0, 2);

        $arrAccountNb = str_split(substr($iban, 2, 6 * 4), 4);

        return implode(' ', array($controlNb, implode(' ', $arrAccountNb)));
    }


    function getClientsWithChargeInterest() {
        $query = "SELECT * FROM `clients` where naliczacodsetki = 1 and activity = 1";

        return $this->query($query, null, false);
    }

    function getPaymentsByClientTaxNo($clientTaxNo, $startDate, $endDate)
    {
        $where = "WHERE p.date >= '{$startDate}' and p.date <= '{$endDate}' and c.nip = '{$clientTaxNo}'";
        $orderBy = 'p.date DESC';

        $query = "SELECT p.details as 'content', TRUNCATE(p.amount / 100, 2) as 'price_gross', (select GROUP_CONCAT(pp.ext_invoice_nb separator ', ') from payments_processed pp where pp.rowid_payments = p.rowid) as 'invoice', CONCAT(c.nazwakrotka, CONCAT(' NIP: ', c.nip)) as 'client', p.date as 'issue_date' FROM `payments` p 
                        inner join clients c on substring(p.recipient_acount, -10) = c.nip
                      {$where}
                      ORDER BY {$orderBy}";

        return $this->query($query, null, null);
    }
}