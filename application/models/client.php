<?php
class client extends Model 
{
    protected $rowid=0,$nazwakrotka='',$nazwapelna='',$ulica='',$miasto='',$kodpocztowy='',$nip='',$regon='',$telefon='',$mail='',$opis='',$mailfaktury='',$terminplatnosci='';
    protected $filternazwa='',$filternip='',$filtermiasto='',$filterserial='';
    
    function delete($rowid)
    {
          return $this->update
                             (
                                 "update clients set activity=0
                                     
                                     where `rowid`=?"
                                ,'i', 
                                 array
                                 (
                                  
                                     $rowid
                                 )
                             );         
    }
    function saveupdate()
    {
        if($this->rowid==0)
        {
              $columnList = "`nazwakrotka`,`nazwapelna`,`ulica`,`miasto`,`kodpocztowy`,`nip`,`regon`,`telefon`,`mail`,`opis`,`mailfaktury`,`terminplatnosci`";
              return $this->insert($columnList,'sssssssssssd',array($this->nazwakrotka,$this->nazwapelna,$this->ulica==''?"NULL":$this->ulica,
                  $this->miasto==''?"NULL":$this->miasto,
                  $this->kodpocztowy==''?"NULL":$this->kodpocztowy,
                  $this->nip==''?"NULL":$this->nip,
                  $this->regon==''?"NULL":$this->regon,
                  $this->telefon==''?"NULL":$this->telefon,
                  $this->mail==''?"NULL":$this->mail,
                  $this->opis==''?"NULL":$this->opis,
                  $this->mailfaktury==''?"NULL":$this->mailfaktury,
                  $this->terminplatnosci==''?"NULL":$this->terminplatnosci
                      ));
        }
        else
        {
                        return  $this->update
                             (
                                 "update clients
                                     set 
                                     nazwakrotka=?,
                                     nazwapelna=?,
                                     ulica=?,
                                     miasto=?,
                                     kodpocztowy=?,
                                     nip=?,
                                     regon=?,
                                     telefon=?,
                                     mail=?,
                                     opis=?,
                                     mailfaktury=?,
                                     terminplatnosci=?
                                     where `rowid`=?"
                                ,'sssssssssssdi',
                                 array
                                 (
                                     $this->nazwakrotka==''?"NULL":$this->nazwakrotka,
                                     $this->nazwapelna==''?"NULL":$this->nazwapelna,
                                     $this->ulica==''?"NULL":$this->ulica,
                                     $this->miasto==''?"NULL":$this->miasto,
                                     $this->kodpocztowy==''?"NULL":$this->kodpocztowy,
                                     $this->nip==''?"NULL":$this->nip,
                                     $this->regon==''?"NULL":$this->regon,
                                     $this->telefon==''?"NULL":$this->telefon,
                                     $this->mail==''?"NULL":$this->mail,
                                     $this->opis==''?"NULL":$this->opis,
                                     $this->mailfaktury==''?"NULL":$this->mailfaktury,
                                     $this->terminplatnosci==''?"NULL":$this->terminplatnosci,
                                     $this->rowid
                                 )
                             );           
        
        }
    }
    function getClientByRowid($rowid)
    {
        $query = "select * from clients where rowid={$rowid}";
        return $this->query($query,null,false); 
    }
    
    function getRowidByEmail($email)
    {
        $query = "select rowid from clients where mail='{$email}'";
        return $this->query($query,null,false); 
    }
    function getRowidByEmailCase($email)
    {
        $query = "select rowid from clients where mail='{$email}' and activity=1";
        return $this->query($query,null,false); 
    }
    function getNameByRowid($rowid)
    {
        $query = "select nazwapelna as 'nazwapelna' from clients where rowid='{$rowid}'";
        return $this->query($query,null,false); 
    }
    function getClients()
    {
        
        $where = " where a.rowid!=0 and a.activity=1";
        
        if($this->filternazwa!='')
        {
            $where.=" and ( a.nazwakrotka like '%{$this->filternazwa}%' or a.nazwapelna like '%$this->filternazwa%' )   ";
        }
        if($this->filtermiasto!='')
        {
            $where.=" and ( a.miasto like '%{$this->filtermiasto}%')";
        }
        if($this->filternip!='')
        {
            $where.=" and ( a.nip like '%{$this->filternip}%')";
        }
        if($this->filterserial!='')
        {
            $where.=" and ( b.serial like '%{$this->filterserial}%')";
        }
        
        
        $query = "
            select 
            a.*,b.serial,
            (select count(d.rowid) from agreements d where d.rowidclient=a.rowid and d.activity=1) as 'drukumowy',
            (select d.rowid from logs d where d.serial=b.serial and d.przeczytany=0 limit 1) as `blad`
            from 
            (clients a left outer join agreements b on a.rowid=b.rowidclient and b.activity=1)
            {$where} order by a.nazwakrotka";
        return $this->query($query,'rowid',false); 
    }
}