<?php

require_once (ROOT . DS . 'application' . DS . 'utils' . DS . 'Email_reader.php');

class email extends Model
{
    function pullDeviceCounters($email) {
        return readDeviceCounters($email);
    }
}