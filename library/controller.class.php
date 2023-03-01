<?php

class Controller
{

    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_template;
    protected $_queryString, $notemplate = 0;
    protected $_czyjuzpopulate = 0;

    function __construct($model, $controller, $action, $queryString)
    {
        global $smarty;
        $this->_queryString = $queryString;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_model = $model;

        $this->$model = new $model;
        $czyToDiv = 0;
        $this->notemplate = 0;
        $czytoDivFrame = 0;
        if ($queryString != null && $queryString != '') {
            $smarty->assign('queryString', $queryString);
            switch ($queryString[sizeof($queryString) - 1]) {
                case 'todiv':
                    $czyToDiv = 1;
                    break;
                case 'todivframe':
                    $czytoDivFrame = 1;
                    break;
                case 'notemplate':
                    $this->notemplate = 1;
                    break;
            }

        }

        if ($this->notemplate == 0)
            $this->_template = new Template($controller, $action, $czyToDiv, $czytoDivFrame);

    }

    function set($name, $value)
    {
        $this->_template->set($name, $value);
    }

    function __destruct()
    {
        if ($this->notemplate == 0)
            $this->_template->render();
    }

    function addedit()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            global $smarty;
            $nameOfModel = ($this->_model);
            $this->$nameOfModel->populateWithPost();


            if ($_POST['keyVal'] == 0) {
                $this->$nameOfModel->_filedsToEdit['activity']['value'] = '1';
                $this->$nameOfModel->_filedsToEdit['user_insert']['value'] = $_SESSION['user']['rowid'];
            } else {

                $dane = $this->$nameOfModel->getEditDane();

                $smarty->assign('dane', $dane);
                $smarty->assign('filedsToEdit', $this->$nameOfModel->_filedsToEdit);
                unset($dane);
            }

            $smarty->assign('keyVal', $_POST['keyVal']);
            $smarty->assign('filedsToEdit', $this->$nameOfModel->_filedsToEdit);
        } else {
            header("Location: /");
        }
    }

    function save()
    {

        $nameOfModel = ($this->_model);

        if ($this->_czyjuzpopulate == 0) {

            $this->$nameOfModel->populateFieldsToSave('_filedsToEdit', '1');
            $this->$nameOfModel->set('czydelete', $_POST['czydelete']);
        }

        return $this->$nameOfModel->save();
    }

    function validatePostParams($postParams)
    {
        $emptyParams = array_filter($postParams, function ($param) {
            return !isset($_POST[$param]) || (!$_POST[$param] && $_POST[$param] != 0);
        });

        if (count($emptyParams) > 0) {
            $this->badRequest("Blad! Parametry: " . implode(",", $emptyParams) . " sa wymagane!");
        }
    }

    function badRequest($message) {
        header('X-PHP-Response-Code: 400', true, 400);
        die($message);
    }

    function forbidden($message) {
        header('X-PHP-Response-Code: 403', true, 403);
        die($message);
    }

    function notImplemented($message) {
        header('X-PHP-Response-Code: 501', true, 501);
        die($message);
    }

    function internalServerError($message) {
        header('X-PHP-Response-Code: 500', true, 500);
        die($message);
    }

    function filterArrayByKeyValue($array,$key, $keyValue): array {
        $matches = array();
        foreach($array as $a){
            if($a[$key] == $keyValue)
                $matches[]=$a;
        }
        return $matches;
    }

}