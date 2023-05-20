<?php
class clientinvoice extends Model
{
    protected $dataod='',$datado='',$filterklient='',$filterdrukarka='',$nazwakrotka='';

    function getAgreements() {
        $query =
            "select c.rowid as client_id, c.nazwapelna as client_name, c.nip as client_nip, c.telefon as client_phone, c.mailfaktury as client_mailfaktury,
                    c.naliczacodsetki as client_naliczacodsetki,
                    a.nrumowy as agreement_id, a.rowid as agreement_rowid, c.terminplatnosci as agreement_paymentdate,
                    a.activity as agreement_isactive
             from agreements a inner join clients c on a.rowidclient = c.rowid
             where c.nip <> '0000000000' OR (c.nip = '0000000000' AND a.activity = 1)
             order by nazwakrotka";
        return json_encode($this->query($query,null,false));
    }

    function addPaymentMessage($postParams, $tableName) {
        $postParams['active'] = 1;
        $postParams['owner'] = $_SESSION['user']['imie'] . ' ' . $_SESSION['user']['nazwisko'];
        $result = $this->insertFromPostParams($postParams, $tableName);

        $query = "select * from {$tableName} where rowid={$result['rowid']}";
        return json_encode($this->query($query, null, false));
    }

    function removePaymentMessage($rowid) {
        return $this->update
        (
            "update `payments_messages` 
                   set `active`=0
                   where `rowid`=?"
            ,'i',
            array
            (
                $rowid
            )
        );
    }

    function getPaymentMessages($client_nip) {
        $query = "select * from payments_messages where client_nip='{$client_nip}' and active = 1 order by message_date desc, created desc";
        return json_encode($this->query($query, null, false));
    }

    function getTrackedDeptors() {
        $query = "select nip from clients where monitoringplatnosci=1";
        return $this->query($query, null, false);
    }

    function createInterestNote($clientRowId, $clientNip, $invoiceNb, $noteNb, $amount, $filePath, $invoiceViewUrl, $created, $paid = 0, $paid_date = null) {

        $query = "select * from interest_notes where notenb='{$noteNb}' and amount={$amount}";
        $notes = $this->query($query, null, false);

        if (count($notes) > 0) {
            return null;
        }

        $interestNote = array(
            'rowidclient' => $clientRowId,
            'invoicenb' => $invoiceNb,
            'notenb' => $noteNb,
            'amount' => $amount,
            'filepath' => $filePath,
            'invoiceviewurl' => $invoiceViewUrl,
            'clientnip' => $clientNip,
            'created' => $created,
            'paid' => $paid,
            'paid_date' => $paid_date
        );

        $namesWihTypes = array(
            'rowidclient' => 'integer',
            'invoicenb' => 'string',
            'notenb' => 'string',
            'amount' => 'integer',
            'filepath' => 'string',
            'invoiceviewurl' => 'string',
            'clientnip' => 'string',
            'created' => 'timestamp',
            'paid' => 'integer',
            'paid_date' => 'date'
        );

        // die(print_r($interestNote, true));

        return $this->insertIntoTable('interest_notes', $namesWihTypes, $interestNote);
    }

    function getClientByTaxNb($clientTaxNb)
    {
        $query = "select * from clients where nip={$clientTaxNb}";
        $clients = $this->query($query, null, false);

        if (count($clients) !== 1) {
            return null;
        }

        return $clients[0];
    }

    function getClientAccountNb($clientTaxNb) {
        $client = $this->getClientByTaxNb($clientTaxNb);

        if (!$client) {
            return;
        }

        return $this->formatIBAN($client["numerrachunku"]);

    }

    function getInterestNotesGroupedByNip() {
        $query = "SELECT amount/100 as amonunt, created as date, invoicenb as number, filepath as path, clientnip as nip, UNIX_TIMESTAMP(created) as timestamp,  paid, paid_date, invoiceviewurl FROM `interest_notes`";

        $interestNotes = $this->query($query,null,false);

        $nipToInterestNotesMap = array();
        array_walk($interestNotes, function (&$interestNote, $key) use (&$nipToInterestNotesMap) {
            $nip = $interestNote['nip'];
            if (!isset($nipToInterestNotesMap[$nip])) {
                $nipToInterestNotesMap[$nip] = array();
            }
            array_push($nipToInterestNotesMap[$nip], $interestNote);
        });
        return $nipToInterestNotesMap;
    }


    function getInterestNotesByClientNip($clientNip) {
        $query = "SELECT amount/100 as amonunt, created as date, invoicenb as number, filepath as path, clientnip as nip, UNIX_TIMESTAMP(created) as timestamp, paid, paid_date, invoiceviewurl " .
            " FROM `interest_notes` " . "WHERE clientnip='" . $clientNip . "'";

        return $this->query($query,null,false);
    }

    function formatIBAN($iban)
    {
        $controlNb = substr($iban, 0, 2);

        $arrAccountNb = str_split(substr($iban, 2, 6 * 4), 4);

        return implode(' ', array($controlNb, implode(' ', $arrAccountNb)));
    }

}