<?php
function getMySqlConn(): mysqli
{
    global $mysqli;

    if ($mysqli === null) {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $mysqli->query("SET NAMES 'utf8'");
        return $mysqli;
    }

    return $mysqli;
}