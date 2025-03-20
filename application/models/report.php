<?php

const EMPTY_SCANS_ENTRY = array("next_month_skany" => 0, "next_month_data_wiadomosci_skany" => '0000-00-00',
    "skany_start" => 0, "skany_koniec" => 0, "data_wiadomosci_scans_start" => '0000-00-00', "data_wiadomosci_scans_koniec" => '0000-00-00');

class report extends Model
{
    protected $dataod = '', $datado = '', $filterklient = '', $filterdrukarka = '', $nazwakrotka = '';

    protected ?string $startDate = null, $endDate = null, $month = null, $clientName = null, $clientNip = null, $serial = null, $notProcessed = null;

    function getPrinterService()
    {
        // TODO: update scans column names
        $query = "select *, iloscskans_start as 'skany_start', iloscskans_koniec as 'skany_koniec' from `printer_service` 
                  where DATE(date) >= '{$this->dataod}' and DATE(date) <= '{$this->datado}' 
                  order by date asc";

        return $this->query($query, null, false);
    }

    function getAgreementPrintersStart()
    {
        // TODO: update scans column names
        $query = "select *, iloscskans_start as 'skany_start', iloscskans_koniec as 'skany_koniec' from `agreement_printers` 
                  where DATE(date_start) >= '{$this->dataod}' and DATE(date_start) <= '{$this->datado}' 
                  order by date_start asc";

        return $this->query($query, null, false);
    }

    function getAgreementPrintersEnd()
    {
        $query = "select * from `agreement_printers` 
                  where DATE(date_koniec) >= '{$this->dataod}' and DATE(date_koniec) <= '{$this->datado}' 
                  order by date_koniec asc";

        return $this->query($query, null, false);
    }

    function getScansMonthly($dateFrom, $dateTo)
    {
        if ($dateFrom == '' || $dateTo == '') {
            echo('Wybierz zakres dat');
            die();
        }
        $query = "
                select `s`.`serial` AS `skany_serial`, min(`s`.`ilosctotal`) AS `skany_start`, 
                       max(`s`.`ilosctotal`) AS `skany_koniec`, min(`s`.`datawiadomosci`) AS `data_wiadomosci_scans_start`,max(`s`.`datawiadomosci`) AS `data_wiadomosci_scans_koniec`,
                       `p`.`model` AS `skany_model_urzadzenia` 
                FROM ((`scans` `s` join `agreements` `a` on(`s`.`serial` = `a`.`serial`)) 
                    join `printers` `p` on(`s`.`serial` = `p`.`serial`)) 
                WHERE `a`.`activity` = 1 and `s`.`datawiadomosci` >= '{$dateFrom}' and `s`.`datawiadomosci` < '{$dateTo}' group by `s`.`serial` order by max(`s`.`ilosctotal`) - min(`s`.`ilosctotal`) desc;";
        return $this->query($query, null, false);
    }

