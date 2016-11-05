<?php
class printer extends Model 
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
        
        $where = " where a.serial!=''";
        
        if($this->filterserial!='')
        {
            $where.=" and ( a.serial like '%{$this->filterserial}%')   ";
        }
        if($this->filtermodel!='')
        {
            $where.=" and ( a.model like '%{$this->filtermodel}%')";
        }
        if($this->clientrowid!='')
        {
            $where.=" and ( c.rowid = {$this->clientrowid})";
        }
        if($this->filterklient!='')
        {
            $where.=" and ( c.nazwakrotka like '%{$this->filterklient}%' or  c.nazwapelna like '%{$this->filterklient}%')";
        }
        
        $query = "
            select a.*,b.nrumowy,b.sla,b.rowid as 'rowidumowa',c.rowid as 'rowidclient',c.nazwakrotka as 'nazwaklient',
            (select d.rowid from logs d where d.serial=a.serial and d.przeczytany=0 limit 1) as `blad`
            from 
            (printers a left outer join agreements b on a.serial=b.serial and b.activity=1)
                left outer join clients c on b.rowidclient=c.rowid and c.activity=1
            {$where} order by a.date_insert desc
            ";
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


                     $this->_table = 'pages';
                            $columnList = "`serial`,
                                       `ilosc`,`ilosckolor`,`ilosctotal`,
                                       `dateinsert`,
                                       `datawiadomosci`";
                         return $this->insert($columnList,'sdddss',
                                 array(
                                        $this->serial,
                                        $this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)),
                                     $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)),
                          $this->iloscstron_total==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_total)),
                                     date('Y-m-d H:i:s'),date('Y-m-d H:i:s')
                                 ));

             }
            else
                return $wynik;
            
        }
      
    }
     function savestanna()
    {
       
             
          
               $this->iloscstron_total =  (int)($this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)))+(int)($this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)));
                 $this->_table = 'pages';
                     
                            $columnList = "`serial`,
                                       `ilosc`,`ilosckolor`,`ilosctotal`,
                                       `dateinsert`,
                                       `datawiadomosci`";
                         return $this->insert($columnList,'sdddss',
                                 array(
                                        $this->serial,
                                        $this->iloscstron==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron)),
                                          $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)),
                                     $this->iloscstron_total==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_total)),
                                     date('Y-m-d H:i:s'),$this->stanna.' 12:00'
                                 ));
                 
           
            
    }
}