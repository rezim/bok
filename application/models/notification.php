<?php
class notification extends Model 
{
      // <editor-fold defaultstate="collapsed" desc="Jakie pola mają być edytowane">
    public 
        $_filedsToEdit = array
                (
                'rowid_client'=>array(
                      'baza'=>'rowid_client',
                      'sql' => '`rowid_client` as `rowid_client`',
                      'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'link',
                    'link'=>'/clients/show/todiv',
                    'label'=>'Klient',
                    'class'=>'textBoxForm',
                    'style'=>'width:250px;min-width:250px;max-width:250px;',
                    'sqldanebaza'=>'clientdane',
                    'sqldane' => "(select nazwakrotka as 'dane' from clients where rowid=rowid_client) as `clientdane`",
                    'idzewnetrznespan'=>"idclientspan",
                    'readonly'=>'0',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    ),
                'serial'=>array(
                      'baza'=>'serial',
                      'sql' => '`serial` as `serial`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'link',
                    'link'=>'/printers/show/todiv',
                    'label'=>'Serial',
                    'class'=>'textBoxForm',
                    'style'=>'width:120px;min-width:120px;max-width:120px;',
                    'sqldanebaza'=>'serialdane',
                    'sqldane' => "(select printers.serial as 'dane' from printers  where printers.serial=notifications.serial) as `serialdane`",
                    'idzewnetrznespan'=>"idserialspan",
                    'readonly'=>'0',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    ),
                'rowid_agreements'=>array(
                         'baza'=>'rowid_agreements',
                         'sql' => '`rowid_agreements` as `rowid_agreements`',
                         'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'link',
                    'link'=>'/agreements/show2/todiv',
                    'label'=>'Nr umowy',
                    'class'=>'textBoxForm',
                    'style'=>'width:100px;min-width:100px;max-width:100px;',
                    'sqldanebaza'=>'umowadane',
                    'sqldane' => "(select nrumowy as 'dane' from agreements b where rowid=rowid_agreements) as `umowadane`",
                        'idzewnetrznespan'=>"idumowaspan",
                    'readonly'=>'0',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    ),
                'osobazglaszajaca'=>array(
                        'baza'=>'osobazglaszajaca',
                        'sql' => '`osobazglaszajaca` as `osobazglaszajaca`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Zgłaszający',
                    'class'=>'textBoxForm',
                    'style'=>'width:250px;min-width:250px;max-width:250px;',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    
                    ),
                'email'=>array(
                        'baza'=>'email',
                        'sql' => '`email` as `email`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Email',
                    'class'=>'textBoxForm',
                    'style'=>'width:250px;min-width:250px;max-width:250px;',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    ),
                'nr_telefonu'=>array(
                        'baza'=>'nr_telefonu',
                        'sql' => '`nr_telefonu` as `nr_telefonu`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Telefon',
                    'class'=>'textBoxForm',
                    'style'=>'width:250px;min-width:250px;max-width:250px;',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    ),
                'sla'=>array(
                        'baza'=>'sla',
                        'sql' => '`sla` as `sla`',
                      'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Sla',
                    'class'=>'textBoxForm',
                    'style'=>'width:60px;min-width:60px;max-width:60px;',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    'opis'=>"12 / 24 / 48 / 72 / 168 godziny"
                    ),
             'wykonuje'=>array(
                        'baza'=>'wykonuje',
                        'sql' => '`wykonuje` as `wykonuje`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'combobox',
                    'label'=>'Wykonuje',
                    'class'=>'comboboxForm',
                    'style'=>'width:250px;min-width:250px;max-width:250px;',
                    'arr' => 'daneWykonuje',
                    'divek'=>'divNotiWykonanie',
                       'value'=>'',
                    ),
                'status'=>array(
                        'baza'=>'status',
                        'sql' => '`status` as `status`',
                      'datatype'=>'i',
                    'activity'=>'1',
                   'type'=>'combobox',
                    'label'=>'Status',
                    'class'=>'comboboxForm',
                    'style'=>'width:250px;min-width:250px;max-width:250px;',
                    'arr' => 'daneStatus',
                    'divek'=>'divNotiWykonanie',
                    'wart_domyslna'=>'1',
                       'value'=>'',
                    ),
/*                'rowid_type'=>array(
                    'baza'=>'rowid_type',
                    'sql' => '`rowid_type` as `rowid_type`',
                    'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'combobox',
                    'label'=>'Typ zgłoszenia',
                    'class'=>'comboboxForm',
                    'style'=>'width:250px;min-width:250px;max-width:250px;',
                    'arr' => 'daneType',
                    'divek'=>'divNotiWykonanie',
                    'wart_domyslna'=>'1',
                    'value'=>'',
                ),
*/
                 'temat'=>array(
                        'baza'=>'temat',
                        'sql' => '`temat` as `temat`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Temat',
                    'class'=>'textBoxForm',
                    'style'=>'width:300px;min-width:300px;max-width:300px;',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    ),
                'date_email'=>array(
                        'baza'=>'date_email',
                        'sql' => '`date_email` as `date_email`',
                      'datatype'=>'s',
                        'datatypeshow'=>'datetime',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Data zgłoszenia',
                    'class'=>'textBoxForm',
                    'style'=>'width:140px;min-width:140px;max-width:140px;',
                    'js'=>"$('#date_email').datepicker($.datepicker.regional['pl'],{ dateFormat: 'yy-mm-dd' , changeMonth: true,changeYear: true,});",
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    'ishide'=>'1',
                    ),
                'data_planowana'=>array(
                        'baza'=>'data_planowana',
                        'sql' => '`data_planowana` as `data_planowana`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Termin wykonania',
                    'class'=>'textBoxForm',
                    'style'=>'width:140px;min-width:140px;max-width:140px;',
                    'js'=>"$('#data_planowana').datepicker($.datepicker.regional['pl'],{ dateFormat: 'yy-mm-dd' , changeMonth: true,changeYear: true,});",
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    'ishide'=>'0',
                    ),
                'tresc_wiadomosci'=>array(
                        'baza'=>'tresc_wiadomosci',
                        'sql' => '`tresc_wiadomosci` as `tresc_wiadomosci`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'textarea',
                    'label'=>'Treść zgłoszenia',
                    'class'=>'textareaForm',
                    'style'=>'width:300px;min-width:300px;max-width:300px;',
                    'divek'=>'divNotiGlowne',
                       'value'=>'',
                    ),
                'diagnoza'=>array(
                        'baza'=>'diagnoza',
                        'sql' => '`diagnoza` as `diagnoza`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'textarea',
                    'label'=>'Diagnoza',
                    'class'=>'textareaForm',
                     'style'=>'width:300px;min-width:300px;max-width:300px;',
                    'divek'=>'divNotiWykonanie',
                       'value'=>'',
                    ),
                'cozrobione'=>array(
                        'baza'=>'cozrobione',
                        'sql' => '`cozrobione` as `cozrobione`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'textarea',
                    'label'=>'Co zrobione',
                    'class'=>'textareaForm',
                    'style'=>'width:300px;min-width:300px;max-width:300px;',
                    'divek'=>'divNotiWykonanie',
                       'value'=>'',
                    ),
                'uzyte_materialy'=>array(
                        'baza'=>'uzyte_materialy',
                        'sql' => '`uzyte_materialy` as `uzyte_materialy`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'textarea',
                    'label'=>'Użyte materiały',
                  'class'=>'textareaForm',
                     'style'=>'width:300px;min-width:300px;max-width:300px;',
                    'divek'=>'divNotiWykonanie',
                       'value'=>'',
                    ),
               
                'ilosc_km'=>array(
                        'baza'=>'ilosc_km',
                        'sql' => '`ilosc_km` as `ilosc_km`',
                      'datatype'=>'d',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Ilość km',
                    'class'=>'textBoxForm liczba',
                    'style'=>'width:120px;min-width:120px;max-width:120px;',
                    'datatypeshow'=>'decimal',
                    'divek'=>'divNotiWykonanie',
                       'value'=>'',
                    ),
                'czas_pracy'=>array(
                        'baza'=>'czas_pracy',
                        'sql' => '`czas_pracy` as `czas_pracy`',
                      'datatype'=>'d',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Czas pracy',
                    'class'=>'textBoxForm liczba',
                    'style'=>'width:100px;min-width:100px;max-width:100px;',
                    'datatypeshow'=>'decimal',
                    'divek'=>'divNotiWykonanie',
                       'value'=>'',
                    ),
                'wartosc_materialow'=>array(
                        'baza'=>'wartosc_materialow',
                        'sql' => '`wartosc_materialow` as `wartosc_materialow`',
                      'datatype'=>'d',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Wartość materiałów',
                    'class'=>'textBoxForm liczba',
                    'style'=>'width:120px;min-width:120px;max-width:120px;',
                    'datatypeshow'=>'decimal',
                    'divek'=>'divNotiWykonanie',
                       'value'=>'',
                    ),
                'user_podjecia'=>array(
                        'baza'=>'user_podjecia',
                        'sql' => '`user_podjecia` as `user_podjecia`',
                      'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'user_podjecia',
                    'class'=>'textBoxForm',
                    'style'=>'width:120px;min-width:120px;max-width:120px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                'data_podjecia'=>array(
                        'baza'=>'date_podjecia',
                        'sql' => '`date_podjecia` as `date_podjecia`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'data_podjecia',
                    'class'=>'textBoxForm',
                    'style'=>'width:130px;min-width:130px;max-width:130px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                'user_zakonczenia'=>array(
                        'baza'=>'user_zakonczenia',
                        'sql' => '`user_zakonczenia` as `user_zakonczenia`',
                      'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'user_zakonczenia',
                    'class'=>'textBoxForm',
                    'style'=>'width:200px;min-width:200px;max-width:200px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                'date_zakonczenia'=>array(
                        'baza'=>'date_zakonczenia',
                        'sql' => '`date_zakonczenia` as `date_zakonczenia`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'date_zakonczenia',
                    'class'=>'textBoxForm',
                    'style'=>'width:140px;min-width:140px;max-width:140px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                'user_insert'=>array(
                        'baza'=>'user_insert',
                        'sql' => '`user_insert` as `user_insert`',
                      'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'user_insert',
                    'class'=>'textBoxForm',
                    'style'=>'width:60px;min-width:60px;max-width:60px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                'date_insert'=>array(
                        'baza'=>'date_insert',
                        'sql' => '`date_insert` as `date_insert`',
                      'datatype'=>'s',
                    'datatypeshow'=>'datetime',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'Data utworzenia',
                    'class'=>'textBoxForm',
                    'style'=>'width:40px;min-width:140px;max-width:140px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'0',
                       'value'=>'',
                    ),
                'activity'=>array(
                        'baza'=>'activity',
                        'sql' => '`activity` as `activity`',
                      'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'activity',
                    'class'=>'textBoxForm',
                    'style'=>'width:60px;min-width:60px;max-width:60px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                'user_delete'=>array(
                        'baza'=>'user_delete',
                        'sql' => '`user_delete` as `user_delete`',
                      'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'user_delete',
                    'class'=>'textBoxForm',
                    'style'=>'width:60px;min-width:60px;max-width:60px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                'date_delete'=>array(
                        'baza'=>'date_delete',
                        'sql' => '`date_delete` as `date_delete`',
                      'datatype'=>'s',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'date_delete',
                    'class'=>'textBoxForm',
                    'style'=>'width:60px;min-width:60px;max-width:60px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                'rowid'=>array(
                        'iskey'=>'1',
                        'baza'=>'rowid',
                        'sql' => '`rowid` as `rowid`',
                        'datatype'=>'i',
                    'activity'=>'1',
                    'type'=>'text',
                    'label'=>'rowid',
                    'class'=>'textBoxForm',
                    'style'=>'width:60px;min-width:60px;max-width:60px;',
                    'divek'=>'divNotiGlowne',
                    'readonly'=>'1',
                     'ishide'=>'1',
                       'value'=>'',
                    ),
                );
        // </editor-fold> 
    protected $_keyname='rowid';
    
    
    protected $filterklient='',$filternrseryjny='',$filternrzlecenia='',$filterdataod='',$filterdatado='',$filterstatusy='';
    protected $_filter=' where a.activity<>0 ';
    function __construct() {
        parent::__construct();
        
    }
    
