<?php
class alertsController extends Controller
{


    function logi()
    {
        global $smarty;
        $dataLogi = $this->alert->getLogi($_POST['serial']);
        $smarty->assign('dataLogi',$dataLogi);
        unset($dataLogi);
    }

    function service()
    {
        global $smarty;
        $dataService = $this->alert->getService($_POST['rowid_agreement']);
        $smarty->assign('dataService',$dataService);
        unset($dataService);
    }

    function removeservice() {
        echo (json_encode($this->alert->removeService($_POST['rowid'])));
    }

    function showdane()
    {
        global $smarty;
        $this->alert->populateWithPost();

        $dataAlerts = $this->alert->getAlerts();

        $smarty->assign('dataAlerts',$dataAlerts);

        $smarty->assign('czycolorbox',$_POST['czycolorbox']);

        unset($dataAlerts);
    }
    function delete()
    {

    }
    function addedit()
    {

//        global $smarty;
//        if($_POST['serial']!='')
//        {
//            $dataPrinter = $this->alert->getPrinterBySerial($_POST['serial']);
//            $smarty->assign('dataPrinter',$dataPrinter );
//            unset($dataPrinter);
//        }
//        $smarty->assign('serial',$_POST['serial']);
    }
    function saveupdate()
    {

        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {

            if($_POST['serial']=='')
                die('Uzupełnij serial');
            if($_POST['model']=='')
                die('Uzupełnij model');


            $this->alert->populateWithPost();
            echo(json_encode($this->alert->saveupdate()));
        }
        else
        {
            echo('Błędne wywołanie');
        }
    }
    function savestanna()
    {

        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {

            if($_POST['serial']=='')
                die('Uzupełnij serial');
            if($_POST['stanna']=='')
                die('Wybierz datę na którą ma być wpisane');
            if($_POST['iloscstron']!='' && !validatesAsInt(str_replace(' ','',$_POST['iloscstron'])))
                die('Wpisz poprawną ilość toner czarny');
            if(array_key_exists('iloscstron_kolor', $_POST) && $_POST['iloscstron_kolor']!='' && !validatesAsInt(str_replace(' ','',$_POST['iloscstron_kolor'])))
                die('Wpisz poprawną ilość toner kolorowy');


            $this->alert->populateWithPost();
            echo(json_encode($this->alert->savestanna()));
        }
        else
        {
            echo('Błędne wywołanie');
        }
    }
    function show()
    {
        global $smarty;
        if(isset($_POST['czycolorbox']))
        {
            $smarty->assign('clientnazwakrotka',$_POST['clientnazwakrotka']);
            $smarty->assign('czycolorbox','1');
        }
        else
            $smarty->assign('czycolorbox','');

    }


    function replacePrinter() {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ) {

            echo(json_encode($this->alert->replaceprinter($_POST['serial'],
                $_POST['newSerial'],
                $_POST['rowid_agreement'],
                $_POST['counterEnd'], $_POST['counterStart'],
                $_POST['counterColorEnd'], $_POST['counterColorStart'],
                $_POST['replacementDate'])));

        }
    }
}
