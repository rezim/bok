<?php

class Model extends SQLQuery
{
    protected $_model;
    protected $keyname;
    protected $keyVal;
    protected $czydelete = 0;
    protected $czyupdate = 1;
    protected $logger;
    public $_filedsToEdit = array();

    function __construct()
    {
        $this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->connectPDO(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model) . "s";
        if (isset($_SESSION['user']['rowid'])) {
            $this->logger = new DbLogger($this->pdo, $_SESSION['user']['rowid']);
        }
    }

    function logInfo($operationType, $actionType, $message): void {
        if ($this->logger) {
            $this->logger->info($operationType, $actionType, $message);
        }
    }
    function logWarning($operationType, $actionType, $message): void {
        if ($this->logger) {
            $this->logger->warning($operationType, $actionType, $message);
        }
    }
    function logError($operationType, $actionType, $message): void {
        if ($this->logger) {
            $this->logger->error($operationType, $actionType, $message);
        }
    }

    function set($name, $value)
    {
        $this->$name = $value;
    }

    function get($name)
    {
        return $this->$name;
    }

    function populateWithPost()
    {
        foreach ($_POST as $var => $value) {

            $this->$var = $value;

        }
    }

    function populateWithGet()
    {
        foreach ($_GET as $var => $value) {
            $this->$var = $value;
        }
    }


    function populateFieldsToSave($fname, $isjonson)
    {

        if ($isjonson == '1')
            $filedsToEdit = json_decode($_POST[$fname], true);
        else
            $filedsToEdit = $_POST[$fname];


        foreach ($filedsToEdit as $key => $value) {

            $this->_filedsToEdit[$key]['value'] = $value;
        }


    }

    function save()
    {


        $wynik = '';
        $columnList = '';
        $columnRoz = '';
        $columnData = array();
        $keyVal = '';
        $keyname = '';
        if ($this->czydelete == 1) {

            foreach ($this->_filedsToEdit as $key => $value) {


                if (isset($value['iskey']) && $value['iskey'] == 1) {
                    $keyname = $value['baza'];
                    $keyVal = $value['value'];
                    break;
                }
            }
            if ($keyname == '') {
                die('Brak przypisanego klucza w tabeli');
            }


            $wynik = $this->update("update {$this->_table} set activity=0,user_delete={$_SESSION['user']['rowid']},date_delete='" . date('Y-m-d H:i:s') . "' "
                . "where {$keyname}=?", 'i', array($keyVal));
        } else {
            foreach ($this->_filedsToEdit as $key => $value) {

                if (isset($value['wymagane']) && $value['wymagane'] == 1 && $value['value'] == '') {
                    die('Musisz uzupełnić pole : ' . $value['label']);
                }

                if (isset($value['iskey']) && $value['iskey'] == 1) {
                    $keyname = $value['baza'];
                    $keyVal = $value['value'];
                    break;
                }
            }

            if ($keyVal == '' || $keyVal == '0') {

                foreach ($this->_filedsToEdit as $key => $value) {

                    if (isset($value['wymagane']) && $value['wymagane'] == 1 && $value['value'] == '') {
                        die('Musisz uzupełnić pole : ' . $value['label']);
                    }
                    if (isset($value['datatype']) && $value['datatype'] == 'd' && $value['value'] != '') // kontrola czy decimal
                    {

                        $value['value'] = str_replace(',', '.', $value['value']);
                        if (!validatesAsDecimal($value['value'])) {
                            die('Błędne dane : ' . $value['label']);
                        }
                    }
                    if (isset($value['datatype']) && $value['datatype'] == 'i' && $value['value'] != '') // kontrola czy decimal
                    {
                        if (!validatesAsInt($value['value'])) {
                            die('Błędne dane : ' . $value['label']);
                        }
                    }

                    if (isset($value['iskey']) && $value['iskey'] == 1)
                        continue;
                    if ($columnList != '')
                        $columnList .= ",`{$value['baza']}`";
                    else
                        $columnList .= "`{$value['baza']}`";

                    $columnRoz .= $value['datatype'];

                    if ($value['baza'] == 'date_insert')
                        array_push($columnData, date('Y-m-d H:i:s'));
                    else
                        array_push($columnData, $value['value'] == '' ? 'NULL' : $value['value']);
                }


                $wynik = $this->insert($columnList, $columnRoz, $columnData);

                $wynik['keyval'] = $this->getLastId();
            } else {


                if ($this->czyupdate == 1) {
                    if ($keyname == '') {
                        die('Brak przypisanego klucza w tabeli');
                    }
                    foreach ($this->_filedsToEdit as $key => $value) {

                        if (isset($value['wymagane']) && $value['wymagane'] == 1 && $value['value'] == '') {
                            die('Musisz uzupełnić pole : ' . $value['label']);
                        }
                        if (isset($value['datatype']) && $value['datatype'] == 'd' && $value['value'] != '') // kontrola czy decimal
                        {
                            $value['value'] = str_replace(',', '.', $value['value']);
                            if (!validatesAsDecimal($value['value'])) {
                                die('Błędne dane : ' . $value['label']);
                            }
                        }
                        if (isset($value['datatype']) && $value['datatype'] == 'i' && $value['value'] != '') // kontrola czy decimal
                        {
                            if (!validatesAsInt($value['value'])) {
                                die('Błędne dane : ' . $value['label']);
                            }
                        }
                        if (isset($value['iskey']) && $value['iskey'] == 1)
                            continue;
                        if ($columnList != '')
                            $columnList .= ",`{$value['baza']}`=?";
                        else
                            $columnList .= "`{$value['baza']}`=?";

                        $columnRoz .= $value['datatype'];
                        array_push($columnData, $value['value'] == '' ? 'NULL' : $value['value']);
                    }


                    $wynik = $this->update("update {$this->_table} set {$columnList} where {$keyname}={$keyVal}", $columnRoz, $columnData);

                }
                $wynik['keyval'] = $keyVal;

            }
        }
        return $wynik;
    }

    function getEditDane()
    {

        $filter = " where {$this->keyname}={$this->keyVal}";

        $query = " select  ";


        foreach ($this->_filedsToEdit as $var => $value) {
            if (isset($value['sql']))
                $query .= $value['sql'];
            if (isset($value['sqldane']))
                $query .= ',' . $value['sqldane'];
            if (isset($value['sql']) || isset($value['sqldane'])) {
                if (!$this->last($this->_filedsToEdit, $var))
                    $query .= ',';
            }
        }


        $query .= " from {$this->_table}

            {$filter}
                ";

        return $this->query($query, null, false);
    }

    function last(&$array, $key)
    {
        end($array);
        return $key === key($array);
    }

    function __destruct()
    {
        $this->disconnect();
    }
}