    function getReportsMiesieczne()
    {
        if ($this->dataod == '' || $this->datado == '') {
            echo('Wybierz zakres dat');
            die();
        }
        $where = " where a.rowid!=0 and a.activity=1 and a.rozliczenie='miesieczne' and c.activity = 1 and
                  DATE_FORMAT(a.dataod, '%Y-%m') <= DATE_FORMAT('{$this->dataod}', '%Y-%m')
                ";
        if ($this->filterklient != '') {
            $where .= " and (c.nazwakrotka like '%{$this->filterklient}%' or c.nazwapelna like '%$this->filterklient%')";
        }
        if ($this->nazwakrotka != '') {
            $where .= " and (c.nazwakrotka ='{$this->nazwakrotka}')";
        }
        if ($this->filterdrukarka != '') {
            $where .= " and (a.serial ='{$this->filterdrukarka}')";
        }


        $dateFrom = $this->dataod;
        // this is because we do not want to use DATE function in mysql, adding one day allow us to simple
        // use < operator for any date with time
        $dateTo = date('Y-m-d', strtotime($this->datado . ' +1 day'));

        $dateFromPreviousMonth = date('Y-m-d', strtotime($dateFrom . ' -1 month'));

        $dateToPreviousMonth = date('Y-m-d', strtotime($dateTo . ' -1 month'));

        $dateFromNextMonth = date('Y-m-d', strtotime($dateFrom . ' +1 month'));

        $dateToNextMonth = date('Y-m-d', strtotime($dateTo . ' +1 month'));

        $query = "
                select 
                IFNULL(b.serial, bb.serial) as serial,
                a.serial as currentserial, 
                '{$dateFrom}' as 'dacik',
                a.rowid as 'rowidumowa', 
                a.rowidumowazbiorcza as 'rowidumowazbiorcza',
                a.nrumowy as 'nrumowy', 
                a.dataod as 'dataod', 
                a.datado as 'datado', 
                IFNULL(b.ulica, bb.ulica) as 'lokalizacja_ulica',
                IFNULL(b.miasto, bb.miasto) as 'lokalizacja_miasto',
                IFNULL(b.kodpocztowy, bb.kodpocztowy) as 'lokalizacja_kodpocztowy',
                IFNULL(b.telefon, bb.telefon) as 'lokalizacja_telefon',
                IFNULL(b.mail, bb.mail) as 'lokalizacja_mail', 
                IFNULL(b.nazwa, bb.nazwa) as 'lokalizacja_nazwa',
                IFNULL(b.osobakontaktowa, bb.osobakontaktowa) as 'lokalizacja_osobakontaktowa',
                IFNULL(a.stronwabonamencie,0) as 'stronwabonamencie',                 
                IFNULL(a.iloscstron_color,0) as 'iloscstron_kolor',
                IFNULL(a.iloscskans,0) as 'iloscskans',
                IFNULL(a.cenazastrone,0) as 'cenazastrone', 
                IFNULL(a.cenazastrone_kolor,0) as 'cenazastrone_kolor', 
                IFNULL(a.cenazascan,0) as 'cenazascan', 
                IFNULL(a.rabatdoabonamentu,0) as 'rabatdoabonamentu',
                IFNULL(a.rabatdowydrukow,0) as 'rabatdowydrukow',
                IFNULL(b.model, bb.model) as 'model', 
                a.rowidclient as 'rowidclient', 
                c.nazwakrotka as 'nazwakrotka', 
                c.nazwapelna as 'nazwapelna', 
                c.terminplatnosci as 'terminplatnosci',
                c.nip as 'nip',
                c.mailfaktury as 'mailfaktury',
                c.ulica as 'ulica',
                c.miasto as 'miasto',
                c.kodpocztowy as 'kodpocztowy',
                c.pokaznumerseryjny as 'pokaznumerseryjny',
                c.pokazstanlicznika as 'pokazstanlicznika',                
                c.fakturadlakazdejumowy as 'fakturadlakazdejumowy',                
                IFNULL(b.iloscstron, bb.iloscstron) as 'currentiloscstron', 
                a.abonament as 'abonament', 
                a.kwotawabonamencie as 'kwotawabonamencie', 
                a.rozliczenie as 'rozliczenie', 
                IFNULL(a.cenainstalacji,0) as 'cenainstalacji',
                a.activity,
                a.jakczarne,
                a_t.description as 'typ_umowy',
                a.odbiorca_id as 'odbiorca_id',
                COALESCE (pp2.ilosc, pp3.ilosc, 0) as strony_black_start, 
                COALESCE(pp2.datawiadomosci, pp3.datawiadomosci, '0000-00-00') as data_wiadomosci_black_start, 
                IFNULL(pp1.ilosc, 0) as strony_black_koniec, 
                IFNULL(pp1.datawiadomosci, '0000-00-00') as data_wiadomosci_black_koniec,
			    COALESCE(pp2.ilosckolor, pp3.ilosckolor, 0) as strony_kolor_start, 
			    COALESCE(pp2.datawiadomosci, pp3.datawiadomosci, '0000-00-00') as data_wiadomosci_kolor_start, 
			    IFNULL(pp1.ilosckolor,0) as strony_kolor_koniec, 
			    IFNULL(pp1.datawiadomosci, '0000-00-00') as data_wiadomosci_kolor_koniec,			    
                COALESCE(pp4.ilosc, 0) as next_month_black, 
                COALESCE(pp4.ilosckolor, 0) as next_month_kolor, 
                COALESCE(pp4.datawiadomosci, '0000-00-00') as next_month_datawiadomosci 

                from (agreements a left outer join clients c on a.rowidclient=c.rowid and c.activity=1)  
                
                left outer join 
                
                (select p1.serial, p1.datawiadomosci, p1.ilosc, p1.ilosckolor, p1.rowid_agreement, p1.product_version from pages as p1 
                inner join 
                (select serial, max(datawiadomosci) as datawiadomosci_koniec from pages where datawiadomosci >= '{$dateFrom}' and datawiadomosci < '{$dateTo}'
                group by serial, rowid_agreement, product_version, rowid_agreement, product_version) as p2 on p1.serial = p2.serial and p1.datawiadomosci = p2.datawiadomosci_koniec
                group by p1.serial, p1.datawiadomosci, p1.ilosc, p1.ilosckolor, p1.rowid_agreement, p1.product_version) as pp1
                
                on pp1.rowid_agreement = a.rowid
                
                left outer join 
                
                (select p3.serial, p3.datawiadomosci, p3.ilosc, p3.ilosckolor, p3.rowid_agreement, p3.product_version from pages as p3 
                inner join 
                (select serial, max(datawiadomosci) as datawiadomosci_start from pages where datawiadomosci >= '{$dateFromPreviousMonth}' and datawiadomosci < '{$dateToPreviousMonth}'
                group by serial, rowid_agreement, product_version) as p4 on p3.serial = p4.serial and p3.datawiadomosci = p4.datawiadomosci_start
                group by p3.serial, p3.datawiadomosci, p3.ilosc, p3.ilosckolor, p3.rowid_agreement, p3.product_version) as pp2 
                
                on pp1.serial = pp2.serial and pp1.rowid_agreement = pp2.rowid_agreement and pp1.product_version = pp2.product_version
                
                left outer join 
                
                (select p5.serial, p5.datawiadomosci, p5.ilosc, p5.ilosckolor, p5.rowid_agreement, p5.product_version from pages as p5 
                inner join 
                (select serial, min(datawiadomosci) as datawiadomosci_start from pages where datawiadomosci >= '{$dateFrom}' and datawiadomosci < '{$dateTo}'
                group by serial, rowid_agreement, product_version) as p6 on p5.serial = p6.serial and p5.datawiadomosci = p6.datawiadomosci_start
                group by p5.serial, p5.datawiadomosci, p5.ilosc, p5.ilosckolor, p5.rowid_agreement, p5.product_version) as pp3
                
                on pp1.serial = pp3.serial and pp1.rowid_agreement = pp3.rowid_agreement and pp1.product_version = pp3.product_version
                    
                left outer join
                    
                (select p7.serial, p7.datawiadomosci, p7.ilosc, p7.ilosckolor, p7.rowid_agreement, p7.product_version from pages as p7 
                inner join 
                (select serial, min(datawiadomosci) as datawiadomosci_start from pages where datawiadomosci > '{$dateFromNextMonth}' and datawiadomosci < '{$dateToNextMonth}'
                group by serial, rowid_agreement, product_version) as p8 on p7.serial = p8.serial and p7.datawiadomosci = p8.datawiadomosci_start
                group by p7.serial, p7.datawiadomosci, p7.ilosc, p7.ilosckolor, p7.rowid_agreement, p7.product_version) as pp4    
                                              
                on pp1.serial = pp4.serial and pp1.rowid_agreement = pp4.rowid_agreement and pp1.product_version = pp4.product_version
                    
                left outer join printers b on b.serial = pp1.serial
                left outer join printers bb on bb.serial = a.serial
                
                left outer join agreement_type a_t on a.rowid_type = a_t.rowid 
                
            {$where}
                order by c.nazwakrotka
            ";

        $monthlyReport = $this->query($query, null, false);

        $scans = $this->getScansMonthly($dateFrom, $dateTo);

        $scanKeys = array_map(function ($scan) {
            return $scan['skany_serial'];
        }, $scans);
        $scans = array_combine($scanKeys, $scans);

        $nextMonthScans = $this->getScansMonthly($dateFromNextMonth, $dateToNextMonth);
        $nextMonthScans = array_map(function ($scan) {
            return array("skany_serial" => $scan["skany_serial"], "next_month_skany" => $scan["skany_start"], "next_month_data_wiadomosci_skany" => $scan["data_wiadomosci_scans_start"]);
        }, $nextMonthScans);

        $scanKeys = array_map(function ($scan) {
            return $scan['skany_serial'];
        }, $nextMonthScans);
        $nextMonthScans = array_combine($scanKeys, $nextMonthScans);

        // empty scans entry to add to $report in case there are no scans for serial
        $emptyScansArray = EMPTY_SCANS_ENTRY;

        return array_map(function ($report) use (&$scans, &$nextMonthScans, &$emptyScansArray) {
            $serial = $report['currentserial'];
            if (isset($scans[$serial])) {
                $arrScans = $scans[$serial];

                if (isset($nextMonthScans[$serial])) {
                    $arrScans = array_merge($scans[$serial], $nextMonthScans[$serial]);
                }

                return array_merge($report, $arrScans);
            }
            // merge empty scans, this is to avoid many ifs in controller
            return array_merge($report, array_merge(array("skany_serial" => $serial, "skany_model_urzadzenia" => $report['model']), $emptyScansArray));
        }, $monthlyReport);
    }

