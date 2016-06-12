<?php
class toner extends Model 
{
    protected $filterserial='',$printerserial='',$czyhistoria=0;
    protected  $rowid=0,$serialdrukarka='',$serial='',$typ='',$number='',$description='',$datainstalacji='',$stronmax='',
            $stronpozostalo='',$ostatnieuzycie='',$licznikstart='',$licznikkoniec='';
    protected  $filterdrukarka='',$pokazzakonczone=0;
            
    
    function delete($rowid,$typ,$stronkoniec)
    {
          $typ2 = str_replace('black', '',$typ);
          return $this->update
                                        (
                                             "update toners{$typ2}
                                                 set 
                                                `zakonczony`=1,
                                                `licznikkoniec`=?,
                                                `dateupdate`=?,
                                                `sourceupdate`='portal'
                                                 where `rowid`=?"
                                            ,'isi',
                                             array
                                             (
                                                $stronkoniec,
                                                 date('Y-m-d H:i:s'),
                                                $rowid
                                             )
                                        );  
    }
    function saveupdate()
    {
    
            $typ2 = str_replace('black', '',$this->typ);
            $this->_table = 'toners'.$typ2;
              
            $query = "select a.serialdrukarka,a.serial,a.rowid
                    from toners{$typ2} a 
                    where a.serialdrukarka='{$this->serialdrukarka}' and a.zakonczony=0";
            $wynik = $this->query($query,null,false); 
                if(empty($wynik)) // dodanie nowego
                {
                        $columnList = "`serialdrukarka`,`serial`,`number`,`description`,`datainstalacji`,`stronmax`,`stronpozostalo`,
                       `ostatnieuzycie`,`dateinsert`,`source`,`licznikstart`";
                        return $this->insert($columnList,'sssssiisssi',array(
                            $this->serialdrukarka==''?"NULL":$this->serialdrukarka,
                            $this->serial==''?"NULL":$this->serial,
                            $this->number==''?"NULL":$this->number,
                            $this->description==''?"NULL":$this->description,
                            ($this->datainstalacji=='' || $this->datainstalacji=='0000-00-00')?"NULL":$this->datainstalacji,        
                            $this->stronmax==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronmax)),
                            $this->stronpozostalo==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronpozostalo)),
                            ($this->ostatnieuzycie=='' || $this->ostatnieuzycie=='0000-00-00')?"NULL":$this->ostatnieuzycie,        
                            date('Y-m-d H:i:s'),
                            'portal',
                            $this->licznikstart==''?"NULL":str_replace(' ','',str_replace(',','.', $this->licznikstart))
                                ));
                    
                }
                else 
                { // akutalizacja i usunięcie
                    
                    if($wynik[0]['serial']==$this->serial) // update
                    {
                     
                         return $this->update
                                        (
                                             "update toners{$typ2}
                                                 set 
                                                 `number`=?,
                                                 `description`=?,
                                                 datainstalacji=?,
                                                 stronmax=?,
                                                 stronpozostalo=?,
                                                 ostatnieuzycie=?,
                                                 dateupdate=?,
                                                 sourceupdate='portal',
                                                 licznikstart=?,
                                                 licznikkoniec=?
                                                 where `rowid`=?"
                                            ,'sssiissiii',
                                             array
                                             (
                                                $this->number==''?"NULL":$this->number,
                                                $this->description==''?"NULL":$this->description,
                                                ($this->datainstalacji=='' || $this->datainstalacji=='0000-00-00')?"NULL":$this->datainstalacji,        
                                                $this->stronmax==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronmax)),
                                                $this->stronpozostalo==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronpozostalo)), 
                                                ($this->ostatnieuzycie=='' || $this->ostatnieuzycie=='0000-00-00')?"NULL":$this->ostatnieuzycie,  
                                                date('Y-m-d H:i:s'),
                                                $this->licznikstart==''?"NULL":str_replace(' ','',str_replace(',','.', $this->licznikstart)),
                                                $this->licznikkoniec==''?"NULL":str_replace(' ','',str_replace(',','.', $this->licznikkoniec)),
                                                $wynik[0]['rowid']
                                             )
                                        );  
                        
                    }
                    else // kończymy poprzedni i zaczynamy nowy
                    {
                        
                            if($this->licznikstart=='')
                            {
                                return array('status'=>0,'info'=>'Musisz uzupełnić licznik start');
                                die();
                            }
                            else
                            {
                                
                                        $this->update
                                        (
                                             "update toners{$typ2}
                                                 set 
                                                `zakonczony`=1,
                                                `licznikkoniec`=?,
                                                `stronpozostalo`=?,
                                                `ostatnieuzycie`=?,
                                                `dateupdate`=?,
                                                `sourceupdate`='portal'
                                                 where `rowid`=?"
                                            ,'iissi',
                                             array
                                             (
                                                $this->licznikstart==''?"NULL":str_replace(' ','',str_replace(',','.', $this->licznikstart)),
                                                 $this->stronpozostalo==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronpozostalo)),
                                                 ($this->ostatnieuzycie=='' || $this->ostatnieuzycie=='0000-00-00')?"NULL":$this->ostatnieuzycie,  
                                                 date('Y-m-d H:i:s'),
                                                $wynik[0]['rowid']
                                             )
                                        );  
                                        $columnList = "`serialdrukarka`,`serial`,`number`,`description`,`datainstalacji`,`stronmax`,`stronpozostalo`,
                                        `ostatnieuzycie`,`dateinsert`,`source`,`licznikstart`";
                                         return $this->insert($columnList,'sssssiisssi',array(
                                             $this->serialdrukarka==''?"NULL":$this->serialdrukarka,
                                             $this->serial==''?"NULL":$this->serial,
                                             $this->number==''?"NULL":$this->number,
                                             $this->description==''?"NULL":$this->description,
                                             ($this->datainstalacji=='' || $this->datainstalacji=='0000-00-00')?"NULL":$this->datainstalacji,        
                                             $this->stronmax==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronmax)),
                                             $this->stronpozostalo==''?"NULL":str_replace(' ','',str_replace(',','.', $this->stronpozostalo)),
                                             ($this->ostatnieuzycie=='' || $this->ostatnieuzycie=='0000-00-00')?"NULL":$this->ostatnieuzycie,        
                                             date('Y-m-d H:i:s'),
                                             'portal',
                                             $this->licznikstart==''?"NULL":str_replace(' ','',str_replace(',','.', $this->licznikstart))
                                                 ));     
                            }
                        
                    }
                }
        
          
    }
     function getTonerByRowid($rowid,$typ)
     {
         $typ2 = str_replace('black', '',$typ);
        $query = "select a.* ,'{$typ}' as 'typ', b.model
            from toners{$typ2} a left outer join printers b on a.serialdrukarka =  b.serial
            where a.rowid={$rowid}";
        return $this->query($query,null,false); 
     }  
    
      function getToners()
      {
          
          
          if($this->czyhistoria==0)
          {
            $where = " where a.serial!='' and zakonczony=0";
            $order = " order by gg.serialdrukarka,gg.ostatnieuzycie desc";
          }
          else
          {
            $where = " where a.serial!=''";
            $order = " order by gg.ostatnieuzycie desc";
          }
            
          
          if($this->filterserial!='')
          {
              $where.=" and ( a.serial like '%{$this->filterserial}%')   ";
          }
          if($this->printerserial!='')
          {
              $where.=" and ( a.serialdrukarka like '%{$this->printerserial}%')   ";
          }
          if($this->filterdrukarka!='')
          {
              $where.=" and ( a.serialdrukarka like '%{$this->filterdrukarka}%')   ";
          }
          
          
          
          $query = "
              select gg.* from (
              select a.*,'black' as 'typ', ((a.stronpozostalo/a.stronmax)*100) as 'procentpozostalo'
              ,b.model,d.nazwakrotka
              from 
              ((toners a left outer join printers b on a.serialdrukarka=b.serial)
              left outer join agreements c on a.serialdrukarka = c.serial and c.activity=1)
                    left outer join clients d on c.rowidclient=d.rowid and d.activity=1
              {$where} 
              
              union all
              select a.*,'cyan' as 'typ', ((a.stronpozostalo/a.stronmax)*100) as 'procentpozostalo'
              ,b.model,d.nazwakrotka
              from 
              ((tonerscyan a left outer join printers b on a.serialdrukarka=b.serial)
              left outer join agreements c on a.serialdrukarka = c.serial and c.activity=1)
                    left outer join clients d on c.rowidclient=d.rowid and d.activity=1
              {$where} 
              union all
              select a.*,'magenta' as 'typ', ((a.stronpozostalo/a.stronmax)*100) as 'procentpozostalo'
              ,b.model,d.nazwakrotka
              from 
              ((tonersmagenta a left outer join printers b on a.serialdrukarka=b.serial)
              left outer join agreements c on a.serialdrukarka = c.serial and c.activity=1)
                    left outer join clients d on c.rowidclient=d.rowid and d.activity=1
              {$where} 
                union all
              select a.*,'yellow' as 'typ', ((a.stronpozostalo/a.stronmax)*100) as 'procentpozostalo'
              ,b.model,d.nazwakrotka
              from 
              ((tonersyellow a left outer join printers b on a.serialdrukarka=b.serial)
                left outer join agreements c on a.serialdrukarka = c.serial and c.activity=1)
                    left outer join clients d on c.rowidclient=d.rowid and d.activity=1
                    
              {$where} 

                ) gg
              {$order}
              ";
          return $this->query($query,null,false); 

      }   
}