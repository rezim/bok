<?php

class statistic extends Model
{

    function getStatistics($dateFrom, $dateTo, $showNotClosed)
    {

        $where = "WHERE u.mail != 'tregimowicz@gmail.com'";

        if ($showNotClosed == 0) {
            $where .= " and date_zakonczenia is not null";
        }

        if ($dateFrom != '' && isset($dateTo) != '') {
            $where .= " and (date_zakonczenia <= '{$dateTo}' and date_zakonczenia >= '{$dateFrom}')";
            if ($showNotClosed) {
                $where .= " or (date_zakonczenia is null and date_insert <= '{$dateTo}' and date_insert > '{$dateFrom}') ";
            }
        } else if ($dateTo != '') {
            $where .= " and (date_zakonczenia <= '{$dateTo}')";
            if ($showNotClosed) {
                $where .= " or (date_zakonczenia is null and date_insert <= '{$dateTo}')";
            }
        } else if ($dateFrom != '') {
            $where .= " and (date_zakonczenia >= '{$dateFrom}')";
            if ($showNotClosed) {
                $where .= " or (date_zakonczenia is null and date_insert > '{$dateFrom}')";
            }
        }

        $query = "SELECT ns.nazwa as status, u.imie as imie, u.nazwisko as nazwisko, count(*) as count
                  FROM `notifications` n inner join users u on n.wykonuje = u.rowid inner join `notifications_status` ns on n.status = ns.rowid
                  {$where} 
                  GROUP BY n.wykonuje, n.status 
                  ORDER BY u.id, ns.nazwa DESC";

        return $this->query($query, null, false);
    }
}