    function getReportsRoczne()
    {
        if ($this->dataod == '' || $this->datado == '') {
            echo('Wybierz zakres dat');
            die();
        }
        $where = " where a.rowid!=0 and a.activity=1 and a.rozliczenie='roczne' and 
                  ((DATE_FORMAT(a.dataod, '%Y') <= DATE_FORMAT('{$this->dataod}', '%Y') and (DATE_FORMAT(a.dataod, '%m'))=DATE_FORMAT('{$this->dataod}', '%m')) or 
                  (DATE_FORMAT(a.dataod, '%Y') = DATE_FORMAT('{$this->dataod}', '%Y') and (DATE_FORMAT(a.dataod, '%m'))=DATE_FORMAT('{$this->dataod}', '%m')))
                ";
        if ($this->filterklient != '') {
            $where .= " and (c.nazwakrotka like '%{$this->filterklient}%' or c.nazwapelna like '%$this->filterklient%')";
        }
        if ($this->nazwakrotka != '') {
            $where .= " and (c.nazwakrotka ='{$this->nazwakrotka}')";
        }
        if ($this->filterdrukarka != '') {
            $where .= " and (a.serial ='{$this->filterdrukarka}')";
        }

        $query = "
                select 
     
                '{$this->dataod}' as 'dacik',
                a.rowid as 'rowidumowa', 
                a.nrumowy as 'nrumowy', 
                a.dataod as 'dataod', 
                a.datado as 'datado', 
                b.ulica as 'lokalizacja_ulica',
                b.miasto as 'lokalizacja_miasto',
                b.kodpocztowy as 'lokalizacja_kodpocztowy',
                b.telefon as 'lokalizacja_telefon',
                b.mail as 'lokalizacja_mail', 
                b.nazwa as 'lokalizacja_nazwa',
                b.osobakontaktowa as 'lokalizacja_osobakontaktowa',                
                IFNULL(a.stronwabonamencie,0) as 'stronwabonamencie', 
                IFNULL(a.cenazastrone,0) as 'cenazastrone', 
                IFNULL(a.iloscstron_color,0) as 'iloscstron_kolor',
                IFNULL(a.cenazastrone_kolor,0) as 'cenazastrone_kolor', 
                IFNULL(a.rabatdoabonamentu,0) as 'rabatdoabonamentu',
                IFNULL(a.rabatdowydrukow,0) as 'rabatdowydrukow',                
                IFNULL(a.cenazascan,0) as 'cenazaskan',
                IFNULL(a.iloscskans, 0) as 'skanowwabonamencie',                
                a.serial as 'serial', 
                b.model as 'model', 
                a.rowidclient as 'rowidclient', 
                c.nazwakrotka as 'nazwakrotka', 
                c.nazwapelna as 'nazwapelna', 
                c.terminplatnosci as 'terminplatnosci',
                c.nip as 'nip',
                c.mailfaktury as 'mailfaktury',
                c.ulica as 'ulica',
                c.miasto as 'miasto',
                c.kodpocztowy as 'kodpocztowy',
                c.pokaznumerseryjny as 'pokaznumerseryjny',
                c.pokazstanlicznika as 'pokazstanlicznika',                
                c.fakturadlakazdejumowy as 'fakturadlakazdejumowy',    
                b.iloscstron as 'currentiloscstron', 
                a.abonament as 'abonament', 
                a.rozliczenie as 'rozliczenie', 
                IFNULL(a.cenainstalacji,0) as 'cenainstalacji',
                a.activity,
                a.jakczarne,
                a_t.description as 'typ_umowy',
                IFNULL((SELECT d.ilosc FROM `pages` d where d.serial = a.serial and DATE(d.datawiadomosci) >= '{$this->dataod}' and DATE(d.datawiadomosci) <= '{$this->datado}' and DATE(d.datawiadomosci)>=DATE(a.dataod)  and d.ilosc is not null
                order by datawiadomosci asc limit 1),0) as 'strony_black_start', 
                IFNULL((SELECT d.datawiadomosci FROM `pages` d where d.serial = a.serial and DATE(d.datawiadomosci) >= '{$this->dataod}' and DATE(d.datawiadomosci) <= '{$this->datado}' and DATE(d.datawiadomosci)>=DATE(a.dataod) and d.ilosc is not null
                order by datawiadomosci asc limit 1),'0000-00-00') as 'data_wiadomosci_black_start', 
                IFNULL((SELECT d.ilosc FROM `pages` d where d.serial = a.serial and DATE(d.datawiadomosci) >= '{$this->dataod}' and DATE(d.datawiadomosci) <= '{$this->datado}' and DATE(d.datawiadomosci)>=DATE(a.dataod) and d.ilosc is not null
                order by datawiadomosci desc limit 1),0)  as 'strony_black_koniec', 
                IFNULL((SELECT d.datawiadomosci FROM `pages` d where d.serial = a.serial and DATE(d.datawiadomosci) >= '{$this->dataod}' and DATE(d.datawiadomosci) <= '{$this->datado}' and DATE(d.datawiadomosci)>=DATE(a.dataod) and d.ilosc is not null
                order by datawiadomosci desc limit 1),'0000-00-00') as 'data_wiadomosci_black_koniec' ,

                IFNULL((SELECT d.ilosckolor FROM `pages` d where d.serial = a.serial and DATE(d.datawiadomosci) >= '{$this->dataod}' and DATE(d.datawiadomosci) <= '{$this->datado}' and DATE(d.datawiadomosci)>=DATE(a.dataod)  and d.ilosckolor is not null
                order by datawiadomosci asc limit 1),0)  as 'strony_kolor_start', 
                IFNULL((SELECT d.datawiadomosci FROM `pages` d where d.serial = a.serial and DATE(d.datawiadomosci) >= '{$this->dataod}' and DATE(d.datawiadomosci) <= '{$this->datado}' and DATE(d.datawiadomosci)>=DATE(a.dataod) and d.ilosckolor is not null
                order by datawiadomosci asc limit 1),'0000-00-00') as 'data_wiadomosci_kolor_start', 
                IFNULL((SELECT d.ilosckolor FROM `pages` d where d.serial = a.serial and DATE(d.datawiadomosci) >= '{$this->dataod}' and DATE(d.datawiadomosci) <= '{$this->datado}' and DATE(d.datawiadomosci)>=DATE(a.dataod) and d.ilosckolor is not null
                order by datawiadomosci desc limit 1),0)  as 'strony_kolor_koniec', 
                IFNULL((SELECT d.datawiadomosci FROM `pages` d where d.serial = a.serial and DATE(d.datawiadomosci) >= '{$this->dataod}' and DATE(d.datawiadomosci) <= '{$this->datado}' and DATE(d.datawiadomosci)>=DATE(a.dataod) and d.ilosckolor is not null
                order by datawiadomosci desc limit 1),'0000-00-00') as 'data_wiadomosci_kolor_koniec' 
            from
            (agreements a left outer join printers b on a.serial=b.serial)
                left outer join clients c on a.rowidclient=c.rowid and c.activity=1
                left outer join agreement_type a_t on a.rowid_type = a_t.rowid 
            {$where}
                order by c.nazwakrotka
            ";

        return $this->query($query, null, false);
    }

