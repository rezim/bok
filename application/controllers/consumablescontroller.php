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
            if ($_POST['rowid'] == '')
                die('rowid jest wymagane, dla nowego rekordu podaj \'0\'');
            if ($_POST['name'] == '')
                die('Dodaj nazwę materiału');
            if ($_POST['model'] == '')
                die('Dodaj model drukarki');
            echo(json_encode($this->consumable->saveupdate($_POST['rowid'], $_POST['name'], $_POST['model'], $_POST['yield'], $_POST['price'])));
        } else {
            echo('Błędne wywołanie');
        }
    }

    function addedit()
    {

        global $smarty;
        if ($_POST['rowid'] != '') {
            $dataConsumable = $this->consumable->getConsumableByRowid($_POST['rowid']);
            $smarty->assign('dataConsumables', $dataConsumable);
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
