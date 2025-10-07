<?php

require_once (ROOT . DS . 'application' . DS . 'utils' . DS . 'DataSource.php');
require_once (ROOT . DS . 'application' . DS . 'utils' . DS . 'Email_reader.php');
require_once (ROOT . DS . 'application' . DS . 'utils' . DS . 'lexmark_counters.php');


class email extends Model
{
    function pullDeviceCounters($email) {
        insertLexmarkCounters();
        return readDeviceCounters($email);
    }
}