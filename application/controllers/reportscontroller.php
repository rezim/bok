<?php

const
SCAN_START = 'skany_start',
SCAN_END = 'skany_koniec',
SCAN_SERIAL = 'skany_serial',
SCAN_DATE_START = 'data_wiadomosci_scans_start',
SCAN_DATE_END = 'data_wiadomosci_scans_koniec',
SCAN_PRICE = 'cenazascan',
SCAN_AMOUNT_FOR_FREE = 'iloscskans',
SCAN_SUM = 'skany_sum',
SCANS_NEXT_MONTH = 'next_month_skany',
SCANS_VALUE = 'wartoscscans',
SCANS_AMOUNT_PAID = 'scanspowyzej';

class reportsController extends InvoicesController
{
    private $REPORT_FIELD_NAMES = array('strony_black_koniec', 'strony_black_start', 'strony_kolor_koniec', 'strony_kolor_start',
        'data_wiadomosci_black_koniec', 'data_wiadomosci_black_start', 'data_wiadomosci_kolor_koniec', 'data_wiadomosci_kolor_start',
        'serials', SCAN_START, SCAN_END, SCAN_DATE_START, SCAN_DATE_END);

    private $CLIENT_FIELD_NAMES = array('rowidclient', 'nazwapelna', 'nazwakrotka', 'terminplatnosci', 'nip',
        'mailfaktury', 'ulica', 'miasto', 'kodpocztowy', 'pokaznumerseryjny',
        'pokazstanlicznika', 'fakturadlakazdejumowy', 'bank', 'numerrachunku');

    private $AGREEMENT_FIELDS = array('rowidumowa', 'nrumowy', 'serial', 'model', 'rozliczenie', 'strony_black_start', 'data_wiadomosci_black_start', 'strony_black_koniec',
        'data_wiadomosci_black_koniec', 'strony_kolor_start', 'data_wiadomosci_kolor_start', 'strony_kolor_koniec', 'data_wiadomosci_kolor_koniec',
        SCAN_START, SCAN_END, SCAN_DATE_START, SCAN_DATE_END, SCAN_SUM,
        'strony_black_sum',
        'strony_kolor_sum', 'serials', 'nazwakrotka', 'lokalizacja_ulica', 'lokalizacja_miasto', 'lokalizacja_kodpocztowy', 'lokalizacja_telefon', 'lokalizacja_mail', 'lokalizacja_nazwa',
        'typ_umowy', 'odbiorca_id', 'next_month_black', 'next_month_kolor', 'next_month_datawiadomosci');

