<?php
class service extends Model
{
    function add($postParams, $tableName) {
        return json_encode($this->insertFromPostParams($postParams, $tableName));
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
            " SELECT sc.*, sr.*, sr.rowid as srRowId
              FROM `service_requests` as sr
                inner join `service_clients` as sc on sc.rowid = sr.rowid_clients 
           ";
        return json_encode($this->query($query,null,false));
    }

    function getStatuses() {
        $query =
            " SELECT rowid as id, nazwa as name
              FROM `service_status`
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