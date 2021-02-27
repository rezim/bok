<?php

class clientsController extends Controller
{


    function addedit()
    {

        global $smarty;
        if ($_POST['rowid'] != '0') {
            $dataClient = $this->client->getClientByRowid($_POST['rowid']);
            $smarty->assign('dataClient', $dataClient);
            unset($dataClient);
        }
        $smarty->assign('rowid', $_POST['rowid']);

        // only some group could see payment options on addedit view,
        // TODO: probably we should not use 'przypisanemenu' :)
        $smarty->assign('show_payment_options',
            isset($_SESSION['przypisanemenu']) &&
            isset($_SESSION['przypisanemenu']['clientspayments_options']) &&
            isset($_SESSION['przypisanemenu']['clientspayments_options']['permission']) &&
            $_SESSION['przypisanemenu']['clientspayments_options']['permission'] === 'rw');

    }

    function delete()
    {

        $umowa = new agreement();
        $dane = $umowa->getUmowaByClient($_POST['rowid']);
        unset($umowa);
        if (count($dane) != 0) {
            echo('Ten klient jest przypisany do umowy  najpierw usuń umowę.');
        } else
            echo(json_encode($this->client->delete($_POST['rowid'])));
    }

    function saveupdate()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {



            if (!(isset($_SESSION['przypisanemenu']) &&
            isset($_SESSION['przypisanemenu']['clientspayments_options']) &&
            isset($_SESSION['przypisanemenu']['clientspayments_options']['permission']) &&
            $_SESSION['przypisanemenu']['clientspayments_options']['permission'] === 'rw')
            ){
                if ($_POST['nazwakrotka'] == '')
                    die('Uzupełnij nazwę krótką');
                if ($_POST['nazwapelna'] == '')
                    die('Uzupełnij nazwę pełną');

                if (isset($_POST['pokaznumerseryjny']) || isset($_POST['pokazstanlicznika']) ||
                    isset($_POST['fakturadlakazdejumowy']) || isset($_POST['umowazbiorcza']) ||
                    isset($_POST['monitoringplatnosci']) || isset($_POST['naliczacodsetki']) ||
                    isset($_POST['nip']) || isset($_POST['terminplatnosci']) ||
                    isset($_POST['bank']) || isset($_POST['numerrachunku']))
                    die('Nie masz prawa do zapisu tych wartości');
            } else {
                if ($_POST['nazwakrotka'] == '')
                    die('Uzupełnij nazwę krótką');
                if ($_POST['nazwapelna'] == '')
                    die('Uzupełnij nazwę pełną');
                if ($_POST['nip'] == '')
                    die('Uzupełnij NIP');
            }

            $this->client->populateWithPost();
            echo(json_encode($this->client->saveupdate()));
        } else {
            echo('Błędne wywołanie');
        }
    }

    function show()
    {
        global $smarty;

        if (isset($_POST['czycolorbox'])) {
            $smarty->assign('czycolorbox', $_POST['czycolorbox']);
            $smarty->assign('serial', $_POST['serial']);
        } else
            $smarty->assign('czycolorbox', '');
    }

    function showdane()
    {
        global $smarty;
        $this->client->populateWithPost();
        $dataClient = $this->client->getClients();
        $smarty->assign('dataClient', $dataClient);
        $smarty->assign('czycolorbox', isset($_POST['czycolorbox']) ? $_POST['czycolorbox'] : '');
        $smarty->assign('modalselector', isset($_POST['modalselector']) ? $_POST['modalselector'] : '');
        unset($dataClient);
    }
}
