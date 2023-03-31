<?php

class reportsController extends InvoicesController
{
    private $REPORT_FIELD_NAMES = array('strony_black_koniec', 'strony_black_start', 'strony_kolor_koniec', 'strony_kolor_start',
        'data_wiadomosci_black_koniec', 'data_wiadomosci_black_start', 'data_wiadomosci_kolor_koniec', 'data_wiadomosci_kolor_start', 'serials');

    private $CLIENT_FIELD_NAMES = array('rowidclient', 'nazwapelna', 'nazwakrotka', 'terminplatnosci', 'nip',
        'mailfaktury', 'ulica', 'miasto', 'kodpocztowy', 'pokaznumerseryjny',
        'pokazstanlicznika', 'fakturadlakazdejumowy', 'bank', 'numerrachunku');

    private $AGREEMENT_FIELDS = array('rowidumowa', 'nrumowy', 'serial', 'model', 'rozliczenie', 'strony_black_start', 'data_wiadomosci_black_start', 'strony_black_koniec',
        'data_wiadomosci_black_koniec', 'strony_kolor_start', 'data_wiadomosci_kolor_start', 'strony_kolor_koniec', 'data_wiadomosci_kolor_koniec', 'strony_black_sum',
        'strony_kolor_sum', 'serials', 'nazwakrotka', 'lokalizacja_ulica', 'lokalizacja_miasto', 'lokalizacja_kodpocztowy', 'lokalizacja_telefon', 'lokalizacja_mail', 'lokalizacja_nazwa',
        'typ_umowy', 'odbiorca_id');

