<?php
class notimail extends Model 
{

    
   // <editor-fold defaultstate="collapsed" desc="Jakie pola mają być edytowane">
    public 
        $_filedsToEdit = array
                (
                'noti_rowid'=>array(
                      'baza'=>'noti_rowid',
                      'sql' => '`noti_rowid` as `noti_rowid`',
                      'datatype'=>'i',
                       'value'=>'',
                    ),
                'email'=>array(
                        'baza'=>'email',
                        'sql' => '`email` as `email`',
                      'datatype'=>'s',
                       'value'=>'',
                    ),
                 'temat'=>array(
                        'baza'=>'temat',
                        'sql' => '`temat` as `temat`',
                      'datatype'=>'s',
                       'value'=>'',
                    ),
                'tresc_wiadomosci'=>array(
                        'baza'=>'tresc_wiadomosci',
                        'sql' => '`tresc_wiadomosci` as `tresc_wiadomosci`',
                      'datatype'=>'s',
                       'value'=>'',
                    ),
                'date_email'=>array(
                        'baza'=>'date_email',
                        'sql' => '`date_email` as `date_email`',
                      'datatype'=>'s',
                       'value'=>'',
                    ),
                'size'=>array(
                        'baza'=>'size',
                        'sql' => '`size` as `size`',
                      'datatype'=>'i',
                       'value'=>'',
                    ),
                'user_insert'=>array(
                        'baza'=>'user_insert',
                        'sql' => '`user_insert` as `user_insert`',
                      'datatype'=>'i',
                       'value'=>'',
                    ),
                'date_insert'=>array(
                        'baza'=>'date_insert',
                        'sql' => '`date_insert` as `date_insert`',
                      'datatype'=>'s',
                       'value'=>'',
                    ),
                'activity'=>array(
                        'baza'=>'activity',
                        'sql' => '`activity` as `activity`',
                      'datatype'=>'i',
                       'value'=>'',
                    ),
                'user_delete'=>array(
                        'baza'=>'user_delete',
                        'sql' => '`user_delete` as `user_delete`',
                      'datatype'=>'i',
                       'value'=>'',
                    ),
                'date_delete'=>array(
                        'baza'=>'date_delete',
                        'sql' => '`date_delete` as `date_delete`',
                      'datatype'=>'s',
                       'value'=>'',
                    ),
                'czywyslany'=>array(
                        'baza'=>'czywyslany',
                        'sql' => '`czywyslany` as `czywyslany`',
                      'datatype'=>'i',
                       'value'=>'',
                    ),
                'replyrowid'=>array(
                        'baza'=>'replyrowid',
                        'sql' => '`replyrowid` as `replyrowid`',
                      'datatype'=>'i',
                       'value'=>'',
                    ),
                'rowid'=>array(
                        'iskey'=>'1',
                        'baza'=>'rowid',
                        'sql' => '`rowid` as `rowid`',
                        'datatype'=>'i',
                       'value'=>'',
                    ),
                );
        // </editor-fold> 
    protected $_keyname='rowid';
    protected $noti_rowid,$replyrowid,$tresc,$temat,$mail,$uniqueid;
    
    
    function __construct() {
        parent::__construct();
        $this->_table = 'notifications_mails';
    }
    function getDanePrzypisane()
    {
     
        return $this->selectWhere('rowid',false,'i',array($this->noti_rowid),' noti_rowid=? and activity=1','*',' order by date_email desc'); 
    }
    function getMailByRowid($rowid)
    {
        return $this->selectWhere(null,false,'i',array($rowid),' rowid=? ','*'); 
    }
    
     function savenewmail()
    {
       
              $columnList = "`noti_rowid`,
                            `email`,
                            `temat`,
                            `tresc_wiadomosci`,
                            `date_email`,
                            `size`,
                            `user_insert`,
                            `date_insert`,
                            `activity`,
                            
                            `czywyslany`,
                            `replyrowid`";
              $wynik =  $this->insert($columnList,'issssiisiii',
                      array(
                                    $this->noti_rowid,
                                        $this->mail==''?"NULL":$this->mail,
                                        $this->temat==''?"NULL":$this->temat,
                                        $this->tresc==''?"NULL":$this->tresc,
                                        date('Y-m-d H:i:s'),'0',$_SESSION['user']['rowid'],date('Y-m-d H:i:s'),1,1,
                                    ($this->replyrowid=='' || $this->replyrowid=='0')?"0":$this->replyrowid
                      ));
              
            if($wynik['status']==1)
            {
                   $this->update
                             (
                                 "update sendfiles set rowid_parent=".$wynik['rowid']." where `rowid_parent`=?"
                                ,'i', 
                                 array
                                 (
                                     $this->uniqueid
                                 )
                             );  
                 
            }
            return $wynik;
       
      
    }
    
    
}