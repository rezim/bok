<?php
class sendfile extends Model
{
    
    // <editor-fold defaultstate="collapsed" desc="Jakie pola mają być edytowane">
    public  
           $_filedsToEdit=array
               (
                    'prefix'=>array(
                        'baza'=>'prefix',
                        'maxlength'=>'20',
                        'wymagane'=>'0',
                        'sql' => '`prefix` as `prefix`',
                        'datatype'=>'s',
                        'activity'=>'1', 
                        'label'=>'Prefix',
                        'value'=>'',
                    ),
                    'rowid_parent'=>array(
                        'baza'=>'rowid_parent',
                        'wymagane'=>'0',
                        'sql' => '`rowid_parent` as `rowid_parent`',
                        'datatype'=>'i',
                        'activity'=>'1',         
                        'label'=>'Rowid parent',
                        'value'=>'',
                    ),
                    'size'=>array(
                        'baza'=>'size',
                        'wymagane'=>'0',
                        'sql' => '`size` as `size`',
                        'datatype'=>'i',
                        'activity'=>'1',         
                        'label'=>'Size',
                        'value'=>'',
                    ),
                    'newname'=>array(
                        'baza'=>'newname',
                        'maxlength'=>'400',
                        'wymagane'=>'0',
                        'sql' => '`newname` as `newname`',
                        'datatype'=>'s',
                        'activity'=>'1',      
                        'label'=>'Newname',
                        'value'=>'',
                    ),
                    'newpath'=>array(
                        'baza'=>'newpath',
                        'maxlength'=>'500',
                        'wymagane'=>'0',
                        'sql' => '`newpath` as `newpath`',
                        'datatype'=>'s',
                        'activity'=>'1', 
                        'label'=>'Newpath',
                        'value'=>'',
                    ),
                    'filetype'=>array(
                        'baza'=>'filetype',
                        'maxlength'=>'120',
                        'wymagane'=>'0',
                        'sql' => '`filetype` as `filetype`',
                        'datatype'=>'s',
                        'activity'=>'1', 
                        'label'=>'Filetype',
                        'value'=>'',
                    ),
                    'extension'=>array(
                        'baza'=>'extension',
                        'maxlength'=>'45',
                        'wymagane'=>'0',
                        'sql' => '`extension` as `extension`',
                        'datatype'=>'s',
                        'activity'=>'1', 
                        'label'=>'Extension',
                        'value'=>'',
                    ),
                    'oldname'=>array(
                        'baza'=>'oldname',
                        'maxlength'=>'400',
                        'wymagane'=>'0',
                        'sql' => '`oldname` as `oldname`',
                        'datatype'=>'s',
                        'activity'=>'1',   
                        'label'=>'Oldname',
                        'value'=>'',
                    ),
                   'user_insert'=>array(
                        'baza'=>'user_insert',
                        'wymagane'=>'0',
                        'sql' => '`user_insert` as `user_insert`',
                        'datatype'=>'i',
                        'activity'=>'1',
                       'label'=>'User insert',
                        'value'=>'',
                    ),
                    'date_insert'=>array(
                        'baza'=>'date_insert',
                        'wymagane'=>'0',
                        'sql' => '`date_insert` as `date_insert`',
                        'datatype'=>'s',
                        'activity'=>'1',    
                        'label'=>'Date insert',
                        'value'=>''
                    ),
                    'activity'=>array(
                        'baza'=>'activity',
                        'wymagane'=>'1',
                        'sql' => '`activity` as `activity`',
                        'datatype'=>'i',
                        'activity'=>'1',
                        'label'=>'Activity',
                        'value'=>''
                    ),
                    'user_delete'=>array(
                        'baza'=>'user_delete',
                        'wymagane'=>'0',
                        'sql' => '`user_delete` as `user_delete`',
                        'datatype'=>'i',
                        'activity'=>'1',
                        'label'=>'User delete',
                        'value'=>'',
                    ),
                    'date_delete'=>array(
                        'baza'=>'date_delete',
                        'wymagane'=>'0',
                        'sql' => '`date_delete` as `date_delete`',
                        'datatype'=>'s',
                        'activity'=>'1',
                        'label'=>'Date delete',
                        'value'=>''
                    ),
                    'rowid'=>array( 
                        'baza'=>'rowid',
                        'wymagane'=>'1',
                        'sql' => '`rowid` as `rowid`',
                        'datatype'=>'i',
                        'activity'=>'1',
                        'iskey'=>'1',
                        'label'=>'Rowid',
                        'value'=>'',
                    ),
               
               );
    
    // </editor-fold> 
    
    
    
     function getFiles($rowid_parent,$prefix)
    {
        $this->_table = 'sendfiles';
        return $this->selectWhere(null,false,'is',array($rowid_parent,$prefix),' rowid_parent=?  and prefix=? and activity=1','*'); 
    }
    
    
     function __construct() {
       parent::__construct();
       $this->_keyname='rowid';
   } 
    
    
    
    
    
}