    function save($czymail='0') {
                     if($czymail=='1')
                            $this->czyupdate=0;
                if($this->_filedsToEdit['rowid']['value']!='')
                {
                    $rowidArray2 = $this->getNotificationByRowid($this->_filedsToEdit['rowid']['value']);
                    if(empty($rowidArray2))
                    {
                        $this->_filedsToEdit['rowid']['value'] = '';
                    }
                }

                if($this->_filedsToEdit['rowid_client']['value']=='' && $this->_filedsToEdit['email']['value']!='')
                { // spróbuj przypisać rowid_clienta na podstawie email

                    $client = new client();
                    $rowidArray = $client->getRowidByEmailCase($this->_filedsToEdit['email']['value']);
                    if(!empty($rowidArray))
                    {
                        $nameArray = $client->getNameByRowid($rowidArray[0]['rowid']);    
                        $this->_filedsToEdit['rowid_client']['value'] = $rowidArray[0]['rowid'];
                    }
                    unset($client);
                }
                if($this->_filedsToEdit['rowid_client']['value']!='')
                { // spróbuj przypisać rowid_clienta na podstawie email

                    $client = new client();
                    
                        $nameArray = $client->getNameByRowid($this->_filedsToEdit['rowid_client']['value']);    
                       
                    
                    unset($client);
                }
                
                
                
                
                
                $wynik = parent::save();
                $wynik['clientname']='Brak';
                if(!empty($nameArray))
                {
                    $wynik['clientname'] = $nameArray[0]['nazwapelna'];
                }
                
                return $wynik;
        
    }
    function getNotificationByRowid($rowid)
    {
        $query = "select rowid from notifications where rowid={$rowid}";
        return $this->query($query,null,false); 
    }
    function getMailByRowid($rowid)
    {
        $query = "select mail from users where rowid={$rowid} and activity=1";
        return $this->query($query,null,false); 
    }
      function getNotificationByRowid2($rowid)
    {
        $query = "select * from notifications where rowid={$rowid}";
        return $this->query($query,null,false);     
    }
    function getOsoby()
    {
        $query = "select rowid as id,id as dane from users where activity=1";
        return $this->query($query,'id',false); 
    }
    function getWykonuje($rowid)
    {
         $query = "select wykonuje from notifications where rowid={$rowid}";
        return $this->query($query,null,false); 
    }
    function getStatus()
    {
        
        $query = "select * from notifications_status ";
        return $this->query($query,null,false); 
    }

