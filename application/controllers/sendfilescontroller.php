<?php
class sendfilesController extends Controller 
{  
   private $max_size = 20000000,$prefix='',$id_parent='',$rowid_file='';
    
    public function __construct($model, $controller, $action, $queryString) {
        parent::__construct($model, $controller, $action, $queryString);
        
       
    }
    
    
    function getfiles()
    {
                $nameOfModel = ($this->_model);
                $dataFiles= $this->$nameOfModel->getFiles($_POST['id_parent'],$_POST['prefix']);
                echo(json_encode($dataFiles));
    }
    function openfile()
    {
        
            $path =ROOT.DS.'public_html'.DS.$this->_queryString[1].'/'.$this->_queryString[2].'/'.$this->_queryString[3];
     
            
                $arr = explode('.', $this->_queryString[3]);
        
                switch ($arr[1])
                {
                    case 'pdf':
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/pdf');
                            header('Content-Disposition: filename="'.$this->_queryString[3].'"');
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            flush();
                            readfile($path);
                            exit;
                        break;
                    default:
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename="'.$this->_queryString[3].'"');
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            flush();
                            readfile($path);
                            exit;
                        break;
                }
            
            
        	
            
    }
    public function delete()
    {
        if(isset($_POST['rowid_file']) && $_POST['rowid_file']!='')
        {
                if(isset($_POST['rowid_file']) && $_POST['rowid_file']!='')
                    $this->rowid_file = $_POST['rowid_file'];
                if(isset($_POST['prefix']) && $_POST['prefix']!='')
                    $this->prefix = $_POST['prefix'];
                if(isset($_POST['id_parent']) && $_POST['id_parent']!='')
                    $this->id_parent = $_POST['id_parent'];
                else
                {
                    echo(json_encode(
                        array
                            (
                                'code'=>'403',
                                 'msg'=>'Musisz wybrać do czego chcesz dodać plik'
                            )
                        ));
                    die();
                }   
                $_POST['_filedsToEdit']['prefix']=$this->prefix;
                $_POST['_filedsToEdit']['rowid_parent']=$this->id_parent;
                $_POST['_filedsToEdit']['rowid']=$this->rowid_file;
                $_POST['czydelete']='1';
                
                $nameOfModel = ($this->_model);
                $this->$nameOfModel->populateFieldsToSave('_filedsToEdit','0'); 
                $this->$nameOfModel->set('czydelete','1');
                
                $wynikzapisu = $this->$nameOfModel->save();
                
               if($wynikzapisu['status']==1)
               {
                 //unlink($_POST['new_path']);
                 echo('Plik usunięto poprawnie');
               }
               else
               {   
                   print_r($wynikzapisu);
               }
        }
        ELSE
            echo('Plik usunięto poprawnie');
        
    }
    
    
    public function post_upload()
    {
        
           if(isset($_POST['rowid_file']) && $_POST['rowid_file']!='')
                    $this->rowid_file = $_POST['rowid_file'];
                if(isset($_POST['prefix']) && $_POST['prefix']!='')
                    $this->prefix = $_POST['prefix'];
                if(isset($_POST['id_parent']) && $_POST['id_parent']!='')
                    $this->id_parent = $_POST['id_parent'];
                else
                {
                    echo(json_encode(
                        array
                            (
                                'code'=>'403',
                                 'msg'=>'Musisz wybrać do czego chcesz dodać plik'
                            )
                        ));
                    die();
                }
        $target_dir = MAILATTACH;
        $orgName = $_FILES["file"]["name"];
        $ext = end((explode(".", $orgName)));
        $type = $_FILES["file"]["type"];
        $dozwoloneTypyPlikow = array
        (
            'image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'application/vnd.ms-excel',
            'application/pdf',
            'application/vnd.ms-powerpoint',
            'text/rtf',
            'text/plain',
            'application/msword',
            'image/tiff',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        
      
        
        
        if($this->prefix!='')
        {
            $target_dir.=$this->prefix.'/';
            if (!file_exists($target_dir)) 
            {
                mkdir($target_dir, 0777, true);
            }
        }
        
        
        $newfilename = $this->id_parent.'_'.date('m-d-Y-his').'.'.$ext;
        
        $target_file = $target_dir . $newfilename;
        
        
        if (file_exists($target_file)) 
        {
                echo(json_encode(
                array
                    (
                        'code'=>'403',
                         'msg'=>'Taki plik już istnieje'
                    )
                ));
                die();
        } 
        
        if(!in_array($type, $dozwoloneTypyPlikow))
        {
                echo(json_encode(
                array
                    (
                        'code'=>'403',
                         'msg'=>'Niedozwolony plik'
                    )
                ));
                die();
        }
        if ($_FILES["file"]["size"] > $this->max_size) {
                echo(json_encode(
                array
                    (
                        'code'=>'403',
                         'msg'=>'Plik za duży - max. 20MB'
                    )
                ));
                die();
        } 
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) 
        {
                
                $_POST['_filedsToEdit']['prefix']=$this->prefix;
                $_POST['_filedsToEdit']['rowid_parent']=$this->id_parent;
                $_POST['_filedsToEdit']['newname']=$newfilename;
                $_POST['_filedsToEdit']['newpath']=$target_file;
                $_POST['_filedsToEdit']['extension']=$ext;
                $_POST['_filedsToEdit']['oldname']=$orgName;
                $_POST['_filedsToEdit']['filetype']=$type;
                $_POST['_filedsToEdit']['size']=$_FILES["file"]["size"];
                $_POST['_filedsToEdit']['activity']=1;
                $_POST['_filedsToEdit']['rowid']='0';
                $_POST['czydelete']='0';
                
                $nameOfModel = ($this->_model);
                $this->$nameOfModel->populateFieldsToSave('_filedsToEdit','0'); 
                $this->$nameOfModel->set('czydelete','0');
                
                 $wynikzapisu = $this->$nameOfModel->save();
                
                
                
                
               if($wynikzapisu['status']==1)
               {
            
                            echo(json_encode(
                            array
                                (
                                    'code'=>'501',
                                     'msg'=>'Plik dodany poprawnie',
                                     'rowid'=>$wynikzapisu['rowid'],
                                     'prefix'=>$this->prefix,
                                     'id_parent'=>$this->id_parent,
                                     'new_path'=>$target_file
                                )
                            ));
               }
               else
               {
                   
                   unlink($target_file);
                    echo(json_encode(
                    array
                        (
                            'code'=>'403',
                             'msg'=>'Błąd dodania pliku'
                        )
                    ));
               }
        } else 
        {
                echo(json_encode(
                array
                    (
                        'code'=>'403',
                         'msg'=>'Błąd dodania pliku'
                    )
                ));
            }
        
  
      
        
    }
}
