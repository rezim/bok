<?php

class material extends Model
{

    protected $date_to, $date_from;

    function getMaterialsReport()
    {
        $filters = "and n.date_zakonczenia <= '{$this->date_to}' and n.date_zakonczenia >= '{$this->date_from}'";
        $query = "
            SELECT n.rowid as eventId, c.rowid as clientId, a.rowid as agreementId, a.nrumowy as agreementNb, c.nazwakrotka as clientName,
             n.rowid_type as eventType, n.serial as deviceId, n.date_zakonczenia as eventDate, 
             COALESCE(toner_black, 0) as blackCount, COALESCE(toner_cyan, 0) as cyanCount, 
             COALESCE(toner_magenta, 0) as magentaCount, COALESCE(toner_yellow, 0) as yellowCount 
            FROM `notifications` n inner join `clients` c on n.rowid_client = c.rowid inner join `agreements` a on n.rowid_agreements = a.rowid 
            WHERE n.rowid_type in (2, 7) and (toner_black > 0 or toner_cyan > 0 or toner_magenta > 0 or toner_yellow > 0) {$filters}
            ORDER BY `c`.`nazwakrotka` ASC, a.nrumowy ASC, n.date_zakonczenia DESC
        ";

        return $this->query($query, null, false);
    }
}


