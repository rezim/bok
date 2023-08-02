<?php

class clientsController extends InvoicesController
{

    protected $areClientPaymentOptionsPermitted = false;

    function __construct($model, $controller, $action, $queryString)
    {
        parent::__construct($model, $controller, $action, $queryString);
        // only some group could see payment options on addedit view,
        // TODO: probably we should not use 'przypisanemenu' :)
        $this->areClientPaymentOptionsPermitted = isset($_SESSION['przypisanemenu']) &&
            isset($_SESSION['przypisanemenu']['clientspayments_options']) &&
            isset($_SESSION['przypisanemenu']['clientspayments_options']['permission']) &&
            $_SESSION['przypisanemenu']['clientspayments_options']['permission'] === 'rw';
    }

    function addedit()
    {

        global $smarty;
        if ($_POST['rowid'] != '0') {
            $dataClient = $this->client->getClientByRowid($_POST['rowid']);
            $smarty->assign('dataClient', $dataClient);
            unset($dataClient);
        }
        $smarty->assign('rowid', $_POST['rowid']);
        $smarty->assign('show_payment_options', $this->areClientPaymentOptionsPermitted);
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

    function forceupdateibanforclients()
    {
        $updatedClients = $this->client->updateIBANForAllClients(true);
        $updatedCount = 0;
        foreach ($updatedClients as $nip => $accountNb) {
            $client = $this->getClientByTaxNo($nip);

            if (count($client) === 1) {
                $this->updateClientById($client[0]['id'], array("use_mass_payment" => true, "mass_payment_code" => $accountNb));
                $updatedCount++;
            } else {
                echo "Nie można znaleźć klienta nip: $nip";
            }
        }

        echo $updatedCount . ' z ' . count($updatedClients) . ' zaktualizowane!';
    }

    function updateibanforclients()
    {
        echo json_encode($this->client->updateIBANForAllClients(false));
    }

    function updateibanforremoteclients()
    {
        $clients = $this->client->getClients();

        foreach ($clients as $client) {
            $nip = $client['nip'];
            $accountNb = $client['numerrachunku'];

            if (empty($accountNb)) {
                echo "Client: $nip has empty account number! <br />";
                continue;
            }

            $remoteClient = $this->getClientByTaxNo($nip);

            if (count($remoteClient) === 1) {
                if ($remoteClient[0]['mass_payment_code'] === '' || $remoteClient[0]['mass_payment_code'] === "SANTANDER ") {
                    echo "Błędny numer rachunku: " . $remoteClient[0]['id'] . " nip: " . $nip . "<br />";

                    $this->updateClientById($remoteClient[0]['id'], array("use_mass_payment" => true, "mass_payment_code" => $accountNb));
                }
            } else {
                $createClientData = array(
                    "name" => $client["nazwapelna"],
                    "tax_no" => $client["nip"],
                    "use_mass_payment" => true,
                    "mass_payment_code" => $client["numerrachunku"],
                    "email" => $client["mailfaktury"],
                    "street" => $client["ulica"],
                    "post_code" => $client["kodpocztowy"],
                    "city" => $client["miasto"]
                );

                $this->createClient($createClientData);


                echo "Nowy klient nip: $nip został utworzony. <br />";
            }
        }
    }

    function saveupdate()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

            if (!isset($_POST['rowid'])) {
                $this->badRequest('Identyfikator klienta jest wymagany');
            }

            $isCreateClientRequest = $_POST['rowid'] === '0';
            $clientRowId = $_POST['rowid'];

            if ($_POST['nazwakrotka'] == '') {
                $this->badRequest('Nazwa krótka jest wymagana');
            }

            if ($_POST['nazwapelna'] == '') {
                $this->badRequest('Nazwa pełna jest wymagana');
            }

            $clientNip = $_POST['nip'] ?? null;
            if ($isCreateClientRequest) {
                if (empty($clientNip)) {
                    $this->badRequest('Numer NIP klienta jest wymagany.');
                }
                if (!$this->isNIP($clientNip)) {
                    $this->badRequest('Niepoprawny numer NIP');
                }

                $client = $this->client->getClientByNip($clientNip);
                if (!empty($client)) {
                    $clientName = $client[0]['nazwakrotka'];
                    $this->badRequest("Klient o numerze NIP: '$clientNip' już istnieje, nazwa istnięjącego klienta: '$clientName'!");
                }
            } else {
                // for edit client nip could not present in the request
                if (!empty($clientNip) && !$this->isNIP($clientNip)) {
                    $this->badRequest('Niepoprawny numer NIP');
                }
            }

            if (!$this->areClientPaymentOptionsPermitted) {
                // check if user is trying to store values without permission
                if (
                    isset($_POST['pokaznumerseryjny']) || isset($_POST['pokazstanlicznika']) ||
                    isset($_POST['fakturadlakazdejumowy']) || isset($_POST['umowazbiorcza']) ||
                    isset($_POST['monitoringplatnosci']) || isset($_POST['naliczacodsetki'])
                ) {
                    $this->forbidden('Nie masz prawa do zapisu tych wartości');
                }
                // if edit, also other values are not permitted
                if ($_POST['rowid'] !== '0') {
                    if (
                        isset($_POST['nip']) || isset($_POST['terminplatnosci']) ||
                        isset($_POST['bank']) || isset($_POST['numerrachunku'])
                    ) {
                        $this->forbidden('Nie masz prawa do zapisu tych wartości');
                    }
                }
            }

            $this->client->populateWithPost();

            $saveUpdateResult = $this->client->saveupdate();

            if ($saveUpdateResult['status'] !== 1) {
                $this->internalServerError($saveUpdateResult['info']);
            }

            if ($saveUpdateResult['rows_affected'] === 0) {
                echo(json_encode($saveUpdateResult));
                return;
            }

            $clientRowId = $isCreateClientRequest ? $saveUpdateResult['rowid'] : $clientRowId;

            $client = $this->client->getClientByRowid($clientRowId)[0];

            $createOrUpdateClientData = array(
                "name" => $client["nazwapelna"],
                "shortcut" => $client["nazwakrotka"],
                "tax_no" => $client["nip"],
                "use_mass_payment" => true,
                "mass_payment_code" => BANK_NAME . ' ' . $client["numerrachunku"],
                "email" => $client["mailfaktury"],
                "street" => $client["ulica"],
                "post_code" => $client["kodpocztowy"],
                "city" => $client["miasto"],
                "payment_to_kind" => $client["terminplatnosci"]
            );

            $this->createOrUpdateClientByTaxNo($createOrUpdateClientData);

            echo(json_encode($saveUpdateResult));
        } else {
            $this->notImplemented('Błędne wywołanie');
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

    function showemails()
    {
        global $smarty;
        $dataClient = $this->client->getClients();
        $smarty->assign('dataClient', $dataClient);
        unset($dataClient);
    }


}
