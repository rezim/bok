<?php

class consumablesController extends Controller
{
    function delete()
    {
        echo(json_encode($this->consumable->delete($_POST['rowid'])));
    }

    function saveupdate()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if ($_POST['code'] == '')
                die('Dodaj kod materiału');
            if ($_POST['name'] == '')
                die('Dodaj nazwę materiału');
            if (!is_array($_POST['model']) || empty($_POST['model']))
                die('Dodaj model drukarki');
            echo(json_encode($this->consumable->saveupdate($_POST['rowid'], $_POST['code'], $_POST['name'], $_POST['model'], $_POST['yield'], $_POST['price'])));
        } else {
            echo('Błędne wywołanie');
        }
    }

    function addedit()
    {

        global $smarty;
        if ($_POST['rowid'] != '') {
            $dataConsumable = $this->consumable->getConsumableByRowid($_POST['rowid']);
            $dataConsumable[0]['models'] = explode(",", $dataConsumable[0]['models']);
            $smarty->assign('dataConsumables', $dataConsumable[0]);
            unset($dataConsumable);
            $smarty->assign('rowid', $_POST['rowid']);
        }

        $printer = new printer();
        $dataPrinterModels = $printer->getPrinterModels();
        unset($printer);
        $smarty->assign('dataPrinterModels', $dataPrinterModels);
        unset($dataPrinterModels);
    }

    function showdane()
    {
        global $smarty;
        $this->consumable->populateWithPost();
        $dataConsumables = $this->consumable->getConsumables();
        $smarty->assign('dataConsumables', $dataConsumables);
        unset($dataConsumables);
    }
}
