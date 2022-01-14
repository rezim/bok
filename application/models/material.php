<?php

class material extends Model
{
    function getMaterialsReport($dateFrom, $dateTo) {

        $query = "SELECT c.nazwakrotka as nazwakrotka, a.rowid as agreementId, n.rowid_type as type, count(n.serial) deviceCount, sum(toner_black) as black, sum(toner_cyan) as cyan, sum(toner_magenta) as magenta, sum(toner_yellow) as yellow
                  FROM `notifications` n inner join `clients` c on n.rowid_client = c.rowid inner join `agreements` a on n.rowid_agreements = a.rowid
                  WHERE n.rowid_type in (2, 7) and (toner_black > 0 or toner_cyan > 0 or toner_magenta > 0 or toner_yellow > 0) 
                        and date_zakonczenia <= '{$dateTo}' and date_zakonczenia >= '{$dateFrom}'
                  GROUP BY c.nazwakrotka, n.rowid_type
                  ORDER BY `c`.`nazwakrotka` ASC";

        return $this->query($query, null, false);
    }
}