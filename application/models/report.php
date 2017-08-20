<?php
class report extends Model 
{
    protected $dataod='',$datado='',$filterklient='',$filterdrukarka='',$nazwakrotka='';


    function getReportsMiesieczneOld()
    {
        if($this->dataod=='' || $this->datado=='')
        {
            echo('Wybierz zakres dat');die();
        }
        $where = " where a.rowid!=0 and a.activity=1 and a.rozliczenie='miesieczne' and 
                  DATE_FORMAT(a.dataod, '%Y-%m') <= DATE_FORMAT('{$this->dataod}', '%Y-%m')
                ";
        if($this->filterklient!='')
        {
            $where.=" and (c.nazwakrotka like '%{$this->filterklient}%' or c.nazwapelna like '%$this->filterklient%')";
        }
        if($this->nazwakrotka!='')
        {
            $where.=" and (c.nazwakrotka ='{$this->nazwakrotka}')";
        }
        if($this->filterdrukarka!='')
        {
            $where.=" and (a.serial ='{$this->filterdrukarka}')";
        }

        $previousMonth = date('Y-m-d', strtotime($this->dataod . ' -1 month'));

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
               
                IFNULL((SELECT max(ilosc)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$previousMonth}'
                and DATE(datawiadomosci) <= '{$this->dataod}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosc is not null
                group by serial),                
                IFNULL((SELECT min(ilosc)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$this->dataod}'
                and DATE(datawiadomosci) <= '{$this->datado}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosc is not null
                group by serial),0)                
                ) as 'strony_black_start',                              
                
                IFNULL((SELECT max(datawiadomosci)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$previousMonth}'
                and DATE(datawiadomosci) <= '{$this->dataod}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosc is not null
                group by serial),                
                IFNULL((SELECT min(datawiadomosci)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$this->dataod}'
                and DATE(datawiadomosci) <= '{$this->datado}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosc is not null
                group by serial), '0000-00-00')                              
                ) as 'data_wiadomosci_black_start',
                                
                IFNULL((SELECT max(ilosc)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$this->dataod}'
                and DATE(datawiadomosci) <= '{$this->datado}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosc is not null
                group by serial),0) as 'strony_black_koniec',                
                
                IFNULL((SELECT max(datawiadomosci)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$this->dataod}'
                and DATE(datawiadomosci) <= '{$this->datado}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosc is not null
                group by serial),'0000-00-00') as 'data_wiadomosci_black_koniec',                
                
                IFNULL((SELECT max(ilosckolor)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$previousMonth}'
                and DATE(datawiadomosci) <= '{$this->dataod}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosckolor is not null
                group by serial),
                IFNULL((SELECT min(ilosckolor)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$this->dataod}'
                and DATE(datawiadomosci) <= '{$this->datado}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosckolor is not null
                group by serial),0)
                ) as 'strony_kolor_start',                
                                
                IFNULL((SELECT max(datawiadomosci)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$previousMonth}'
                and DATE(datawiadomosci) <= '{$this->dataod}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosckolor is not null
                group by serial),
                IFNULL((SELECT min(datawiadomosci)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$this->dataod}'
                and DATE(datawiadomosci) <= '{$this->datado}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosckolor is not null
                group by serial),'0000-00-00')                                
                ) as 'data_wiadomosci_kolor_start',                
                
                IFNULL((SELECT max(ilosckolor)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$this->dataod}'
                and DATE(datawiadomosci) <= '{$this->datado}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosckolor is not null
                group by serial),0) as 'strony_kolor_koniec',                                             
                
                IFNULL((SELECT max(datawiadomosci)
                FROM `pages` as d
                where d.serial = a.serial and
                DATE(datawiadomosci) >= '{$this->dataod}'
                and DATE(datawiadomosci) <= '{$this->datado}'
                and DATE(datawiadomosci) >= DATE(a.dataod)
                and ilosckolor is not null
                group by serial),'0000-00-00') as 'data_wiadomosci_kolor_koniec'                
                
            from
            (agreements a left outer join printers b on a.serial=b.serial)
                left outer join clients c on a.rowidclient=c.rowid and c.activity=1
            {$where}
                order by c.nazwakrotka
            ";

        return $this->query($query,null,false);

    }
    
    function getReportsMiesieczne()
    {
        if($this->dataod=='' || $this->datado=='')
        {
            echo('Wybierz zakres dat');die();
        }
        $where = " where a.rowid!=0 and a.activity=1 and a.rozliczenie='miesieczne' and c.activity = 1 and
                  DATE_FORMAT(a.dataod, '%Y-%m') <= DATE_FORMAT('{$this->dataod}', '%Y-%m')
                ";
            if($this->filterklient!='')
            {
                $where.=" and (c.nazwakrotka like '%{$this->filterklient}%' or c.nazwapelna like '%$this->filterklient%')";
            }
            if($this->nazwakrotka!='')
            {
                $where.=" and (c.nazwakrotka ='{$this->nazwakrotka}')";
            }
            if($this->filterdrukarka!='')
            {
                $where.=" and (a.serial ='{$this->filterdrukarka}')";
            }



        $dateFrom = $this->dataod;
        // this is because we do not want to use DATE function in mysql, adding one day allow us to simple
        // use < operator for any date with time
        $dateTo = date('Y-m-d', strtotime($this->datado . ' +1 day'));

        $dateFromPreviousMonth = date('Y-m-d', strtotime($dateFrom . ' -1 month'));

        $dateToPreviousMonth = date('Y-m-d', strtotime($dateTo . ' -1 month'));

        $query = "
                select 
                b.serial as serial, 
                '{$dateFrom}' as 'dacik',
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
                COALESCE (pp2.ilosc, pp3.ilosc, 0) as strony_black_start, 
                COALESCE(pp2.datawiadomosci, pp3.datawiadomosci, '0000-00-00') as data_wiadomosci_black_start, 
                IFNULL(pp1.ilosc, 0) as strony_black_koniec, 
                IFNULL(pp1.datawiadomosci, '0000-00-00') as data_wiadomosci_black_koniec,
			    COALESCE(pp2.ilosckolor, pp3.ilosckolor, 0) as strony_kolor_start, 
			    COALESCE(pp2.datawiadomosci, pp3.datawiadomosci, '0000-00-00') as data_wiadomosci_kolor_start, 
			    IFNULL(pp1.ilosckolor,0) as strony_kolor_koniec, 
			    IFNULL(pp1.datawiadomosci, '0000-00-00') as data_wiadomosci_kolor_koniec 

                from (agreements a left outer join printers b on a.serial=b.serial) left outer join clients c on a.rowidclient=c.rowid and c.activity=1 
                
                left outer join 
                
                (select p1.serial, p1.datawiadomosci, p1.ilosc, p1.ilosckolor, p1.rowid_agreement, p1.product_version from pages as p1 
                inner join 
                (select serial, max(datawiadomosci) as datawiadomosci_koniec from pages where datawiadomosci >= '{$dateFrom}' and datawiadomosci < '{$dateTo}'
                group by serial, rowid_agreement, product_version, rowid_agreement, product_version) as p2 on p1.serial = p2.serial and p1.datawiadomosci = p2.datawiadomosci_koniec
                group by p1.serial, p1.datawiadomosci, p1.ilosc, p1.ilosckolor, p1.rowid_agreement, p1.product_version) as pp1
                
                on pp1.serial = b.serial
                
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
            {$where}
                order by c.nazwakrotka
            ";

        return $this->query($query,null,false); 
        
    }
    function getReportsRoczne()
    { 
        if($this->dataod=='' || $this->datado=='')
        {
            echo('Wybierz zakres dat');die();
        }
        $where = " where a.rowid!=0 and a.activity=1 and a.rozliczenie='roczne' and 
                  ((DATE_FORMAT(a.dataod, '%Y') <= DATE_FORMAT('{$this->dataod}', '%Y') and (DATE_FORMAT(a.dataod, '%m'))=DATE_FORMAT('{$this->dataod}', '%m')) or 
                  (DATE_FORMAT(a.dataod, '%Y') = DATE_FORMAT('{$this->dataod}', '%Y') and (DATE_FORMAT(a.dataod, '%m'))=DATE_FORMAT('{$this->dataod}', '%m')))
                ";
            if($this->filterklient!='')
            {
                $where.=" and (c.nazwakrotka like '%{$this->filterklient}%' or c.nazwapelna like '%$this->filterklient%')";
            }
            if($this->nazwakrotka!='')
            {
                $where.=" and (c.nazwakrotka ='{$this->nazwakrotka}')";
            }
            if($this->filterdrukarka!='')
            {
                $where.=" and (a.serial ='{$this->filterdrukarka}')";
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
            {$where}
                order by c.nazwakrotka
            ";

        return $this->query($query,null,false); 
    }   
}