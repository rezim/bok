<?php
class service extends Model
{
    const PRZYJETE = 1;
    const W_TRAKCIE_DIAGNOZY = 2;
    const ZDIAGNOZOWANA = 3;
    const CZEKAMY_NA_AKCEPTACJE = 4;
    const ZAAKCEPTOWANA = 5;
    const CZEKAMY_NA_CZESCI = 6;
    const GOTOWA_DO_NAPRAWY = 7;
    const W_TRAKCIE_NAPRAWY = 8;
    const NAPRAWIONA = 9;
    const GOTOWA_DO_WYDANIA = 10;
    const ZLECENIE_ZAMKNIETE = 11;

    function add($postParams, $tableName) {
        return $this->insertFromPostParams($postParams, $tableName);
    }

    function getClients() {
        $query =
            " SELECT *
              FROM `service_clients`
           ";
        return json_encode($this->query($query,null,false));
    }

    function getRequests($showClosed) {
        $query =
            " SELECT sc.*, sr.*, sr.rowid as srRowId, ss.nazwa as status, Concat(u.imie,' ',u.nazwisko) as userName, u.mail as userEmail, ug.rowid_group as groupId,
              (SELECT count(revers_number) FROM `service_mails` WHERE revers_number = sr.revers_number GROUP BY revers_number) as emailsCount, 
              (SELECT count(revers_number) FROM `service_mails` WHERE revers_number = sr.revers_number AND wasread = 0 GROUP BY revers_number) as unreadEmailsCount 
              FROM `service_requests` as sr
                inner join `service_clients` as sc on sc.rowid_clients = sr.rowid_clients 
                left outer join `service_status` as ss on sr.rowid_status = ss.rowid          
                left outer join `users` as u on u.rowid = sr.rowid_user
                left outer join `users_groups` as ug on ug.rowid_user = u.rowid                      
           ";
        if (!$showClosed) {
            $query = $query . "WHERE sr.rowid_status <> 11";
        }

        return json_encode($this->query($query,null,false));
    }

    function getClosedRequests() {
        $query =
            " SELECT sc.*, sr.*, sr.rowid as srRowId, ss.nazwa as status, Concat(u.imie,' ',u.nazwisko) as userName, u.mail as userEmail, ug.rowid_group as groupId,
              (SELECT count(revers_number) FROM `service_mails` WHERE revers_number = sr.revers_number GROUP BY revers_number) as emailsCount, 
              (SELECT count(revers_number) FROM `service_mails` WHERE revers_number = sr.revers_number AND wasread = 0 GROUP BY revers_number) as unreadEmailsCount 
              FROM `service_requests` as sr
                inner join `service_clients` as sc on sc.rowid_clients = sr.rowid_clients 
                left outer join `service_status` as ss on sr.rowid_status = ss.rowid          
                left outer join `users` as u on u.rowid = sr.rowid_user
                left outer join `users_groups` as ug on ug.rowid_user = u.rowid                      
           ";

        $query = $query . "WHERE sr.rowid_status = 11";

        return json_encode($this->query($query,null,false));
    }

    function getHistory($reversNumber) {
        $query =
            " SELECT sh.*, ss.nazwa as statusName, Concat(u.imie,' ',u.nazwisko) as userName
              FROM `service_history` as sh
                left join `service_status` as ss on sh.rowid_status = ss.rowid
                left outer join `users` as u on u.rowid = sh.rowid_user               
              WHERE sh.revers_number = '" . $reversNumber . "'  
              ORDER BY sh.date_insert desc   
           ";

        return json_encode($this->query($query,null,false));
    }

    function getCurrentUserRequests() {
        $query =
            " SELECT sr.*, ss.nazwa as status
              FROM `service_requests` as sr
                inner join `service_status` as ss on sr.rowid_status = ss.rowid
              WHERE sr.rowid_status in (1,2,7,8) AND `rowid_user` = " . $_SESSION['user']['rowid'] . " " .
                "OR (sr.rowid_status in (1,7) AND `rowid_user` = -1)";

        return json_encode($this->query($query,null,false));
    }


    function getEmails($reversNumber) {
        $query =
            " SELECT *
              FROM `service_mails`
              WHERE `revers_number` = '" . $reversNumber . "'
              ORDER BY date_email DESC";

        return json_encode($this->query($query,null,false));

    }

    function getStatuses() {
        $query =
            " SELECT rowid as id, nazwa as name
              FROM `service_status`
              ORDER BY `rowid`
           ";
        return json_encode($this->query($query,null,false));
    }

    function getServiceAvailableStatuses() {
        $query =
            " SELECT rowid as id, nazwa as name
              FROM `service_status`
              WHERE rowid in (1, 2, 3, 7, 8, 9)
              ORDER BY `rowid`
           ";
        return json_encode($this->query($query,null,false));
    }

    function getUsers() {
        $query =
            " SELECT rowid as id, id as name, mail
              FROM `users`
              UNION SELECT -1 as id, '- nie przypisany -' as name, '- nie przypisany -' as mail
           ";
        return json_encode($this->query($query,null,false));
    }
}