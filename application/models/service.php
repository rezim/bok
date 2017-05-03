<?php
class service extends Model
{
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

    function getRequests() {
        $query =
            " SELECT sc.*, sr.*, sr.rowid as srRowId, ss.nazwa as status
              FROM `service_requests` as sr
                inner join `service_clients` as sc on sc.rowid_clients = sr.rowid_clients 
                left outer join `service_status` as ss on sr.rowid_status = ss.rowid
           ";
        return json_encode($this->query($query,null,false));
    }

    function getCurrentUserRequests() {
        $query =
            " SELECT sr.*, ss.nazwa as status
              FROM `service_requests` as sr
                inner join `service_status` as ss on sr.rowid_status = ss.rowid
              WHERE sr.rowid_status in (1,2,7,8) AND `rowid_user` = " . $_SESSION['user']['rowid'];

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
           ";
        return json_encode($this->query($query,null,false));
    }
}