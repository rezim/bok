<?php
class clientinvoice extends Model
{
    protected $dataod='',$datado='',$filterklient='',$filterdrukarka='',$nazwakrotka='';

    function getAgreements() {
        $query =
            "select c.nazwapelna as client_name, c.nip as client_nip, a.nrumowy as agreement_id,
                    a.rowid as agreement_rowid, c.terminplatnosci as agreement_paymentdate,
                    a.activity as agreement_isactive
             from agreements a inner join clients c on a.rowidclient = c.rowid
             where c.nip <> '0000000000' OR (c.nip = '0000000000' AND a.activity = 1)
             order by nazwakrotka";
        return json_encode($this->query($query,null,false));
    }
}