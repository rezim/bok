<?php

class agreementsController extends Controller
{
    function delete()
    {
        if ($_POST['datacounterend'] == '') {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "podaj dane końcowe liczników";
            return;
        }

        $this->agreement->populateWithPost();
        echo(json_encode($this->agreement->delete()));
    }

    function saveupdate()
    {

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            if ($_POST['nrumowy'] == '') {
                die('Wpisz numer umowy!');
            }
            if ($_POST['serial'] == '') {
                die('Wybierz drukarkę!');
            }
            if ($_POST['rowidclient'] == '') {
                die('Wybierz klienta!');
            }
            if ($_POST['dataod'] == '') {
                die('Poda datę startu umowy!');
            }

            list($canSaveActive, $canSaveDraft, $canSaveClosed, $canSaveReplacement) = $this->assignAgreementAccessFlagsForSave();

            $requestedActivity = isset($_POST['activity']) ? (int)$_POST['activity'] : null;

            $allowedActivities = [];
            if ($canSaveActive) {
                $allowedActivities[] = 1;
            }
            if ($canSaveDraft) {
                $allowedActivities[] = -1;
            }
            if ($canSaveClosed) {
                $allowedActivities[] = 0;
            }
            if ($canSaveReplacement) {
                $allowedActivities[] = 2;
            }

            if (!in_array($requestedActivity, $allowedActivities, true)) {
                $this->forbidden('Nie masz prawa zapisu w tym statusie');
            }

            $this->agreement->populateWithPost();
            echo(json_encode($this->agreement->saveupdate()));
        } else {
            echo('Błędne wywołanie');
        }
    }

    function requestreplacement()
    {
        if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'))) {
            echo('Błędne wywołanie');
            return;
        }

        if (!$this->hasAccessToAction('canSaveReplacement')) {
            $this->forbidden('Nie masz prawa zgłoszenia wymiany urządzenia');
        }

        $rowid = isset($_POST['rowid']) ? (int)$_POST['rowid'] : 0;
        if ($rowid <= 0) {
            $this->badRequest('Nieprawidłowe rowid umowy');
        }

        echo(json_encode($this->agreement->requestreplacement($rowid)));
    }

    function addedit()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

            global $smarty;

            $client = new client();
            $dataClient = $client->getClients();

            $smarty->assign('dataClients', $dataClient);

            unset($client);
            unset($dataClient);

            $smarty->assign('prtcntrowid', 0);

            $smarty->assign('dataAgreementTypes', $this->agreement->getAgreementTypes());

            $this->assignAgreementAccessFlagsForAdd();
            $this->assignAgreementAccessFlagsForEdit();
            $this->assignAgreementAccessFlagsForSave();

            $smarty->assign('editMode', $_POST['rowid'] != '0');

            if ($_POST['rowid'] != '0') {
                $dataUmowa = $this->agreement->getUmowaByRowid($_POST['rowid']);
                $smarty->assign('dataUmowa', $dataUmowa);

                if (isset($dataUmowa[0])) {
                    $dataCounters = $this->agreement->getAgreementPrinterCounters($_POST['rowid'], $dataUmowa[0]['serial']);
                }
                if (isset($dataCounters) && count($dataCounters) > 0) {
                    $smarty->assign('prtcntrowid', $dataCounters[0]['rowid']);
                    $smarty->assign('dataCounters', $dataCounters);
                }

                $printer = new printer();
                $dataPrinters = $printer->getPrintersUmowaBezSerialu($dataUmowa[0]['serial']);

                $smarty->assign('dataPrinters', $dataPrinters);
                unset($printer);
                unset($dataPrinters);
                unset($dataUmowa);
            } else {
                $printer = new printer();
                $dataPrinters = $printer->getPrintersUmowa();
                $smarty->assign('dataPrinters', $dataPrinters);

                unset($printer);
                unset($dataPrinters);
            }
            $smarty->assign('rowid', $_POST['rowid']);
        } else {
            header("Location: /");
        }
    }

    function getAgreementPrinterCounters()
    {
        if (isset($_POST['rowid']) && isset($_POST['serial'])) {
            $result = $this->agreement->getAgreementPrinterCounters($_POST['rowid'], $_POST['serial']);
            if (isset($result) && count($result) > 0) {
                echo json_encode($result[0]);
            }
        }
    }

    function showpricehistory()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            global $smarty;

            $rowid = isset($_POST['rowid']) ? (int)$_POST['rowid'] : 0;
            $agreementNb = isset($_POST['nrumowy']) ? $_POST['nrumowy'] : '';

            if ($rowid <= 0) {
                $smarty->assign('priceHistory', []);
                $smarty->assign('agreementNb', $agreementNb);
                return;
            }

            $priceHistory = $this->agreement->getPriceHistoryByAgreementRowid($rowid);
            $smarty->assign('priceHistory', $priceHistory);
            $smarty->assign('agreementNb', $agreementNb);
        } else {
            header("Location: /");
        }
    }

    function showdane()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
            global $smarty;
            $this->agreement->populateWithPost();

            $smarty->assign('activityStatuses', [
                -1 => 'robocza',
                0 => 'zamknięta',
                1 => 'aktywna',
                2 => 'wymiana'
            ]);

            list($canListActive, $canListDraft, $canListClosed, $canListReplacement) = $this->assignAgreementAccessFlags();

            $dataAgreements = $this->agreement->getAgreements($canListActive, $canListDraft, $canListClosed, $canListReplacement);

            $smarty->assign('dataAgreements', $dataAgreements);
            $smarty->assign('czycolorbox', isset($_POST['czycolorbox']) ? $_POST['czycolorbox'] : '');
            unset($dataAgreements);
        } else {
            header("Location: /");
        }
    }

    function show()
    {
        global $smarty;

        $this->assignAgreementAccessFlags();

        if (isset($_POST['czycolorbox'])) {
            $smarty->assign('clientnazwakrotka', $_POST['clientnazwakrotka']);
            $smarty->assign('serial', $_POST['serial']);
            $smarty->assign('czycolorbox', $_POST['czycolorbox']);
        } else
            $smarty->assign('czycolorbox', '');

    }

    function print_pdf() {

        global $smarty;

        $contractNumber = $this->_queryString[0] ?? null;
        if (!$contractNumber) {
            http_response_code(400);
            exit('Missing contract number');
        }

        $rows = $this->agreement->getUmowaCheck($contractNumber);
        $agreementCheck = $rows[0] ?? null;
        if (!$agreementCheck) {
            http_response_code(404);
            exit('Agreement not found');
        }

        $contract = [
            'number'      => $agreementCheck['nr_umowy'],
             'date'       => date('d.m.Y'),
             'city'       => 'Wrocławiu',
             'term_months'=> (int)($agreementCheck['ilosc_miesiecy'] ?? 0),
        ];

        $tenant = [
            'name'            => $agreementCheck['Najemca'] ?? '',
            'representative'  => $agreementCheck['Reprezentant'] ?? '',
            'address'         => $agreementCheck['Adres_Siedziby'] ?? '',
            'nip'             => $agreementCheck['NIP'] ?? '',
            'krs_pesel'       => $agreementCheck['KRS_PESEL'] ?? '',
            'invoice_email'   => $agreementCheck['Email_Faktury'] ?? '',
            'install_address' => $agreementCheck['Adres_Instalacji'] ?? '',
            'contact_person'  => $agreementCheck['Pomoc_Wniesienie'] ?? '',
        ];

        $device = [
            'model'     => $agreementCheck['model_urzadzenia'] ?? '-',
            'value_net' => $agreementCheck['wartoscurzadzenia'] ?? '-',
        ];

        $pricing = [
            'rent_net'            => $agreementCheck['abonament'] ?? '',
            'limit_mono'          => $agreementCheck['stronwabonamencie'] ?? '',
            'price_mono_over'     => $agreementCheck['cenazastrone'] ?? '',
            'limit_color'         => $agreementCheck['iloscstron_color'] ?? '',
            'price_color_over'    => $agreementCheck['cenazastrone_kolor'] ?? '',
            'limit_scan'          => $agreementCheck['iloscskans'] ?? '',
            'price_scan_over'     => $agreementCheck['cenazascan'] ?? '',
            'delivery_install_net'=> $agreementCheck['cenainstalacji'] ?? '',
        ];

        $smarty->assign('contract', $contract);
        $smarty->assign('tenant', $tenant);
        $smarty->assign('device', $device);
        $smarty->assign('pricing', $pricing);

        $tpl  = ROOT . '/templates/print_pdf.tpl';
        $html = $smarty->fetch($tpl);

        $this->renderPdf($html, 'umowa.pdf');
    }

    private function assignAgreementAccessFlags(): array
    {
        global $smarty;

        $canListActive = $this->hasAccessToAction('canListActive');
        $canListDraft = $this->hasAccessToAction('canListDraft');
        $canListClosed = $this->hasAccessToAction('canListClosed');
        $canListReplacement = $this->hasAccessToAction('canListReplacement');

        $smarty->assign('canListActive', $canListActive);
        $smarty->assign('canListDraft', $canListDraft);
        $smarty->assign('canListClosed', $canListClosed);
        $smarty->assign('canListReplacement', $canListReplacement);

        return [$canListActive, $canListDraft, $canListClosed, $canListReplacement];
    }

    private function assignAgreementAccessFlagsForEdit(): array
    {
        global $smarty;

        $canEditActive = $this->hasAccessToAction('canEditActive');
        $canEditDraft = $this->hasAccessToAction('canEditDraft');
        $canEditClosed = $this->hasAccessToAction('canEditClosed');
        $canEditReplacement = $this->hasAccessToAction('canEditReplacement');

        $smarty->assign('canEditActive', $canEditActive);
        $smarty->assign('canEditDraft', $canEditDraft);
        $smarty->assign('canEditClosed', $canEditClosed);
        $smarty->assign('canEditReplacement', $canEditReplacement);

        return [$canEditActive, $canEditDraft, $canEditClosed, $canEditReplacement];
    }

    private function assignAgreementAccessFlagsForAdd(): array
    {
        global $smarty;

        $canAddActive = $this->hasAccessToAction('canAddActive');
        $canAddDraft = $this->hasAccessToAction('canAddDraft');
        $canAddClosed = $this->hasAccessToAction('canAddClosed');
        $canAddReplacement = $this->hasAccessToAction('canAddReplacement');

        $smarty->assign('canAddActive', $canAddActive);
        $smarty->assign('canAddDraft', $canAddDraft);
        $smarty->assign('canAddClosed', $canAddClosed);
        $smarty->assign('canAddReplacement', $canAddReplacement);

        return [$canAddActive, $canAddDraft, $canAddClosed, $canAddReplacement];
    }

    private function assignAgreementAccessFlagsForSave(): array
    {
        global $smarty;

        $canSaveActive = $this->hasAccessToAction('canSaveActive');
        $canSaveDraft = $this->hasAccessToAction('canSaveDraft');
        $canSaveClosed = $this->hasAccessToAction('canSaveClosed');
        $canSaveReplacement = $this->hasAccessToAction('canSaveReplacement');

        $smarty->assign('canSaveActive', $canSaveActive);
        $smarty->assign('canSaveDraft', $canSaveDraft);
        $smarty->assign('canSaveClosed', $canSaveClosed);
        $smarty->assign('canSaveReplacement', $canSaveReplacement);

        return [$canSaveActive, $canSaveDraft, $canSaveClosed, $canSaveReplacement];
    }
}
