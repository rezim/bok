<?php
class alert extends Model
{
    protected $filterserial='',$filtermodel='',$filternumber='',$filternip='',$clientrowid,$filterklient='';
    protected $serial='', $model='', $product_number='', $nr_firmware='', $date_firmware='', $ip='', $stan_fuser='', $stan_adf='',
        $black_toner='', $date_insert='', $cyan_toner='', $magenta_toner='', $yellow_toner='', $blackdrum_toner='', $cyandrum_toner='',
        $magentadrum_toner='', $yellowdrum_toner='', $dateupdate='',$iloscstron='',$opis='',$lokalizacja='',$iloscstron_kolor='',$iloscstron_total='',$stanna='',
        // device localization
        $ulica='', $miasto='', $kodpocztowy='', $telefon='', $mail='', $nazwa='', $osobakontaktowa='', $type_color;


    function delete($serial)
    {
        return $this->update
        (
            "delete from printers
                                     
                                     where `serial`=?"
            ,'s',
            array
            (
                $serial
            )
        );
    }
    function getPrinters()
    {
        $where = " where p.serial!='' AND p.black_toner is not null AND p.black_toner <> 0 AND p.black_toner <= 10";

        $query = "
            select p.serial, p.black_toner, p.type_color, p.model, p.miasto, a.nrumowy, a.sla, a.rowid as 'rowidumowa',c.rowid as 'rowidclient',c.nazwakrotka as 'nazwaklient',
            (select d.rowid from logs d where d.serial=p.serial and d.przeczytany=0 limit 1) as `blad`, 
            IFNULL((select d.timestamp from logs d where d.serial=p.serial order by d.timestamp desc limit 1), p.dateupdate) as `data`
            from 
            (printers p left outer join agreements a on p.serial=a.serial and a.activity=1)
                left outer join clients c on a.rowidclient=c.rowid and c.activity=1
            {$where}
            ";

        $query .= " UNION ALL ";

        $query .= "
            select p.serial, '10' as black_toner, p.type_color, p.model, p.miasto, a.nrumowy, a.sla, a.rowid as 'rowidumowa',c.rowid as 'rowidclient',c.nazwakrotka as 'nazwaklient',
                l.rowid as `blad`, l.timestamp as `data`
            FROM `logs` l inner join agreements a on l.serial = a.serial  
            inner join clients c on a.rowidclient=c.rowid and c.activity=1
            inner join printers p on p.serial=l.serial
            where (eventcode like '%toner%B%' or   eventcode like '%toner%Cyan%' or   eventcode like '%toner%Magenta%')
            and l.dateinsert BETWEEN DATE_SUB(NOW(), INTERVAL 10 DAY) AND NOW()
            group by l.serial, eventcode, c.nazwakrotka, p.model, p.miasto, p.type_color
        ";

        $query .= " order by black_toner asc ";

        return $this->query($query,null,false);

    }
    function getLogi($serial)
    {

        $this->update
        (
            "update logs set przeczytany=1 where `serial`=?"
            ,'s',
            array
            (
                $serial
            )
        );


        $query = "
            select * from logs
            where serial='{$serial}' order by `timestamp` desc
            ";
        return $this->query($query,null,false);
    }

    function getService($rowid_agreement) {
        $query = "select * from printer_service 
            where rowid_agreement='{$rowid_agreement}'
            order by date desc";
        return $this->query($query,null,false);
    }


    function removeService($rowid) {
        return $this->update("DELETE FROM `printer_service` WHERE rowid = ?", 'i', array($rowid));
    }

