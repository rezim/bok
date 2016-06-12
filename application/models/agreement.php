<?php
class agreement extends Model 
{
     protected $rowid=0,$nrumowy='',$dataod='',$datado='',$stronwabonamencie='',$cenazastrone='',$serial='',
             $rowidclient='',$opis='',$rozliczenie='',$abonament='',
            $iloscstron_kolor='',
            $cenazastrone_kolor='',
            $cenainstalacji='',
            $rabatdoabonamentu='',
            $rabatdowydrukow='',
            $prowizjapartnerska='',
            $sla='',
            $wartoscurzadzenia='',$jakczarne='';
     protected $filternrumowy='',$filterserial='',$filternazwaklienta='',$clientrowid='',$pokazzakonczone=0;
     
      function delete($rowid)
    {
          return $this->update
                             (
                                 "update agreements set activity=0
                                     where `rowid`=?"
                                ,'i', 
                                 array
                                 (
                                  
                                     $rowid
                                 )
                             );         
    }
     function getAgreements()
     {
        
         if($this->pokazzakonczone==0)
            $where = " where a.activity=1";
         else
            $where = " where (a.activity=0)";
        
        if($this->filternrumowy!='')
        {
            $where.=" and ( a.nrumowy like '%{$this->filternrumowy}%')   ";
        }
        if($this->filterserial!='')
        {
            $where.=" and ( a.serial like '%{$this->filterserial}%' or b.model like '%{$this->filterserial}%')";
        }
        if($this->filternazwaklienta!='')
        {
            $where.=" and ( c.nazwakrotka like '%{$this->filternazwaklienta}%' || c.nazwapelna like '%{$this->filternazwaklienta}%')";
        }
        if($this->clientrowid!='')
        {
            $where.=" and ( a.rowidclient = {$this->clientrowid})   ";
        }
       
        $query = "  
                select 
                a.nrumowy as 'nrumowy',
                a.dataod as 'dataod',
                a.datado as 'datado',
                a.stronwabonamencie as 'stronwabonamencie',
                a.cenazastrone as 'cenazastrone',
                a.rowid as 'rowid',
                a.`serial` as 'serial',
                b.model as 'model',
                c.nazwakrotka as 'nazwakrotka',
                a.rowidclient as 'rowidclient',
                a.rozliczenie as `rozliczenie`,
                a.abonament as 'abonament',
                a.sla as 'sla',
                a.activity,
                (select d.rowid from logs d where d.serial=a.serial and d.przeczytany=0 limit 1) as `blad`,a.abonament
                from
                (agreements a left outer join printers b on a.`serial`=b.`serial`)
                left outer join clients c on a.rowidclient=c.rowid  and c.activity=1  
                {$where}
                order by a.datado desc
        ";
        return $this->query($query,null,false); 
     }   
     function saveupdate()
    {
         
        if($this->rowid!=0) 
        {
             return $this->update
                             (
                                 "update agreements
                                     set 
                                    `nrumowy`=?,
                                    `dataod`=?,
                                    `datado`=?,
                                    `stronwabonamencie`=?,
                                    `cenazastrone`=?,
                                    `abonament`=?,
                                    `dateinsert`=?,
                                    `serial`=?,
                                    `rowidclient`=?,
                                    `opis`=?,
                                    `rozliczenie`=?,
                                    `iloscstron_color`=?,
                                    `cenazastrone_kolor`=?,
                                    `cenainstalacji`=?,
                                    `rabatdoabonamentu`=?,
                                    `rabatdowydrukow`=?,
                                    `prowizjapartnerska`=?,
                                    `sla`=?,
                                    `wartoscurzadzenia`=?,
                                    `jakczarne`=?
                                     where `rowid`=?"
                                ,'sssiddssissidddddidii',
                                 array
                                 (
                                    $this->nrumowy==''?"NULL":$this->nrumowy,
                                    ($this->dataod=='' || $this->dataod=='0000-00-00')?"NULL":$this->dataod,
                                    ($this->datado=='' || $this->datado=='0000-00-00')? "NULL":$this->datado,
                                    $this->stronwabonamencie==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronwabonamencie)), 
                                    $this->cenazastrone==''?"NULL":str_replace(' ','',str_replace(',','.', $this->cenazastrone)),  
                                     $this->abonament==''?"NULL":str_replace(' ','',str_replace(',','.', $this->abonament)),  
                                    date('Y-m-d H:i:s'),
                                    $this->serial==''?"NULL":$this->serial, 
                                    $this->rowidclient==''?"NULL":$this->rowidclient,  
                                     $this->opis==''?"NULL":$this->opis, 
                                     $this->rozliczenie==''?"NULL":$this->rozliczenie, 
                                     $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)), 
                                     $this->cenazastrone_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->cenazastrone_kolor)),  
                                     $this->cenainstalacji==''?"NULL":str_replace(' ','',str_replace(',','.', $this->cenainstalacji)),  
                                     $this->rabatdoabonamentu==''?"NULL":str_replace(' ','',str_replace(',','.', $this->rabatdoabonamentu)),  
                                     $this->rabatdowydrukow==''?"NULL":str_replace(' ','',str_replace(',','.', $this->rabatdowydrukow)),  
                                     $this->prowizjapartnerska==''?"NULL":str_replace(' ','',str_replace(',','.', $this->prowizjapartnerska)),  
                                     $this->sla==''?"NULL":str_replace(' ','',str_replace(',','.', $this->sla)), 
                                     $this->wartoscurzadzenia==''?"NULL":str_replace(' ','',str_replace(',','.', $this->wartoscurzadzenia)),  
                                     $this->jakczarne==''?"NULL":$this->jakczarne,
                                    $this->rowid
                                 )
                             );     
            
        }
        else
        {
        
              $columnList = "`nrumowy`,
                            `dataod`,
                            `datado`,
                            `stronwabonamencie`,
                            `cenazastrone`,
                            `abonament`,
                            `serial`,
                            `rowidclient`,`dateinsert`,`opis`,`rozliczenie`,
                             `iloscstron_color`,
                                    `cenazastrone_kolor`,
                                    `cenainstalacji`,
                                    `rabatdoabonamentu`,
                                    `rabatdowydrukow`,
                                    `prowizjapartnerska`,
                                    `sla`,
                                    `wartoscurzadzenia`,
                                    `jakczarne`
                            ";
              return $this->insert($columnList,'sssiddsisssidddddidi',
                      array(
                                    $this->nrumowy==''?"NULL":$this->nrumowy,
                                    ($this->dataod=='' || $this->dataod=='0000-00-00')?"NULL":$this->dataod,
                                    ($this->datado=='' || $this->datado=='0000-00-00')? "NULL":$this->datado,
                                    $this->stronwabonamencie==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronwabonamencie)), 
                                    $this->cenazastrone==''?"NULL":str_replace(' ','',str_replace(',','.', $this->cenazastrone)), 
                                    $this->abonament==''?"NULL":str_replace(' ','',str_replace(',','.', $this->abonament)),  
                                    $this->serial==''?"NULL":$this->serial, 
                                    $this->rowidclient==''?"NULL":$this->rowidclient,
                                    date('Y-m-d H:i:s'),$this->opis==''?"NULL":$this->opis,$this->rozliczenie==''?"NULL":$this->rozliczenie,
                                    $this->iloscstron_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->iloscstron_kolor)), 
                                     $this->cenazastrone_kolor==''?"NULL":str_replace(' ','',str_replace(',','.', $this->cenazastrone_kolor)),  
                                     $this->cenainstalacji==''?"NULL":str_replace(' ','',str_replace(',','.', $this->cenainstalacji)),  
                                     $this->rabatdoabonamentu==''?"NULL":str_replace(' ','',str_replace(',','.', $this->rabatdoabonamentu)),  
                                     $this->rabatdowydrukow==''?"NULL":str_replace(' ','',str_replace(',','.', $this->rabatdowydrukow)),  
                                     $this->prowizjapartnerska==''?"NULL":str_replace(' ','',str_replace(',','.', $this->prowizjapartnerska)),  
                                     $this->sla==''?"NULL":str_replace(' ','',str_replace(',','.', $this->sla)), 
                                     $this->wartoscurzadzenia==''?"NULL":str_replace(' ','',str_replace(',','.', $this->wartoscurzadzenia)),
                                    $this->jakczarne==''?"NULL":$this->jakczarne,
                      ));
              
            
            
        }
      
    }
     function getUmowaByRowid($rowid)
    {
        $query = "select * from agreements where rowid={$rowid}";
        return $this->query($query,null,false); 
    }
     function getUmowaByClient($rowidClient)
    {
        $query = "select rowid from agreements where rowidclient={$rowidClient} and activity=1";
        return $this->query($query,null,false); 
    }
     function getUmowaByPrinter($serial)
    {
        $query = "select rowid from agreements where serial='{$serial}' and activity=1";
        return $this->query($query,null,false); 
    }
}