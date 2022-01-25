<?php

class material extends Model
{

    protected $date_to, $date_from, $client_name, $agreement_id, $returns_only, $send_only;

    function getMaterialsReport()
    {
        $filters = "and n.date_zakonczenia <= '{$this->date_to} 23:59:59' and n.date_zakonczenia >= '{$this->date_from}'";

        if ($this->client_name != '') {
            $filters .= " and c.nazwakrotka like '%{$this->client_name}%'";
        }

        if ($this->agreement_id != '') {
            $filters .= " and a.nrumowy like '%{$this->agreement_id}%'";
        }

        $eventTypes = array();
        if ($this->returns_only === 'true') {
            array_push($eventTypes, 7);
        }
        if ($this->send_only === 'true') {
            array_push($eventTypes, 2);
        }

        if (count($eventTypes) === 0) {
            array_push($eventTypes, 2, 7);
        }

        $filters .= " and n.rowid_type in (" .  implode(",", $eventTypes) . ")";

        $query = "
            SELECT n.rowid as eventId, c.rowid as clientId, a.rowid as agreementId, a.nrumowy as agreementNb, c.nazwakrotka as clientName,
             n.rowid_type as eventType, n.serial as deviceId, n.date_zakonczenia as eventDate, 
             COALESCE(toner_black, 0) as blackCount, COALESCE(toner_cyan, 0) as cyanCount, 
             COALESCE(toner_magenta, 0) as magentaCount, COALESCE(toner_yellow, 0) as yellowCount 
            FROM `notifications` n inner join `clients` c on n.rowid_client = c.rowid inner join `agreements` a on n.rowid_agreements = a.rowid 
            WHERE (toner_black > 0 or toner_cyan > 0 or toner_magenta > 0 or toner_yellow > 0) {$filters}
            ORDER BY `c`.`nazwakrotka` ASC, a.nrumowy ASC, n.date_zakonczenia DESC
        ";

        return $this->query($query, null, false);
    }
}