    function show()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));

        $smarty->assign('fakturownia_conf_file_path', ROOT . DS . 'config' . DS . 'fakturownia.conf');
    }

    function scansreport()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));
    }

    function scansreportdata()
    {
        global $smarty;
        $this->report->populateWithPost();
        $scans = $this->report->getScansByDate();

        if (count($scans) === 0) {
            $smarty->assign('isEmptyMessage', 'Dla podanych filtrów nie ma żadnych danych do wyświetlenia.');
        } else {
            $columnNames = array_keys($scans[0]);

            $columnSummaries = array_map(fn($columnName) => array_sum(array_map(fn($val) => is_numeric($val) ? $val : 0, array_column($scans, $columnName))), $columnNames);

            $smarty->assign('columnNames', $columnNames);
            $smarty->assign('columnSummaries', $columnSummaries);
            $smarty->assign('scans', $scans);
        }
    }

    function countersreport()
    {
        global $smarty;

        $smarty->assign('days', 3);
    }

    function countersreportdata()
    {
        global $smarty;

        $days = isset($_POST['days']) ? (int)$_POST['days'] : 3;
        $serial = $_POST['serial'] ?? '';
        $counters = $this->report->getCountersReport($days, $serial);

        if (count($counters) === 0) {
            $smarty->assign('isEmptyMessage', 'Dla podanych filtrów nie ma żadnych liczników do wyświetlenia.');
        } else {
            $columnNames = array_keys($counters[0]);

            $columnSummaries = array_map(fn($columnName) => array_sum(array_map(fn($val) => is_numeric($val) ? $val : 0, array_column($counters, $columnName))), $columnNames);

            $smarty->assign('columnNames', $columnNames);
            $smarty->assign('columnSummaries', $columnSummaries);
            $smarty->assign('counters', $counters);
            $smarty->assign('showFooter', false);
        }
    }



    function paymentsimportsreport()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));
    }

    function paymentsimportsreportdata()
    {
        global $smarty;
        $this->report->populateWithPost();
        $imports = $this->report->getPaymentsImportsReportByDate();

        if (count($imports) === 0) {
            $smarty->assign('isEmptyMessage', 'Dla podanych filtrów nie ma żadnych danych do wyświetlenia.');
        } else {
            $columnNames = array_keys($imports[0]);

            $columnSummaries = array_map(fn($columnName) => array_sum(array_map(fn($val) => is_numeric($val) ? $val : 0, array_column($imports, $columnName))), $columnNames);

            $smarty->assign('columnNames', $columnNames);
            $smarty->assign('columnSummaries', $columnSummaries);
            $smarty->assign('data', $imports);
            $smarty->assign('showFooter', false);
        }
    }

    function paymentsreport()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));
    }

    function paymentsreportdata()
    {
        global $smarty;
        $this->report->populateWithPost();
        $data = $this->report->getPaymentsReport();

        if (count($data) === 0) {
            $smarty->assign('isEmptyMessage', 'Dla podanych filtrów nie ma żadnych danych do wyświetlenia.');
        } else {
            $columnNames = array_keys($data[0]);

            $columnSummaries = array_map(fn($columnName) => array_sum(array_map(fn($val) => is_numeric($val) ? $val : 0, array_column($data, $columnName))), $columnNames);

            $smarty->assign('columnNames', $columnNames);
            $smarty->assign('columnSummaries', $columnSummaries);
            $smarty->assign('data', $data);
            $smarty->assign('showFooter', true);
        }
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
                    // scans
                    $collectiveAgreement[SCAN_SUM] = 0;
                }
                mergeArrays($collectiveAgreement, $report, $this->REPORT_FIELD_NAMES);
                $collectiveAgreement['lista_umow'][$key] = $report;
                $collectiveAgreement['strony_black_sum'] += sumOfArrayRanges($report, 'strony_black_koniec', 'strony_black_start');
                $collectiveAgreement['strony_kolor_sum'] += sumOfArrayRanges($report, 'strony_kolor_koniec', 'strony_kolor_start');
                // scans
                $collectiveAgreement[SCAN_SUM] += sumOfArrayRanges($report, SCAN_END, SCAN_START);
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
                // scans
                $result[$report['rowidumowa']][SCAN_SUM] += ($report[SCAN_SUM]);