    function getDateTo()
    {
        return $this->datado;
    }

    function getScansByDate($orderBy = 'ilosc', $desc = true): array
    {
        $where = "WHERE a.activity = 1 and
                        s.datawiadomosci >= '{$this->startDate}' and s.datawiadomosci <= '{$this->endDate}'";
        if ($this->clientName != '') {
            $where .= " and (c.nazwakrotka like '%{$this->clientName}%' or c.nazwapelna like '%$this->clientName%')";
        }
        if ($this->serial != '') {
            $where .= " and (s.serial ='{$this->serial}')";
        }

        $query = "SELECT c.nazwakrotka, a.nrumowy, s.serial, max(ilosctotal) - min(ilosctotal) as ilosc, min(s.datawiadomosci) as data_od, max(s.datawiadomosci) as `data_do` 
                  FROM (((scans s join agreements a on(s.serial = a.serial)) join clients c on(a.rowidclient = c.rowid)) join printers p on(s.serial = p.serial))
                  {$where}
                  GROUP BY s.serial
                  ORDER BY {$orderBy}";

        $query .= $desc ? " DESC" : " ASC";

        return $this->query($query, null, null);
    }

    function getCountersReport($days, $serial): array
    {
        $query = "WITH latest_pages AS (
                    SELECT serial, MAX(datawiadomosci) AS max_datawiadomosci
                    FROM pages
                    WHERE datawiadomosci >= LAST_DAY(NOW() - INTERVAL 2 MONTH) + INTERVAL 1 DAY
                    GROUP BY serial
                )
                SELECT p.serial, c.nazwakrotka AS 'client', pp.model, p.datawiadomosci, pp.mail AS 'e-mail', pp.last_notify_date as 'data maila'
                FROM latest_pages lp
                    JOIN pages p ON p.serial = lp.serial AND p.datawiadomosci = lp.max_datawiadomosci
                    JOIN printers pp ON pp.serial = p.serial
                    JOIN agreements a ON p.serial = a.serial
                    JOIN clients c ON c.rowid = a.rowidclient
                WHERE pp.deleted = 0
                    AND a.activity = 1
                    AND lp.max_datawiadomosci < NOW() - INTERVAL $days DAY";