    function show()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));

        $smarty->assign('fakturownia_conf_file_path', ROOT . DS . 'config' . DS . 'fakturownia.conf');
    }

    function groupByCollectiveAgreements($reports)
    {
        $result = array();

        foreach ($reports as $key => $report) {

            $collectiveAgreementId = $report['rowidumowazbiorcza'];
            if ($collectiveAgreementId !== null && isset($reports[$collectiveAgreementId])) {
                // we need it now, to add agreements belongs to collective agreement
                if (!isset($result[$collectiveAgreementId])) {
                    $result[$collectiveAgreementId] = $reports[$collectiveAgreementId];
                }

                $collectiveAgreement = &$result[$collectiveAgreementId];

                if (!isset($collectiveAgreement['lista_umow'])) {
                    clearArray($collectiveAgreement, $this->REPORT_FIELD_NAMES);
                    $collectiveAgreement['lista_umow'] = array();
                    $collectiveAgreement['strony_black_sum'] = 0;
                    $collectiveAgreement['strony_kolor_sum'] = 0;
                }
                mergeArrays($collectiveAgreement, $report, $this->REPORT_FIELD_NAMES);
                $collectiveAgreement['lista_umow'][$key] = $report;
                $collectiveAgreement['strony_black_sum'] += sumOfArrayRanges($report, 'strony_black_koniec', 'strony_black_start');
                $collectiveAgreement['strony_kolor_sum'] += sumOfArrayRanges($report, 'strony_kolor_koniec', 'strony_kolor_start');
            } else {
                // it could happen it was already added
                if (!isset($result[$key])) {

                    $result[$key] = $report;
                }
            }
        }

        return $result;
    }

    function groupByAgreement($reports)
    {
        $result = array();

        foreach ($reports as $report) {
            if (!isset($result[$report['rowidumowa']])) {
                $result[$report['rowidumowa']] = $report;
            } else {
                if ($report['serial'] == $report['currentserial']) {
                    $tmpReport = $report;
                    $report = $result[$report['rowidumowa']];
                    $result[$report['rowidumowa']] = $tmpReport;

                    $result[$report['rowidumowa']]['serials'] = array($result[$report['rowidumowa']]['serial']);

                }

                mergeArrays($result[$report['rowidumowa']], $report, $this->REPORT_FIELD_NAMES);

                $result[$report['rowidumowa']]['strony_black_sum'] += ($report['strony_black_sum']);
                $result[$report['rowidumowa']]['strony_kolor_sum'] += ($report['strony_kolor_sum']);

                $result[$report['rowidumowa']]['serials'][] = $report['serial'];
            }
        }

        return $result;
    }

    function applyReplacement($reports, $replacements)
    {
        foreach ($replacements as $replacement) {
            $agr_id = $replacement['rowid_agreement'];
            if (isset($reports[$agr_id])) {
                $indexSerial = array_search($replacement['serial'], $reports[$agr_id]['serials']);
                $indexNewSerial = array_search($replacement['new_serial'], $reports[$agr_id]['serials']);

                if ($indexSerial !== false) {
                    $reports[$agr_id]['strony_black_koniec'][$indexSerial] = $replacement['ilosc_koniec'];
                    $reports[$agr_id]['strony_kolor_koniec'][$indexSerial] = $replacement['ilosckolor_koniec'];

                    $reports[$agr_id]['data_wiadomosci_black_koniec'][$indexSerial] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_kolor_koniec'][$indexSerial] = $replacement['date'];
                }

                if ($indexNewSerial !== false) {
                    $reports[$agr_id]['strony_black_start'][$indexNewSerial] = $replacement['ilosc_start'];
                    $reports[$agr_id]['strony_kolor_start'][$indexNewSerial] = $replacement['ilosckolor_start'];

                    $reports[$agr_id]['data_wiadomosci_black_start'][$indexNewSerial] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_kolor_start'][$indexNewSerial] = $replacement['date'];
                } else {
                    $reports[$agr_id]['strony_black_start'][] = $replacement['ilosc_start'];
                    $reports[$agr_id]['strony_black_koniec'][] = 0;
                    $reports[$agr_id]['strony_kolor_start'][] = $replacement['ilosckolor_start'];
                    $reports[$agr_id]['strony_kolor_koniec'][] = 0;

                    $reports[$agr_id]['data_wiadomosci_black_start'][] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_black_koniec'][] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_kolor_start'][] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_kolor_koniec'][] = $replacement['date'];

                    $reports[$agr_id]['serials'][] = $replacement['new_serial'];
                }

                if ($indexSerial !== false && $indexNewSerial !== false) {
                    $reports[$agr_id]['strony_black_sum'] =
                        $reports[$agr_id]['strony_black_koniec'][$indexSerial] - $reports[$agr_id]['strony_black_start'][$indexSerial] +
                        $reports[$agr_id]['strony_black_koniec'][$indexNewSerial] - $reports[$agr_id]['strony_black_start'][$indexNewSerial];
                    $reports[$agr_id]['strony_kolor_sum'] =
                        $reports[$agr_id]['strony_kolor_koniec'][$indexSerial] - $reports[$agr_id]['strony_kolor_start'][$indexSerial] +
                        $reports[$agr_id]['strony_kolor_koniec'][$indexNewSerial] - $reports[$agr_id]['strony_kolor_start'][$indexNewSerial];
                }
            }
        }

        return $reports;
    }

    function applyAgreementPrinters($reports, $agreementPrintersStart, $agreementPrintersEnd)
    {
        $result = array();

        foreach ($reports as $report) {
            $agreementPrintersKey = $report['serial'] . '-' . $report['rowidumowa'];
            if (isset($agreementPrintersStart[$agreementPrintersKey])
                && $report['rowidumowa'] == $agreementPrintersStart[$agreementPrintersKey]['rowid_agreement']) {
                $report['strony_black_start'] = $agreementPrintersStart[$agreementPrintersKey]['ilosc_start'];
                $report['strony_kolor_start'] = $agreementPrintersStart[$agreementPrintersKey]['ilosckolor_start'];
                $report['data_wiadomosci_black_start'] = $agreementPrintersStart[$agreementPrintersKey]['date_start'];
                $report['data_wiadomosci_kolor_start'] = $agreementPrintersStart[$agreementPrintersKey]['date_start'];
            }
            if (isset($agreementPrintersEnd[$agreementPrintersKey])
                && $report['rowidumowa'] == $agreementPrintersEnd[$agreementPrintersKey]['rowid_agreement']) {
                $report['strony_black_koniec'] = $agreementPrintersEnd[$agreementPrintersKey]['ilosc_koniec'];
                $report['strony_kolor_koniec'] = $agreementPrintersEnd[$agreementPrintersKey]['ilosckolor_koniec'];
                $report['data_wiadomosci_black_koniec'] = $agreementPrintersEnd[$agreementPrintersKey]['date_koniec'];
                $report['data_wiadomosci_kolor_koniec'] = $agreementPrintersEnd[$agreementPrintersKey]['date_koniec'];

                $dateEnd = new DateTime($report['data_wiadomosci_black_koniec']);
                $daysInMoth = cal_days_in_month(CAL_GREGORIAN, date_format($dateEnd, 'm'), date_format($dateEnd, 'Y'));
                $amountOfDays =  intval( $dateEnd->format('d') );

                $report['stronwabonamencie'] *= ($amountOfDays / $daysInMoth);
                $report['iloscstron_kolor'] *= ($amountOfDays / $daysInMoth);
                $report['abonament'] *= ($amountOfDays / $daysInMoth);
            }

            $result[$report['serial']] = $report;
        }

        return $result;
    }

    function applyService($reports, $service)
    {
        $result = array();

        foreach ($reports as $report) {

            if (isset($service[$report['serial']])) {

                $srvs = $service[$report['serial']];

                $result[$report['serial']] = $report;

                $result[$report['serial']]['strony_black_koniec'] = array();
                $result[$report['serial']]['strony_black_start'] = array($report['strony_black_start']);
                $result[$report['serial']]['strony_kolor_koniec'] = array();
                $result[$report['serial']]['strony_kolor_start'] = array($report['strony_kolor_start']);

                $result[$report['serial']]['data_wiadomosci_black_koniec'] = array();
                $result[$report['serial']]['data_wiadomosci_black_start'] = array($report['data_wiadomosci_black_start']);
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'] = array();
                $result[$report['serial']]['data_wiadomosci_kolor_start'] = array($report['data_wiadomosci_kolor_start']);

                $result[$report['serial']]['serials'] = array($report['serial']);
                foreach ($srvs as $srv) {
                    $result[$report['serial']]['strony_black_koniec'][] = $srv['ilosc_koniec'];
                    $result[$report['serial']]['strony_black_start'][] = $srv['ilosc_start'];
                    $result[$report['serial']]['strony_kolor_koniec'][] = $srv['ilosckolor_koniec'];
                    $result[$report['serial']]['strony_kolor_start'][] = $srv['ilosckolor_start'];

                    $result[$report['serial']]['data_wiadomosci_black_koniec'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_black_start'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_kolor_koniec'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_kolor_start'][] = $srv['date'];

                    $result[$report['serial']]['serials'][] = $report['serial'];
                }
                $result[$report['serial']]['strony_black_koniec'][] = $report['strony_black_koniec'];
                $result[$report['serial']]['strony_kolor_koniec'][] = $report['strony_kolor_koniec'];

                $result[$report['serial']]['data_wiadomosci_black_koniec'][] = $report['data_wiadomosci_black_koniec'];
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'][] = $report['data_wiadomosci_kolor_koniec'];

                $result[$report['serial']]['strony_black_sum'] = 0;
                $result[$report['serial']]['strony_kolor_sum'] = 0;
                for ($i = 0; $i < count($result[$report['serial']]['strony_black_koniec']); $i++) {
                    $result[$report['serial']]['strony_black_sum'] += $result[$report['serial']]['strony_black_koniec'][$i] - $result[$report['serial']]['strony_black_start'][$i];
                    $result[$report['serial']]['strony_kolor_sum'] += $result[$report['serial']]['strony_kolor_koniec'][$i] - $result[$report['serial']]['strony_kolor_start'][$i];
                }

            } else {
                $result[$report['serial']] = $report;
                $result[$report['serial']]['strony_black_koniec'] = array($report['strony_black_koniec']);
                $result[$report['serial']]['strony_black_start'] = array($report['strony_black_start']);
                $result[$report['serial']]['strony_kolor_koniec'] = array($report['strony_kolor_koniec']);
                $result[$report['serial']]['strony_kolor_start'] = array($report['strony_kolor_start']);

                $result[$report['serial']]['data_wiadomosci_black_koniec'] = array($report['data_wiadomosci_black_koniec']);
                $result[$report['serial']]['data_wiadomosci_black_start'] = array($report['data_wiadomosci_black_start']);
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'] = array($report['data_wiadomosci_kolor_koniec']);
                $result[$report['serial']]['data_wiadomosci_kolor_start'] = array($report['data_wiadomosci_kolor_start']);

                $result[$report['serial']]['strony_black_sum'] = $report['strony_black_koniec'] - $report['strony_black_start'];
                $result[$report['serial']]['strony_kolor_sum'] = $report['strony_kolor_koniec'] - $report['strony_kolor_start'];

                $result[$report['serial']]['serials'] = array($report['serial']);
            }
        }

        return $result;
    }

    function getPrinterServiceMap($arrPrinterService)
    {
        $result = array();

        foreach ($arrPrinterService as $service) {
            if ($service['serial'] == $service['new_serial']) {
                if (!isset($result[$service['serial']])) {
                    $result[$service['serial']] = array($service);
                } else {
                    $result[$service['serial']][] = $service;
                }
            }
        }

        return $result;
    }

    function getAgreementPrintersMap($arrAgreementPrinters)
    {
        $result = array();

        foreach ($arrAgreementPrinters as $printerAgreement) {
            if (!isset($result[$printerAgreement['serial']])) {
                $result[$printerAgreement['serial'] . '-' . $printerAgreement['rowid_agreement']] = $printerAgreement;
            }
        }

        return $result;
    }

    function getPrinterReplacements($arrPrinterService)
    {
        $result = array();

        foreach ($arrPrinterService as $service) {
            if ($service['serial'] != $service['new_serial']) {
                $result[] = $service;
            }
        }

        return $result;
    }

    function hasError($agreement)
    {

        for ($idx = 0; $idx < count($agreement['strony_black_koniec']); $idx++) {
            if ($agreement['strony_black_koniec'][$idx] == 0 && $agreement['strony_black_start'][$idx] == 0) {
                return 1;
            }
            if (($agreement['strony_black_koniec'][$idx] - $agreement['strony_black_start'][$idx]) < 0) {
                return 1;
            }
            if (($agreement['strony_kolor_koniec'][$idx] - $agreement['strony_kolor_start'][$idx]) < 0) {
                return 1;
            }
        }

        // check for date for black and color,
        if ($this->isDateIncorrect($agreement['data_wiadomosci_black_koniec'][0], $this->report->getDateTo())) {
            return 2;
        }
        // check for date for color,
        if ($this->isDateIncorrect($agreement['data_wiadomosci_kolor_koniec'][0], $this->report->getDateTo())) {
            return 2;
        }

        if ($agreement['strony_black_sum'] == 0) {
            return 1;
        }

        return 0;
    }

    function showdaneklient()
    {

        $this->report->populateWithPost();
        $dataReportsMiesieczne = $this->report->getReportsMiesieczne();
        $dataReportsRoczne = $this->report->getReportsRoczne();

        $agreementPrintersStart = $this->getAgreementPrintersMap($this->report->getAgreementPrintersStart());
        $agreementPrintersEnd = $this->getAgreementPrintersMap($this->report->getAgreementPrintersEnd());

        $dataReportsMiesieczne = $this->applyAgreementPrinters($dataReportsMiesieczne, $agreementPrintersStart, $agreementPrintersEnd);

        $dataPrinterService = $this->getPrinterServiceMap($this->report->getPrinterService());

        $dataPrinterReplacement = $this->getPrinterReplacements($this->report->getPrinterService());

        $dataReportsMiesieczne = $this->applyService($dataReportsMiesieczne, $dataPrinterService);

        $dataReportsMiesieczne = $this->groupByAgreement($dataReportsMiesieczne);

        $dataReportsMiesieczne = $this->applyReplacement($dataReportsMiesieczne, $dataPrinterReplacement);

        $dataReportsMiesieczne = $this->groupByCollectiveAgreements($dataReportsMiesieczne);


        foreach ($dataReportsMiesieczne as $key => $item) {

            $dayOfDateRange = 0;
            $setupFee = 0;
            $daysAmount = date("t", strtotime($item['dataod']));

            $clientId = $item['rowidclient'];

            if (
                date("m", strtotime($item['dataod'])) == date("m", strtotime($item['dacik'])) &&
                date("Y", strtotime($item['dataod'])) == date("Y", strtotime($item['dacik']))) {
                $dayOfDateRange = date("j", strtotime($item['dataod'])) - 1;
                $setupFee = $item['cenainstalacji'];
            }

            if (!isset($dataReports[$clientId])) {
                $dataReports[$clientId] = array();
            }

            $client = &$dataReports[$clientId];

            $agreement = &$client['umowy'][$item['rowidumowa']];

            if (!isset($client['drukumowy'])) {
                $client['drukumowy'] = 1;
            } else {
                $client['drukumowy'] += 1;
            }

            copyArrays($client, $item, $this->CLIENT_FIELD_NAMES);

            // add collective agreements
            if (isset($item['lista_umow'])) {
                $client['umowy'][$item['rowidumowa']]['lista_umow'] = $item['lista_umow'];
            }

            // only for printers check for errors
            if ($item['typ_umowy'] === 'wynajem drukarki') {

                $hasError = $this->hasError($item);

                if ($hasError > 0) {
                    $client['blad'] = 1;
                    $agreement['blad'] = 1;
                }
                if ($hasError === 2) {
                    if ($item['strony_black_koniec'][0] > $item['strony_black_start'][0] ||
                        $item['strony_kolor_koniec'][0] > $item['strony_kolor_start'][0]) {

                        $agreement['fix'] = array(
                            "dateTo" => $this->report->getDateTo(),
                            "black" => $item['strony_black_koniec'][0],
                            "color" => $item['strony_kolor_koniec'][0],
                            "serial" => $item['currentserial']);
                    }
                }
            }
            // check for error for collective agreements
            if ($item['typ_umowy'] === 'umowa zbiorcza' && isset($item['lista_umow'])) {
                foreach ($item['lista_umow'] as $agrKey => $agr) {
                    $hasError = $this->hasError($agr);
                    if ($hasError > 0) {
                        $client['blad'] = 1;
                        $agreement['blad'] = 1;
                        $agreement['lista_umow'][$agrKey]['blad'] = 1;
                    }
                    if ($hasError === 2) {
                        if ($agr['strony_black_koniec'][0] > $agr['strony_black_start'][0] ||
                            $agr['strony_kolor_koniec'][0] > $agr['strony_kolor_start'][0]) {
                            $agreement['lista_umow'][$agrKey]['fix'] = array(
                                "dateTo" => $this->report->getDateTo(),
                                "black" => $agr['strony_black_koniec'][0],
                                "color" => $agr['strony_kolor_koniec'][0],
                                "serial" => $agr['currentserial']);
                        }
                    }
                }
            }

            $dataReports['suma'] = isset($dataReports['suma']) ? $dataReports['suma'] : 0;
            $client['wartosc'] = isset($client['wartosc']) ? $client['wartosc'] : 0;
            $client['wartoscblack'] = isset($client['wartoscblack']) ? $client['wartoscblack'] : 0;
            $client['wartosckolor'] = isset($client['wartosckolor']) ? $client['wartosckolor'] : 0;
            $client['wartoscabonament'] = isset($client['wartoscabonament']) ? $client['wartoscabonament'] : 0;
            $client['kwotadowykorzystania'] = isset($client['kwotadowykorzystania']) ? $client['kwotadowykorzystania'] : 0;

            $item['rabatdoabonamentu'] = (empty($item['rabatdoabonamentu']) || $item['rabatdoabonamentu'] == '') ? 0 : $item['rabatdoabonamentu'];
            $item['rabatdowydrukow'] = (empty($item['rabatdowydrukow']) || $item['rabatdowydrukow'] == '') ? 0 : $item['rabatdowydrukow'];

            $subscription = (float)$item['abonament'];
            $amountInSubscription = (float)$item['kwotawabonamencie'];
            $hasAmountInSubscription = $amountInSubscription > 0;
            if ($dayOfDateRange != 0) {
                $subscription = $subscription - ($dayOfDateRange * ($subscription / $daysAmount));
            }
            $subscription = $subscription - ($subscription * ($item['rabatdoabonamentu'] / 100));

            $client['wartoscabonament'] += $subscription;

            if ($dayOfDateRange != 0) {
                $item['stronwabonamencie'] = $item['stronwabonamencie'] - ($dayOfDateRange * ($item['stronwabonamencie'] / $daysAmount));
                $item['iloscstron_kolor'] = $item['iloscstron_kolor'] - ($dayOfDateRange * ($item['iloscstron_kolor'] / $daysAmount));
            }

            $blackPagesNb = (int)$item['strony_black_sum'];
            $colorPagesNb = (int)$item['strony_kolor_sum'];
            $allPagesNb = $blackPagesNb + $colorPagesNb;

            $blackPrice = (float)$item['cenazastrone'];
            $colorPrice = (float)$item['cenazastrone_kolor'];
            $discount = $item['rabatdowydrukow'] / 100;

            $allPagesValue = ($blackPagesNb * $blackPrice + $colorPagesNb * $colorPrice);

            $client['kwotadowykorzystania'] += $hasAmountInSubscription ? max($allPagesValue - $amountInSubscription, 0) : 0;

            $contract = array("black" => !$hasAmountInSubscription ? $item['stronwabonamencie'] : 0, "color" => !$hasAmountInSubscription ? $item['iloscstron_kolor'] : 0);

            if (isset($item['jakczarne']) && !empty($item['jakczarne']) && $item['jakczarne'] == 1) {
                // black
                $blackExceeded = round(max($allPagesNb - $contract["black"], 0));
                $blackValue = $blackExceeded * $blackPrice;
                $blackValue = $blackValue - ($blackValue * $discount);
                $client['wartoscblack'] += !$hasAmountInSubscription ? $blackValue : 0;
                // color
                $colorValue = 0;
                $client['wartosckolor'] = !$hasAmountInSubscription ? $colorValue : 0;
            } else {
                // black
                $blackExceeded = round(max($blackPagesNb - $contract["black"], 0));
                $blackValue = $blackExceeded * $blackPrice;
                $blackValue = ($blackValue - ($blackValue * $discount));
                $client['wartoscblack'] += !$hasAmountInSubscription ? $blackValue : 0;
                // color
                $colorExceeded = round(max($colorPagesNb - $contract["color"], 0));
                $colorValue = $colorExceeded * $colorPrice;
                $colorValue = $colorValue - ($colorValue * $discount);
                $client['wartosckolor'] += !$hasAmountInSubscription ? $colorValue : 0;
            }

            $totalValue = $hasAmountInSubscription ?
                $subscription + max($allPagesValue - $amountInSubscription, 0) :
                $subscription + $blackValue + $colorValue + $setupFee;
            $client['wartosc'] += $totalValue;

            $dataReports['suma'] += $totalValue;

            $agreement['stronwabonamencie'] = $contract["black"];
            $agreement['stronwabonamencie_kolor'] = $contract["color"];

            $agreement['wartoscblack'] = $blackValue;
            $agreement['wartosckolor'] = $colorValue;

            $agreement['stronblackpowyzej'] = $blackExceeded;
            $agreement['stronkolorpowyzej'] = $colorExceeded;

            $agreement['cenazastrone'] = $blackPrice;
            $agreement['cenazastrone_kolor'] = $colorPrice;
            $agreement['wartoscabonament'] = $subscription;
            $agreement['kwotadowykorzystania'] = $amountInSubscription;

            $agreement['oplatainstalacyjna'] = $setupFee;


            $agreement['wartosc'] = $totalValue;

            copyArrays($agreement, $item, $this->AGREEMENT_FIELDS);
        }

        foreach ($dataReportsRoczne as $key => $item) {

            $clientId = $item['rowidclient'];

            if (!isset($dataReports[$clientId])) {
                $dataReports[$clientId] = array();
            }

            $client = &$dataReports[$clientId];

            $agreement = &$client['umowy'][$item['rowidumowa']];

            if (!isset($client['drukumowy']))
                $client['drukumowy'] = 1;
            else
                $client['drukumowy'] += 1;

            copyArrays($client, $item, $this->CLIENT_FIELD_NAMES);

            $setupFee = 0;


            if (
                (date("Y", strtotime($item['dataod']))) == date("Y", strtotime($item['dacik']))) {

                $setupFee = $item['cenainstalacji'];
            }


            if (!isset($dataReports['suma'])) {
                $dataReports['suma'] = 0;
            }

            if (!isset($client['wartosc'])) {
                $client['wartosc'] = 0;
            }
            if (!isset($client['wartoscblack'])) {
                $client['wartoscblack'] = 0;
            }
            if (!isset($client['wartosckolor'])) {
                $client['wartosckolor'] = 0;
            }
            if (!isset($client['wartoscabonament'])) {
                $client['wartoscabonament'] = 0;
            }

            if (empty($item['rabatdoabonamentu']) || $item['rabatdoabonamentu'] == '') {
                $item['rabatdoabonamentu'] = 0;
            }
            if (empty($item['rabatdowydrukow']) || $item['rabatdowydrukow'] == '') {
                $item['rabatdowydrukow'] = 0;
            }
            $subscription = (float)$item['abonament'];

            $client['wartoscabonament'] = $client['wartoscabonament'] + $subscription;


            $blackPrice = (float)$item['cenazastrone'];
            $colorPrice = (float)$item['cenazastrone_kolor'];
            $contract = array("black" => $item['stronwabonamencie'], "color" => $item['iloscstron_kolor']);

            $blackExceeded = 0;
            $wartoscblacktemp = 0;
            $wartoscblack = 0;
            $client['wartoscblack'] = $client['wartoscblack'] + $wartoscblack;

            $colorExceeded = 0;
            $colorValue = 0;
            $wartosckolor = 0;
            $client['wartosckolor'] = 0;

            $totalValue = $wartoscblack + $wartosckolor + $setupFee;

            $client['wartosc'] += $totalValue;

            $dataReports['suma'] += $totalValue;

            $agreement['oplatainstalacyjna'] = $setupFee;

            $agreement['wartoscabonament'] = $subscription;
            $agreement['kwotawabonamencie'] = $amountInSubscription;
            $agreement['wartoscblack'] = $wartoscblack;
            $agreement['wartosckolor'] = $wartosckolor;
            $agreement['stronblackpowyzej'] = $blackExceeded;
            $agreement['stronkolorpowyzej'] = $colorExceeded;
            $agreement['wartosc'] = $totalValue;


            $agreement['stronwabonamencie'] = $contract["black"];
            $agreement['cenazastrone'] = $blackPrice;
            $agreement['stronwabonamencie_kolor'] = $contract["color"];
            $agreement['cenazastrone_kolor'] = $colorPrice;


            copyArrays($agreement, $item, $this->AGREEMENT_FIELDS);

            // TODO: overriding some fields, to check if it is really needed
            // TODO: this is temporary solution, this should be also updated with the same code as for month agreements
            $agreement['strony_black_sum'] = $item['strony_black_koniec'] - $item['strony_black_start'];
            $agreement['strony_kolor_sum'] = $item['strony_kolor_koniec'] - $item['strony_kolor_start'];
            // TODO: this probably wont work
            $agreement['serials'] = array($item['serial']);

        }

        global $smarty;
        $smarty->assign('dataReports', $dataReports);
        unset($dataReports);
    }

    function isDateIncorrect($strDateToCheck, $strDateTo)
    {
        $dateTo = new DateTime($strDateTo);
        $dateToCheck = new DateTime($strDateToCheck);
        $today = new DateTime();

        return $today > $dateTo && $dateTo->format('Y-m-d') != $dateToCheck->format('Y-m-d');
    }


    function getinvoices()
    {
        if ($_POST['period'] && $_POST['date_from'] && $_POST['date_to']) {
            echo json_encode($this->getInvoicesByDateRange($_POST['period'], $_POST['date_from'], $_POST['date_to']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }
}


function sumOfArrayRanges(array $array, $rightRangeFieldName, $leftRangeFieldName)
{
    $sum = 0;
    for ($i = 0; $i < count($array[$rightRangeFieldName]); $i++) {
        $sum += $array[$rightRangeFieldName][$i] - $array[$leftRangeFieldName][$i];
    }

    return $sum;
}

function clearArray(array &$array, array $fields)
{
    foreach ($fields as $field) {
        $array[$field] = array();
    }
}

function mergeArrays(array &$destination, array $source, array $fields)
{
    foreach ($fields as $field) {
        $destination[$field] = array_merge($destination[$field], $source[$field]);
    }
}

function copyArrays(array &$destination, array $source, array $fields)
{
    foreach ($fields as $field) {
        if (isset($source[$field])) {
            $destination[$field] = $source[$field];
        }
    }
}