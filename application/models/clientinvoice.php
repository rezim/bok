<?php
class clientinvoice extends Model
{
    protected $dataod='',$datado='',$filterklient='',$filterdrukarka='',$nazwakrotka='';

    function getAgreements() {
        $query =
            "select c.rowid as client_id, c.nazwapelna as client_name, c.nip as client_nip, c.telefon as client_phone, a.nrumowy as agreement_id,
                    a.rowid as agreement_rowid, c.terminplatnosci as agreement_paymentdate,
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
        $query = "select * from payments_messages where client_nip='{$client_nip}' and active = 1 order by message_date, created desc";
        return json_encode($this->query($query, null, false));
    }
}