    function getPrintersUmowa()
    {


        $query = "select a.* from printers a
            where not exists(select b.rowid from agreements b where b.serial=a.serial and b.activity=1)
            order by a.date_insert desc";
        return $this->query($query,null,false);

    }
    function getPrintersUmowaBezSerialu($serial)
    {


        $query = "select a.* from printers a
            where not exists(select b.rowid from agreements b where b.serial=a.serial and b.activity=1)
            or a.serial='{$serial}'
            order by a.date_insert desc";
        return $this->query($query,null,false);

    }
    function getPrinterBySerial($serial)
    {
        $query = "select * from printers where serial='{$serial}'";
        return $this->query($query,null,false);
    }
    function saveupdate()
    {
        $print = $this->selectWhere(null,true,'s',array($this->serial),' serial=?','*');
        if(count($print)!=0)
        {
            $wynik = $this->update
            (
                "update printers
                                     set 
                                    `model`=?,
                                    `product_number`=?,
                                    `nr_firmware`=?,
                                    `date_firmware`=?,
                                    `ip`=?,
                                    `stan_fuser`=?,
                                    `stan_adf`=?,
                                    `black_toner`=?,
                                    `dateupdate`=?,
                                    `iloscstron`=?,
                                    `iloscstron_kolor`=?,
                                    `iloscstron_total`=?,
                                    `opis`=?,
                                    `lokalizacja`=?,
                                    `ulica`=?,
                                    `miasto`=?,
                                    `kodpocztowy`=?,
                                    `telefon`=?,
                                    `mail`=?,
                                    `nazwa`=?,                                    
                                    `osobakontaktowa`=?,                                    
                                    `type_color`=?                             
                                     where `serial`=?"
                ,'sssssdddsdddsssssssssis',
                array
                (
                    $this->model==''?"NULL":$this->model,
                    $this->product_number==''?"NULL":$this->product_number,
                    $this->nr_firmware==''?"NULL":$this->nr_firmware,
                    ($this->date_firmware=='' || $this->date_firmware=='0000-00-00')?"NULL":$this->date_firmware,
                    $this->ip==''?"NULL":$this->ip,
                    $this->stan_fuser==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stan_fuser)),
                    $this->stan_adf==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stan_adf)),
                    $this->black_toner==''?"NULL":str_replace(' ','',str_replace(',','.', $this->black_toner)),
                    date('Y-m-d H:i:s'),
                    $this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)),
                    $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)),
                    $this->iloscstron_total==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_total)),
                    $this->opis==''?"NULL":$this->opis,
                    $this->lokalizacja==''?"NULL":$this->lokalizacja,
                    $this->ulica==''?"NULL":$this->ulica,
                    $this->miasto==''?"NULL":$this->miasto,
                    $this->kodpocztowy==''?"NULL":$this->kodpocztowy,
                    $this->telefon==''?"NULL":$this->telefon,
                    $this->mail==''?"NULL":$this->mail,
                    $this->nazwa==''?"NULL":$this->nazwa,
                    $this->osobakontaktowa==''?"NULL":$this->osobakontaktowa,
                    $this->type_color==''?"NULL":$this->type_color,
                    $this->serial
                )
            );
            // NOTE TR: do not insert to pages, it will broke some functionality