    function getType()
    {
        $query = "select * from notifications_type ";
        return $this->query($query,null,false);
    }

    function getNotiKonczace()
    {
         $query = "select 

a.*,
a.SLA-(( unix_timestamp(now())
       - unix_timestamp(a.date_insert) ) / 3600.0) as 'pozostalo_godzin',
       b.mail,
       c.nazwakrotka
 from 
 (notifications a left outer join users b on a.wykonuje=b.rowid)
    left outer join clients c on a.rowid_client=c.rowid
 where a.activity=1 and a.user_zakonczenia is null and a.wykonuje is not null and a.sla is not null 
 and
 a.SLA-(( unix_timestamp(now())
       - unix_timestamp(a.date_insert) ) / 3600.0) between -20 and 2";
        return $this->query($query,null,false); 
    }
    function getStatusy()
    {
        
        $query = "select rowid as id,nazwa as dane,czydefault as czydefault from notifications_status ";
        return $this->query($query,'id',false); 
    }
    function createFilter()
    {
        
        if($this->filterklient!='')
        {
            $this->_filter.=" and b.nazwakrotka like '%{$this->filterklient}%'";
        }
        if($this->filternrseryjny!='')
        {
            $this->_filter.=" and a.serial like '%{$this->filternrseryjny}%'";
        }
        if($this->filternrzlecenia!='')
        {
            $this->_filter.=" and a.rowid = '{$this->filternrzlecenia}'";
        }   
        
        if(!empty($this->filterstatusy))
        {
            $stat="";
                    foreach ($this->filterstatusy as $key => $value) 
                    {

                        if($stat=='')
                            $stat.=" status=".str_replace ("txtstatus", "",$key);
                        else
                            $stat.=" or status=".str_replace ("txtstatus", "",$key);
                        
                    }
             
            $this->_filter.="and ( {$stat} ) ";
            
            
            if(isset($_SESSION['przypisanemenu']['widok_przypisane']))
            {
                $this->_filter.="and (wykonuje= {$_SESSION['user']['rowid']} ) ";
            }
            
            
            
        }
        if($this->filterdataod!='')
        {
            $this->_filter.=" and a.date_insert >= '{$this->filterdataod}'";
        }
       if($this->filterdatado!='')
        {
            $this->_filter.=" and a.date_insert <= '{$this->filterdatado}'";
        }
        
        
    }
    function getData()
    {
        $this->createFilter();
          $query = "  
                select 
                a.rowid as 'rowid',
                a.rowid_client as 'rowid_client',
                b.nazwakrotka as 'nazwakrotka',
                a.serial as 'serial',
                a.rowid_type as 'rowid_type',
                a.date_insert as 'date_insert',
                a.date_zakonczenia as 'date_zakonczenia',
                c.sla as 'sla',
                TIMESTAMPDIFF(HOUR, a.date_insert, IFNULL(a.date_zakonczenia,now())) as `czas_trwania`
                from
                (notifications a left outer join clients b on a.rowid_client=b.rowid)
                    left outer join agreements c on a.rowid_agreements=c.rowid
                {$this->_filter}
                order by a.rowid desc
        ";
               
        return $this->query($query,null,false); 
        
    }
    function getZalacznikiPierwszyMail($rowid)
    {
        
          $query = "  
                select
                a.newpath as path,
                a.oldname as 'filename'
                from sendfiles a
                where
                a.activity=1 and a.prefix='mails' and
                a.rowid_parent =
                (
                    select b.rowid from notifications_mails b where b.activity=1 and b.noti_rowid={$rowid} and b.czywyslany=0
                    order by rowid asc limit 1
                )
        ";
               
        return $this->query($query,null,false); 
        
    }
}