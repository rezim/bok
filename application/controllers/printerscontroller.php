<?php

class printersController extends Controller
{

    function logi()
    {
        global $smarty;
        $dataLogi = $this->printer->getLogi($_POST['serial']);
        $smarty->assign('dataLogi', $dataLogi);
        unset($dataLogi);
    }

    function service()
    {
        global $smarty;
        $dataService = $this->printer->getService($_POST['rowid_agreement']);
        $smarty->assign('dataService', $dataService);
        unset($dataService);
    }

    function removeservice()
    {
        echo(json_encode($this->printer->removeService($_POST['rowid'])));
    }

    function showdane()
    {
        global $smarty;
        $this->printer->populateWithPost();
        $dataPrinters = $this->printer->getPrinters();

        $smarty->assign('dataPrinters', $dataPrinters);
        $smarty->assign('czycolorbox', isset($_POST['czycolorbox']) ? $_POST['czycolorbox'] : '');

        $canSaveUpdate = $this->hasAccessToAction('saveupdate');
        $smarty->assign('canSaveUpdate', $canSaveUpdate);

        unset($dataPrinters);
    }

    function delete()
    {
        $umowa = new agreement();
        $dane = $umowa->getUmowaByPrinter($_POST['serial']);
        unset($umowa);
        if (count($dane) != 0) {
            echo('Ta drukarka jest przypisana do umowy  najpierw usuń umowę.');
        } else
            echo(json_encode($this->printer->delete($_POST['serial'])));
    }

    function addedit()
    {

        global $smarty;
        if ($_POST['serial'] != '') {
            $dataPrinter = $this->printer->getPrinterBySerial($_POST['serial']);
            $smarty->assign('dataPrinter', $dataPrinter[0]);
            unset($dataPrinter);
        }
        $smarty->assign('serial', $_POST['serial']);

        $canSaveUpdate = $this->hasAccessToAction('saveupdate');
        $canViewLocalization = $this->hasAccessToAction('view_localization');
        $smarty->assign('canSaveUpdate', $canSaveUpdate);
        $smarty->assign('canViewLocalization', $canViewLocalization);
    }

    function saveupdate()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

            if ($_POST['serial'] == '')
                die('Uzupełnij serial');
            if ($_POST['model'] == '')
                die('Uzupełnij model');


            $this->printer->populateWithPost();
            echo(json_encode($this->printer->saveupdate()));
        } else {
            echo('Błędne wywołanie');
        }
    }

    function savestanna()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

            if (!isset($_POST['serial']) || $_POST['serial'] == '')
                die('Uzupełnij serial');
            if (!isset($_POST['stanna']) || $_POST['stanna'] == '')
                die('Wybierz datę na którą ma być wpisane');

            $this->printer->populateWithPost();
            echo(json_encode($this->printer->savestanna()));
        } else {
            echo('Błędne wywołanie');
        }
    }

    function getprintercounters() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')) {
            if ($_POST['serial'] === '')
                die('Uzupełnij serial');
            echo(json_encode($this->printer->getPrinterCounters($_POST['serial'])));
        } else {
            echo('Błędne wywołanie');
        }
    }

    function show()
    {
        global $smarty;

        if (isset($_POST['czycolorbox'])) {
            $smarty->assign('clientnazwakrotka', $_POST['clientnazwakrotka']);
            $smarty->assign('czycolorbox', $_POST['czycolorbox']);
        } else
            $smarty->assign('czycolorbox', '');

    }

    function replacePrinter()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

            if (!isset($_POST['serial'])) {
                $this->badRequest('Serial jest wymagany');
            }
            if (!isset($_POST['replacementDate']) || $_POST['replacementDate'] === '') {
                $this->badRequest('Data wymiany jest wymagana');
            }

            echo(json_encode($this->printer->replaceprinter($_POST['serial'],
                $_POST['newSerial'],
                $_POST['rowid_agreement'],
                $_POST['counterEnd'], $_POST['counterStart'],
                $_POST['counterColorEnd'], $_POST['counterColorStart'],
                $_POST['scansEnd'], $_POST['scansStart'],
                $_POST['replacementDate'])));

        }
    }
}