        if ($serial !== '') {
            $query .= " AND p.serial = '{$serial}'";
        }
        $query .= " ORDER BY p.datawiadomosci DESC;";

        return $this->query($query, null, null);
    }


    function getPaymentsImportsReportByDate($orderBy = 'created', $desc = true): array {
        $where = "WHERE created >= '{$this->startDate}' and created <= '{$this->endDate}'";

        $query = "SELECT created as 'Data Importu', processed_count as 'Dodane do fakturowni', notprocessed_count as 'Nie dodane do fakturowni'
                  FROM payments_import
                  {$where}
                  ORDER BY {$orderBy}";

        $query .= $desc ? " DESC" : " ASC";

        return $this->query($query, null, null);
    }

    function getPaymentsReport($orderBy = 'p.date DESC, c.nazwakrotka ASC'): array {
        $where = "WHERE p.date >= '{$this->startDate}' and p.date <= '{$this->endDate}' and c.rowid = (SELECT MIN(rowid) FROM clients c2 WHERE c2.nip = c.nip) ";

        if ($this->clientName != '') {
            $where .= " and (c.nazwakrotka like '%{$this->clientName}%' or c.nazwapelna like '%$this->clientName%')";
        }
        if ($this->clientNip != '') {
            $where .= " and (c.nip like '%{$this->clientNip}%')";
        }
        if ($this->notProcessed === "true") {
            $where .= " and (pp.rowid_payments is null)";
        }

        $query = "SELECT p.details as 'TYTUŁEM', TRUNCATE(p.amount / 100, 2) as 'KWOTA', (select GROUP_CONCAT(pp.ext_invoice_nb separator ', ') from payments_processed pp where pp.rowid_payments = p.rowid) as 'FAKTURA', CONCAT(c.nazwakrotka, CONCAT(' NIP: ', c.nip)) as 'KUPUJĄCY', p.date as 'DATA PŁATNOŚCI' FROM `payments` p 
                    inner join clients c on substring(p.recipient_acount, -10) = c.nip
                  {$where}
                  ORDER BY {$orderBy}";

        return $this->query($query, null, null);
    }

    function updatePrinterWithLastEmailDate($serial) {
        $updateQuery = "UPDATE `printers`
                SET last_notify_date = CURDATE()
                WHERE serial = ?";

        $this->update($updateQuery, 's', array($serial));

//        $this->query($updateQuery);
    }
}
// SELECT c.nip, p.* FROM `payments` p inner join clients c on substring(p.recipient_acount, -10) = c.nip WHERE p.date >= '2023-10-01' and p.date <= '2023-11-30';