//                $result[$report['rowidumowa']]['serials'][] = $report['serial'];
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
                    // scans
                    $reports[$agr_id][SCAN_END][$indexSerial] = $replacement[SCAN_END];

                    $reports[$agr_id]['data_wiadomosci_black_koniec'][$indexSerial] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_kolor_koniec'][$indexSerial] = $replacement['date'];
                    // scans
                    $reports[$agr_id][SCAN_DATE_END][$indexSerial] = $replacement['date'];
                }

                if ($indexNewSerial !== false) {
                    $reports[$agr_id]['strony_black_start'][$indexNewSerial] = $replacement['ilosc_start'];
                    $reports[$agr_id]['strony_kolor_start'][$indexNewSerial] = $replacement['ilosckolor_start'];
                    // scans
                    $reports[$agr_id][SCAN_START][$indexNewSerial] = $replacement[SCAN_START];

                    $reports[$agr_id]['data_wiadomosci_black_start'][$indexNewSerial] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_kolor_start'][$indexNewSerial] = $replacement['date'];
                    // scans
                    $reports[$agr_id][SCAN_DATE_START][$indexNewSerial] = $replacement['date'];
                } else {
                    $reports[$agr_id]['strony_black_start'][] = $replacement['ilosc_start'];
                    $reports[$agr_id]['strony_black_koniec'][] = 0;
                    $reports[$agr_id]['strony_kolor_start'][] = $replacement['ilosckolor_start'];
                    $reports[$agr_id]['strony_kolor_koniec'][] = 0;
                    // scans
                    $reports[$agr_id][SCAN_START][] = $replacement[SCAN_START];
                    $reports[$agr_id][SCAN_END][] = 0;

                    $reports[$agr_id]['data_wiadomosci_black_start'][] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_black_koniec'][] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_kolor_start'][] = $replacement['date'];
                    $reports[$agr_id]['data_wiadomosci_kolor_koniec'][] = $replacement['date'];
                    // scans
                    $reports[$agr_id][SCAN_DATE_START][] = $replacement['date'];
                    $reports[$agr_id][SCAN_DATE_END][] = $replacement['date'];

                    $reports[$agr_id]['serials'][] = $replacement['new_serial'];
                }

                if ($indexSerial !== false && $indexNewSerial !== false) {
                    $reports[$agr_id]['strony_black_sum'] =
                        $reports[$agr_id]['strony_black_koniec'][$indexSerial] - $reports[$agr_id]['strony_black_start'][$indexSerial] +
                        $reports[$agr_id]['strony_black_koniec'][$indexNewSerial] - $reports[$agr_id]['strony_black_start'][$indexNewSerial];
                    $reports[$agr_id]['strony_kolor_sum'] =
                        $reports[$agr_id]['strony_kolor_koniec'][$indexSerial] - $reports[$agr_id]['strony_kolor_start'][$indexSerial] +
                        $reports[$agr_id]['strony_kolor_koniec'][$indexNewSerial] - $reports[$agr_id]['strony_kolor_start'][$indexNewSerial];
                    $reports[$agr_id][SCAN_SUM] =
                        $reports[$agr_id][SCAN_END][$indexSerial] - $reports[$agr_id][SCAN_START][$indexSerial] +
                        $reports[$agr_id][SCAN_END][$indexNewSerial] - $reports[$agr_id][SCAN_START][$indexNewSerial];
                }
            }
        }

        return $reports;
    }

    function applyAgreementPrinters($reports)
    {

        $agreementPrintersStart = $this->getAgreementPrintersMap($this->report->getAgreementPrintersStart());
        $agreementPrintersEnd = $this->getAgreementPrintersMap($this->report->getAgreementPrintersEnd());

        $result = array();

        foreach ($reports as $report) {
            $agreementPrintersKey = $report['serial'] . '-' . $report['rowidumowa'];
            $start = $agreementPrintersStart[$agreementPrintersKey] ?? null;
            $end = $agreementPrintersEnd[$agreementPrintersKey] ?? null;
            if ($start !== null && $report['rowidumowa'] == $start['rowid_agreement']) {
                $report['strony_black_start'] = $start['ilosc_start'];
                $report['strony_kolor_start'] = $start['ilosckolor_start'];
                // scans
                $report[SCAN_START] = $start[SCAN_START];

                $report['data_wiadomosci_black_start'] = $start['date_start'];
                $report['data_wiadomosci_kolor_start'] = $start['date_start'];
                // scans
                $report[SCAN_DATE_START] = $start['date_start'];
            }
            if ($end !== null && $report['rowidumowa'] == $end['rowid_agreement']) {
                $report['strony_black_koniec'] = $end['ilosc_koniec'];
                $report['strony_kolor_koniec'] = $end['ilosckolor_koniec'];

                $report['data_wiadomosci_black_koniec'] = $end['date_koniec'];
                $report['data_wiadomosci_kolor_koniec'] = $end['date_koniec'];

                $dateEnd = new DateTime($report['data_wiadomosci_black_koniec']);
                $daysInMoth = cal_days_in_month(CAL_GREGORIAN, date_format($dateEnd, 'm'), date_format($dateEnd, 'Y'));
                $amountOfDays = intval($dateEnd->format('d'));

                // scans
                $report[SCAN_END] = $start[SCAN_END];
                $report[SCAN_DATE_END] = $start[SCAN_DATE_END];

                // calculate part of the month which is paid (if not entire month)
                $partOfTheMonth = ($amountOfDays / $daysInMoth);
                $report['stronwabonamencie'] *= $partOfTheMonth;
                $report['iloscstron_kolor'] *= $partOfTheMonth;
                $report['abonament'] *= $partOfTheMonth;
                $report[SCAN_AMOUNT_FOR_FREE] *= $partOfTheMonth;
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
                // scans
                $result[$report['serial']][SCAN_END] = array();
                $result[$report['serial']][SCAN_START] = array($report[SCAN_START]);

                $result[$report['serial']]['data_wiadomosci_black_koniec'] = array();
                $result[$report['serial']]['data_wiadomosci_black_start'] = array($report['data_wiadomosci_black_start']);
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'] = array();
                $result[$report['serial']]['data_wiadomosci_kolor_start'] = array($report['data_wiadomosci_kolor_start']);
                // scans
                $result[$report['serial']][SCAN_DATE_END] = array();
                $result[$report['serial']][SCAN_DATE_START] = array($report[SCAN_DATE_START]);

                $result[$report['serial']]['serials'] = array($report['serial']);
                foreach ($srvs as $srv) {
                    $result[$report['serial']]['strony_black_koniec'][] = $srv['ilosc_koniec'];
                    $result[$report['serial']]['strony_black_start'][] = $srv['ilosc_start'];
                    $result[$report['serial']]['strony_kolor_koniec'][] = $srv['ilosckolor_koniec'];
                    $result[$report['serial']]['strony_kolor_start'][] = $srv['ilosckolor_start'];
                    // scans
                    $result[$report['serial']][SCAN_END][] = $srv[SCAN_END];
                    $result[$report['serial']][SCAN_START][] = $srv[SCAN_START];

                    $result[$report['serial']]['data_wiadomosci_black_koniec'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_black_start'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_kolor_koniec'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_kolor_start'][] = $srv['date'];
                    // scans
                    $result[$report['serial']][SCAN_DATE_END][] = $srv['date'];
                    $result[$report['serial']][SCAN_DATE_START][] = $srv['date'];

                    $result[$report['serial']]['serials'][] = $report['serial'];
                }
                $result[$report['serial']]['strony_black_koniec'][] = $report['strony_black_koniec'];
                $result[$report['serial']]['strony_kolor_koniec'][] = $report['strony_kolor_koniec'];
                // scans
                $result[$report['serial']][SCAN_END][] = $report[SCAN_END];

                $result[$report['serial']]['data_wiadomosci_black_koniec'][] = $report['data_wiadomosci_black_koniec'];
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'][] = $report['data_wiadomosci_kolor_koniec'];
                // scans
                $result[$report['serial']][SCAN_DATE_END][] = $report[SCAN_DATE_END];

                $result[$report['serial']]['strony_black_sum'] = 0;
                $result[$report['serial']]['strony_kolor_sum'] = 0;
                // scans
                $result[$report['serial']][SCAN_SUM] = 0;
                for ($i = 0; $i < count($result[$report['serial']]['strony_black_koniec']); $i++) {
                    $result[$report['serial']]['strony_black_sum'] += $result[$report['serial']]['strony_black_koniec'][$i] - $result[$report['serial']]['strony_black_start'][$i];
                    $result[$report['serial']]['strony_kolor_sum'] += $result[$report['serial']]['strony_kolor_koniec'][$i] - $result[$report['serial']]['strony_kolor_start'][$i];
                    // scans
                    $result[$report['serial']][SCAN_SUM] += $result[$report['serial']][SCAN_END][$i] - $result[$report['serial']][SCAN_START][$i];
                }

            } else {
                $result[$report['serial']] = $report;
                $result[$report['serial']]['strony_black_koniec'] = array($report['strony_black_koniec']);
                $result[$report['serial']]['strony_black_start'] = array($report['strony_black_start']);
                $result[$report['serial']]['strony_kolor_koniec'] = array($report['strony_kolor_koniec']);
                $result[$report['serial']]['strony_kolor_start'] = array($report['strony_kolor_start']);
                // scans
                $result[$report['serial']][SCAN_END] = array($report[SCAN_END]);
                $result[$report['serial']][SCAN_START] = array($report[SCAN_START]);

                $result[$report['serial']]['data_wiadomosci_black_koniec'] = array($report['data_wiadomosci_black_koniec']);
                $result[$report['serial']]['data_wiadomosci_black_start'] = array($report['data_wiadomosci_black_start']);
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'] = array($report['data_wiadomosci_kolor_koniec']);
                $result[$report['serial']]['data_wiadomosci_kolor_start'] = array($report['data_wiadomosci_kolor_start']);
                // scans
                $result[$report['serial']][SCAN_DATE_END] = array($report[SCAN_DATE_END]);
                $result[$report['serial']][SCAN_DATE_START] = array($report[SCAN_DATE_START]);

                $result[$report['serial']]['strony_black_sum'] = $report['strony_black_koniec'] - $report['strony_black_start'];
                $result[$report['serial']]['strony_kolor_sum'] = $report['strony_kolor_koniec'] - $report['strony_kolor_start'];
                // scans
                $result[$report['serial']][SCAN_SUM] = $report[SCAN_END] - $report[SCAN_START];

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

        $isPrinter = $agreement['typ_umowy'] === 'wynajem drukarki';
        $isScanner = $agreement['typ_umowy'] === 'wynajem skanera';

        if ($isPrinter) {
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
        } else if ($isScanner) {
            for ($idx = 0; $idx < count($agreement['skany_koniec']); $idx++) {
                if ($agreement['skany_koniec'][$idx] == 0 && $agreement['skany_start'][$idx] == 0) {
                    return 1;
                }
                if (($agreement['skany_koniec'][$idx] - $agreement['skany_start'][$idx]) < 0) {
                    return 1;
                }
            }
        }

        if ($isPrinter) {
            // check for date for black and color,
            if ($this->isDateIncorrect($agreement['data_wiadomosci_black_koniec'][0], $this->report->getDateTo())) {
                return 2;
            }
            // check for date for color,
            if ($this->isDateIncorrect($agreement['data_wiadomosci_kolor_koniec'][0], $this->report->getDateTo())) {
                return 2;
            }
        } else if ($isScanner) {
            // check for date for black and color,
            if ($this->isDateIncorrect($agreement['data_wiadomosci_scans_koniec'][0], $this->report->getDateTo())) {
                return 2;
            }
        }

        if ($isPrinter) {
            if ($agreement['strony_black_sum'] == 0) {
                return 1;
            }
        } else if ($isScanner) {
            if ($agreement['skany_sum'] == 0) {
                return 1;
            }
        }

        return 0;
    }

    function showdaneklient()
    {

        $this->report->populateWithPost();
        $dataReportsMiesieczne = $this->report->getReportsMiesieczne();
        $dataReportsRoczne = $this->report->getReportsRoczne();

        $dataReportsMiesieczne = $this->applyAgreementPrinters($dataReportsMiesieczne);

        $dataPrinterService = $this->getPrinterServiceMap($this->report->getPrinterService());

        $dataPrinterReplacement = $this->getPrinterReplacements($this->report->getPrinterService());

        $dataReportsMiesieczne = $this->applyService($dataReportsMiesieczne, $dataPrinterService);

        $dataReportsMiesieczne = $this->groupByAgreement($dataReportsMiesieczne);

        $dataReportsMiesieczne = $this->applyReplacement($dataReportsMiesieczne, $dataPrinterReplacement);

        $dataReportsMiesieczne = $this->groupByCollectiveAgreements($dataReportsMiesieczne);

// TODO [TR]: remove unused code in case of positive verification

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
            if ($item['typ_umowy'] === 'wynajem drukarki' || $item['typ_umowy'] === 'wynajem skanera') {

                $hasError = $this->hasError($item);

                if ($hasError > 0) {
                    $client['blad'] = 1;
                    $agreement['blad'] = 1;
                }
                if ($hasError === 2) {
                    if (
                        (   // black
                            $item['strony_black_koniec'][0] >= $item['strony_black_start'][0] ||
                            // color
                            $item['strony_kolor_koniec'][0] >= $item['strony_kolor_start'][0] ||
                            // scans
                            $item[SCAN_END][0] >= $item[SCAN_START][0]) &&
                        (   // black
                            $item['data_wiadomosci_black_koniec'][0] !== $item['data_wiadomosci_black_start'][0] ||
                            $item['next_month_datawiadomosci'] !== "0000-00-00")) {

                        $blackEnd = $item['strony_black_koniec'][0];
                        $colorEnd = $item['strony_kolor_koniec'][0];
                        // scans
                        $scanEnd = $item[SCAN_END][0];
                        $fixedDate = $item['data_wiadomosci_black_koniec'][0];

                        if ($item['next_month_datawiadomosci'] !== "0000-00-00") {
                            if ($item['next_month_black'] >= $blackEnd && $item['next_month_kolor'] >= $colorEnd) {
                                $blackEnd = $item['next_month_black'];
                                $colorEnd = $item['next_month_kolor'];
                                $fixedDate = $item['next_month_datawiadomosci'];
                            }

                            if ($item[SCANS_NEXT_MONTH] >= $scanEnd) {
                                $scanEnd = $item[SCANS_NEXT_MONTH];
                            }
                        }

                        $agreement['fix'] = array(
                            "dateTo" => $this->report->getDateTo(),
                            "fixedDateTo" => $fixedDate,
                            "black" => $blackEnd,
                            "color" => $colorEnd,
                            "scans" => $scanEnd,
                            "serial" => $item['currentserial']);
                    }
                }
            }

            // check for error for collective agreements
            if ($item['typ_umowy'] === 'umowa zbiorcza' && isset($item['lista_umow'])) {
                foreach ($item['lista_umow'] as $agrKey => &$agr) {
                    $hasError = $this->hasError($agr);
                    if ($hasError > 0) {
                        $client['blad'] = 1;
                        $agreement['blad'] = 1;
                        $agreement['lista_umow'][$agrKey]['blad'] = 1;
                    }
                    if ($hasError === 2) {
                        if (
                            (   // black
                                $agr['strony_black_koniec'][0] >= $agr['strony_black_start'][0] ||
                                // color
                                $agr['strony_kolor_koniec'][0] >= $agr['strony_kolor_start'][0] ||
                                // scans
                                $agr[SCAN_END][0] >= $agr[SCAN_START][0]) &&
                            (   // black
                                $agr['data_wiadomosci_black_koniec'][0] !== $agr['data_wiadomosci_black_start'][0] ||
                                $agr['next_month_datawiadomosci'] !== "0000-00-00")) {


                            $blackEnd = $agr['strony_black_koniec'][0];
                            $colorEnd = $agr['strony_kolor_koniec'][0];
                            // scans
                            $scanEnd = $agr[SCAN_END][0];
                            $fixedDate = $agr['data_wiadomosci_black_koniec'][0];

                            if ($agr['next_month_datawiadomosci'] !== "0000-00-00") {
                                if ($agr['next_month_black'] >= $blackEnd && $agr['next_month_kolor'] >= $colorEnd) {
                                    $blackEnd = $agr['next_month_black'];
                                    $colorEnd = $agr['next_month_kolor'];
                                    $fixedDate = $agr['next_month_datawiadomosci'];
                                }

                                if ($agr[SCANS_NEXT_MONTH] >= $scanEnd) {
                                    $scanEnd = $agr[SCANS_NEXT_MONTH];
                                }
                            }

                            $agr['fix'] = array(
                                "dateTo" => $this->report->getDateTo(),
                                "fixedDateTo" => $fixedDate,
                                "black" => $blackEnd,
                                "color" => $colorEnd,
                                "scans" => $scanEnd,
                                "serial" => $agr['currentserial']);
                        }
                    }
                }
                // do not override by mistake
                unset($agr);
            }

            $dataReports['suma'] = isset($dataReports['suma']) ? $dataReports['suma'] : 0;
            $client['wartosc'] = isset($client['wartosc']) ? $client['wartosc'] : 0;
            $client['wartoscblack'] = isset($client['wartoscblack']) ? $client['wartoscblack'] : 0;
            $client['wartosckolor'] = isset($client['wartosckolor']) ? $client['wartosckolor'] : 0;
            $client[SCANS_VALUE] = $client[SCANS_VALUE] ?? 0;
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
                $item[SCAN_AMOUNT_FOR_FREE] = $item[SCAN_AMOUNT_FOR_FREE] - ($dayOfDateRange * ($item[SCAN_AMOUNT_FOR_FREE] / $daysAmount));
            }

            $blackPagesNb = (int)$item['strony_black_sum'];
            $colorPagesNb = (int)$item['strony_kolor_sum'];
            $scansNb = (int)$item[SCAN_SUM];
            $allPagesNb = $blackPagesNb + $colorPagesNb;

            $blackPrice = (float)$item['cenazastrone'];
            $colorPrice = (float)$item['cenazastrone_kolor'];
            $scanPrice = (float)$item[SCAN_PRICE];

            // TODO: discount is no longer used
            $discount = $item['rabatdowydrukow'] / 100;

            $allPagesValue = ($blackPagesNb * $blackPrice + $colorPagesNb * $colorPrice);

            $client['kwotadowykorzystania'] += $hasAmountInSubscription ? max($allPagesValue - $amountInSubscription, 0) : 0;

            $contract = array(
                "black" => !$hasAmountInSubscription ? $item['stronwabonamencie'] : 0,
                "color" => !$hasAmountInSubscription ? $item['iloscstron_kolor'] : 0,
                SCAN_AMOUNT_FOR_FREE => $item[SCAN_AMOUNT_FOR_FREE]
            );

            // TODO: it seems we no longer use `jakczarne`, probably we can remove
            if (isset($item['jakczarne']) && !empty($item['jakczarne']) && $item['jakczarne'] == 1) {
                // black
                $blackExceeded = round(max($allPagesNb - $contract["black"], 0));
                $blackValue = $blackExceeded * $blackPrice;
                $blackValue = $blackValue - ($blackValue * $discount);
                $client['wartoscblack'] += !$hasAmountInSubscription ? $blackValue : 0;
                // color
                $colorValue = 0;
                $colorExceeded = 0;
                $client['wartosckolor'] = !$hasAmountInSubscription ? $colorValue : 0;
                // scans
                $scansValue = 0;
                $scansExceeded = 0;
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
                // scans
                $scansExceeded = round(max($scansNb - $contract[SCAN_AMOUNT_FOR_FREE], 0));
                $scansValue = $scansExceeded * $scanPrice;
                $client[SCANS_VALUE] += $scansValue;
            }

            $totalValue = $hasAmountInSubscription ?
                $subscription + max(($allPagesValue + $scansValue) - $amountInSubscription, 0) :
                $subscription + $blackValue + $colorValue + $scansValue + $setupFee;
            $client['wartosc'] += $totalValue;

            $dataReports['suma'] += $totalValue;

            $agreement['stronwabonamencie'] = $contract["black"];
            $agreement['stronwabonamencie_kolor'] = $contract["color"];
            $agreement[SCAN_AMOUNT_FOR_FREE] = $contract[SCAN_AMOUNT_FOR_FREE];

            $agreement['wartoscblack'] = $blackValue;
            $agreement['wartosckolor'] = $colorValue;
            $agreement[SCANS_VALUE] = $scansValue;

            $agreement['stronblackpowyzej'] = $blackExceeded;
            $agreement['stronkolorpowyzej'] = $colorExceeded;
            $agreement[SCANS_AMOUNT_PAID] = $scansExceeded;

            $agreement['cenazastrone'] = $blackPrice;
            $agreement['cenazastrone_kolor'] = $colorPrice;
            $agreement[SCAN_PRICE] = $scanPrice;
            $agreement['wartoscabonament'] = $subscription;
            $agreement['kwotadowykorzystania'] = $amountInSubscription;

            $agreement['oplatainstalacyjna'] = $setupFee;


            $agreement['wartosc'] = $totalValue;

            copyArrays($agreement, $item, $this->AGREEMENT_FIELDS);
        }

//        foreach ($dataReportsMiesieczne as $key => $item) {
//            $dayOfDateRange = 0;
//            $setupFee = 0;
//            $daysAmount = date("t", strtotime($item['dataod']));
//            $clientId = $item['rowidclient'];
//
//            if (date("m-Y", strtotime($item['dataod'])) == date("m-Y", strtotime($item['dacik']))) {
//                $dayOfDateRange = date("j", strtotime($item['dataod'])) - 1;
//                $setupFee = $item['cenainstalacji'];
//            }
//
//            if (!isset($dataReports[$clientId])) {
//                $dataReports[$clientId] = [];
//            }
//
//            $client = &$dataReports[$clientId];
//            $agreement = &$client['umowy'][$item['rowidumowa']];
//
//            $client['drukumowy'] = ($client['drukumowy'] ?? 0) + 1;
//            copyArrays($client, $item, $this->CLIENT_FIELD_NAMES);
//
//            if (isset($item['lista_umow'])) {
//                $agreement['lista_umow'] = $item['lista_umow'];
//            }
//
//            $this->processPrinterErrors($client, $agreement, $item);
//            $this->processCollectiveAgreements($client, $agreement, $item);
//
//            $this->initializeClientValues($client);
//            $this->calculateSubscription($client, $item, $dayOfDateRange, $daysAmount);
//            $this->calculatePageValues($client, $agreement, $item, $dayOfDateRange, $daysAmount, $setupFee);
//
//            copyArrays($agreement, $item, $this->AGREEMENT_FIELDS);
//        }

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
            $agreement['kwotawabonamencie'] = (float)$item['kwotawabonamencie'];
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

    private function processPrinterErrors(&$client, &$agreement, $item) {
        if (!in_array($item['typ_umowy'], ['wynajem drukarki', 'wynajem skanera'])) return;
        $hasError = $this->hasError($item);
        if ($hasError > 0) {
            $client['blad'] = $agreement['blad'] = 1;
        }
        if ($hasError === 2 && $this->validateFixConditions($item)) {
            $agreement['fix'] = $this->generateFixData($item);
        }
    }

    private function processCollectiveAgreements(&$client, &$agreement, $item) {
        if ($item['typ_umowy'] !== 'umowa zbiorcza' || !isset($item['lista_umow'])) return;

        foreach ($item['lista_umow'] as $agrKey => &$agr) {
            $hasError = $this->hasError($agr);
            if ($hasError > 0) {
                $client['blad'] = $agreement['blad'] = $agreement['lista_umow'][$agrKey]['blad'] = 1;
            }
            if ($hasError === 2 && $this->validateFixConditions($agr)) {
                $agr['fix'] = $this->generateFixData($agr);
            }
        }
        unset($agr);
    }

    private function initializeClientValues(&$client) {
        $client['wartosc'] = $client['wartosc'] ?? 0;
        $client['wartoscblack'] = $client['wartoscblack'] ?? 0;
        $client['wartosckolor'] = $client['wartosckolor'] ?? 0;
        $client[SCANS_VALUE] = $client[SCANS_VALUE] ?? 0;
        $client['wartoscabonament'] = $client['wartoscabonament'] ?? 0;
        $client['kwotadowykorzystania'] = $client['kwotadowykorzystania'] ?? 0;
    }

    private function calculateSubscription(&$client, $item, $dayOfDateRange, $daysAmount) {
        $item['rabatdoabonamentu'] = empty($item['rabatdoabonamentu']) ? 0 : $item['rabatdoabonamentu'];
        $subscription = (float)$item['abonament'];
        if ($dayOfDateRange != 0) {
            $subscription -= ($dayOfDateRange * ($subscription / $daysAmount));
        }
        $subscription -= ($subscription * ($item['rabatdoabonamentu'] / 100));
        $client['wartoscabonament'] += $subscription;
    }

    private function calculatePageValues(&$client, &$agreement, $item, $dayOfDateRange, $daysAmount, $setupFee) {
        $blackPagesNb = (int)$item['strony_black_sum'];
        $colorPagesNb = (int)$item['strony_kolor_sum'];
        $scansNb = (int)$item[SCAN_SUM];
        $allPagesNb = $blackPagesNb + $colorPagesNb;

        $blackPrice = (float)$item['cenazastrone'];
        $colorPrice = (float)$item['cenazastrone_kolor'];
        $scanPrice = (float)$item[SCAN_PRICE];

        $blackExceeded = max($blackPagesNb - $item['stronwabonamencie'], 0);
        $colorExceeded = max($colorPagesNb - $item['iloscstron_kolor'], 0);
        $scansExceeded = max($scansNb - $item[SCAN_AMOUNT_FOR_FREE], 0);

        $blackValue = $blackExceeded * $blackPrice;
        $colorValue = $colorExceeded * $colorPrice;
        $scansValue = $scansExceeded * $scanPrice;

        $client['wartoscblack'] += $blackValue;
        $client['wartosckolor'] += $colorValue;
        $client[SCANS_VALUE] += $scansValue;

        $totalValue = $client['wartoscabonament'] + $blackValue + $colorValue + $scansValue + $setupFee;
        $client['wartosc'] += $totalValue;
        $agreement['wartosc'] = $totalValue;
    }

    private function validateFixConditions($item) {
        return (
            ($item['strony_black_koniec'][0] >= $item['strony_black_start'][0] ||
                $item['strony_kolor_koniec'][0] >= $item['strony_kolor_start'][0] ||
                $item[SCAN_END][0] >= $item[SCAN_START][0]) &&
            ($item['data_wiadomosci_black_koniec'][0] !== $item['data_wiadomosci_black_start'][0] ||
                $item['next_month_datawiadomosci'] !== "0000-00-00")
        );
    }

    private function generateFixData($item) {
        $blackEnd = $item['strony_black_koniec'][0];
        $colorEnd = $item['strony_kolor_koniec'][0];
        $scanEnd = $item[SCAN_END][0];
        $fixedDate = $item['data_wiadomosci_black_koniec'][0];

        if ($item['next_month_datawiadomosci'] !== "0000-00-00") {
            if ($item['next_month_black'] >= $blackEnd && $item['next_month_kolor'] >= $colorEnd) {
                $blackEnd = $item['next_month_black'];
                $colorEnd = $item['next_month_kolor'];
                $fixedDate = $item['next_month_datawiadomosci'];
            }
            if ($item[SCANS_NEXT_MONTH] >= $scanEnd) {
                $scanEnd = $item[SCANS_NEXT_MONTH];
            }
        }

        return [
            "dateTo" => $this->report->getDateTo(),
            "fixedDateTo" => $fixedDate,
            "black" => $blackEnd,
            "color" => $colorEnd,
            "scans" => $scanEnd,
            "serial" => $item['currentserial']
        ];
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