//             if($wynik['status']==1 && $this->iloscstron!='')
//             {
//
//                 $this->_table = 'pages';
//
//                            $columnList = "`serial`,
//                                       `ilosc`,`ilosckolor`,`ilosctotal`,
//                                       `dateinsert`,
//                                       `datawiadomosci`";
//                         return $this->insert($columnList,'sdddss',
//                                 array(
//                                        $this->serial,
//                                        $this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)),
//                                          $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)),
//                                     $this->iloscstron_total==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_total)),
//                                     date('Y-m-d H:i:s'),date('Y-m-d H:i:s')
//                                 ));
//
//             }
//            else
            return $wynik;


        }
        else
        {

            $columnList = "`serial`,
                            `model`,
                            `product_number`,
                            `nr_firmware`,
                            `date_firmware`,
                            `ip`,
                            `stan_fuser`,
                            `stan_adf`,
                            `black_toner`,
                            `date_insert`,
                            `iloscstron`,`iloscstron_kolor`,`iloscstron_total`,`opis`,`lokalizacja`,
                            `ulica`,
                            `miasto`,
                            `kodpocztowy`,
                            `telefon`,
                            `mail`,
                            `nazwa`,                                       
                            `osobakontaktowa`,
                            `type_color`";
            $wynik = $this->insert($columnList,'ssssssdddsdddsssssssssi',
                array(
                    $this->serial,
                    $this->model==''?"NULL":$this->model,
                    $this->product_number==''?"NULL":$this->product_number,
                    $this->nr_firmware==''?"NULL":$this->nr_firmware,
                    $this->date_firmware==''?"NULL":$this->date_firmware,
                    $this->ip==''?"NULL":$this->ip,
                    $this->stan_fuser==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stan_fuser)),
                    $this->stan_adf==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stan_adf)),
                    $this->black_toner==''?"NULL":str_replace(' ','',str_replace(',','.', $this->black_toner)),
                    date('Y-m-d H:i:s'),
                    $this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)),
                    $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)),
                    $this->iloscstron_total==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_total)),
                    $this->opis==''?"NULL":$this->opis,$this->lokalizacja==''?"NULL":$this->lokalizacja,
                    $this->ulica==''?"NULL":$this->ulica,
                    $this->miasto==''?"NULL":$this->miasto,
                    $this->kodpocztowy==''?"NULL":$this->kodpocztowy,
                    $this->telefon==''?"NULL":$this->telefon,
                    $this->mail==''?"NULL":$this->mail,
                    $this->nazwa==''?"NULL":$this->nazwa,
                    $this->osobakontaktowa==''?"NULL":$this->osobakontaktowa, $this->type_color
                ));

            if($wynik['status']==1 && $this->iloscstron!='')
            {

                $query = "select a.rowid, p.product_version from agreements a inner join printers p on a.serial=p.serial 
                       where a.activity=1 AND a.serial='" . $this->serial . "'";
                $agreement_rowid = null;

                if ($result = ($this->query($query, null,false))) {
                    if (count($result) > 0) {
                        $agreement_rowid = $result[0]['rowid'];
                    }
                }


                $this->_table = 'pages';
                $columnList = "`serial`,
                                       `ilosc`,`ilosckolor`,`ilosctotal`,
                                       `dateinsert`,
                                       `datawiadomosci`, `rowid_agreement`, `product_version`";
                return $this->insert($columnList,'sdddssii',
                    array(
                        $this->serial,
                        $this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)),
                        $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)),
                        $this->iloscstron_total==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_total)),
                        date('Y-m-d H:i:s'),date('Y-m-d H:i:s'), $agreement_rowid, 1
                    ));

            }
            else
                return $wynik;

        }

    }

    function replaceprinter($serial, $newSerial, $rowidAgreement, $counterEnd, $counterStart, $counterColorEnd, $counterColorStart, $replacementDate) {
        $this->_table = 'printer_service';
        $result = $this->insert("`serial`, `new_serial`, `rowid_agreement`, `ilosc_koniec`, `ilosc_start`, `ilosckolor_koniec`, `ilosckolor_start`, `date`",
            'ssiiiiis',
            array($serial, $newSerial, $rowidAgreement, $counterEnd, $counterStart, $counterColorEnd, $counterColorStart, $replacementDate)
        );
        // printer replacement, update pages
        if ($serial != $newSerial) {
            $this->update("UPDATE pages SET `rowid_agreement`=? WHERE `serial`=? AND `datawiadomosci` >= ?", 'iss', array($rowidAgreement, $newSerial, $replacementDate));
        }

        return $result;
    }

    function savestanna()
    {
        $query = "select a.rowid, p.product_version from agreements a inner join printers p on a.serial=p.serial 
                       where a.activity=1 AND a.serial='" . $this->serial . "'";
        $agreement_rowid = null;
        // default version number is 1
        $product_version = 1;
        if ($result = ($this->query($query, null,false))) {
            if (count($result) > 0) {
                $agreement_rowid = $result[0]['rowid'];
                $product_version = $result[0]['product_version'];
            }
        }

        $this->update("DELETE FROM `pages` WHERE datawiadomosci = ? AND serial = ? ", 'ss', array($this->stanna.' 12:00', $this->serial));

        $this->iloscstron_total =  (int)($this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)))+(int)($this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)));

        $this->_table = 'pages';

        $columnList = "`serial`,
                `ilosc`,`ilosckolor`,`ilosctotal`,
                `dateinsert`,
                `datawiadomosci`, `rowid_agreement`, `product_version`";
        return $this->insert($columnList,'sdddssii',
            array(
                $this->serial,
                $this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)),
                $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)),
                $this->iloscstron_total==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_total)),
                date('Y-m-d H:i:s'),$this->stanna.' 12:00', $agreement_rowid, $product_version
            ));
    }
}