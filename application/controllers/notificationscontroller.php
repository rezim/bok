<?php
class notificationsController extends Controller 
{
   
    
    function show()
    {
        
        global $smarty;
        $statusZgloszenie = $this->notification->getStatus();
        $smarty->assign('statusZgloszenie',$statusZgloszenie);
        
        unset($statusZgloszenie);
        
        
    }
    function showdane()
    {
        $this->notification->populateWithPost();
        $dataNoti = $this->notification->getData();
        global $smarty;
        $smarty->assign('dataNoti',$dataNoti);
        unset($dataNoti);
        
    }
    function addedit() {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
          {
                
                $daneWykonuje = $this->notification->getOsoby();
                $daneStatus = $this->notification->getStatusy();
                $daneType = $this->notification->getType();
                global $smarty;
                $smarty->assign('daneWykonuje',$daneWykonuje);
                $smarty->assign('daneStatus',$daneStatus);
                $smarty->assign('daneType',$daneType);

                parent::addedit();
          }
          else
          {
                 header("Location: /");
          }
    }
    function save()
    {
         $nameOfModel = ($this->_model);
         
        
         
         $this->$nameOfModel->populateFieldsToSave('_filedsToEdit','1'); 
         $this->$nameOfModel->set('czydelete',$_POST['czydelete']);
         $this->_czyjuzpopulate=1;
         if($this->$nameOfModel->_filedsToEdit['status']['value']=='2' && $this->$nameOfModel->_filedsToEdit['user_podjecia']['value']=='')
        {
            $this->$nameOfModel->_filedsToEdit['user_podjecia']['value']=$_SESSION['user']['rowid'];
            $this->$nameOfModel->_filedsToEdit['data_podjecia']['value']=date('Y-m-d H:i:s');
        }
        if($this->$nameOfModel->_filedsToEdit['status']['value']=='3' && 
          ($this->$nameOfModel->_filedsToEdit['ilosc_km']['value']=='' || $this->$nameOfModel->_filedsToEdit['czas_pracy']['value']=='' || $this->$nameOfModel->_filedsToEdit['wartosc_materialow']['value']=='')
          )
        {
             
            echo('Aby zamknąć zleceni muszą być uzupełnione wszystkie pola ( ilość km, czas pracy, wartość materiałów )');
            die();
            
        }
        if($this->$nameOfModel->_filedsToEdit['status']['value']=='3' && $this->$nameOfModel->_filedsToEdit['user_zakonczenia']['value']=='')
        {
            
            $this->$nameOfModel->_filedsToEdit['user_zakonczenia']['value']=$_SESSION['user']['rowid'];
            $this->$nameOfModel->_filedsToEdit['date_zakonczenia']['value']=date('Y-m-d H:i:s');
            if((string)$this->$nameOfModel->_filedsToEdit['email']['value']!='' && (string)$this->$nameOfModel->_filedsToEdit['rowid']['value']!='')
            {
                 $mailing = new mailing();
                 $mailing->sendMailZakonczono((string)$this->$nameOfModel->_filedsToEdit['rowid']['value'],
                         $this->$nameOfModel->_filedsToEdit['email']['value'],
                         $this->$nameOfModel->_filedsToEdit['tresc_wiadomosci']['value'],
                        $this->$nameOfModel->_filedsToEdit['temat']['value']);
                unset($mailing);
            }
        }
        $czyjuzbylo=0;
        
        
        if((string)$this->$nameOfModel->_filedsToEdit['rowid']['value']!='')
        {
            $dataWykonuje = $this->$nameOfModel->getWykonuje($this->$nameOfModel->_filedsToEdit['rowid']['value']);
            if(!empty($dataWykonuje) && $dataWykonuje[0]['wykonuje']!='')
            {
                        $czyjuzbylo=1;
            }
            
        }
         
         $wynik = parent::save();
        
        
        if((string)$this->$nameOfModel->_filedsToEdit['wykonuje']['value']!='0' && (string)$this->$nameOfModel->_filedsToEdit['wykonuje']['value']!='' && $czyjuzbylo==0)
        {
            $dataMail = $this->$nameOfModel->getMailByRowid($this->$nameOfModel->_filedsToEdit['wykonuje']['value']);
            if(!empty($dataMail) && $dataMail[0]['mail']!='')
            {
                
                if($this->$nameOfModel->_filedsToEdit['serial']['value']=='')
                {
                       $modelurzadzenia='';
                          $nrseryjny='';
                          $przebieg='';
                          $stantonera='';
                          $adresip='';
                          $firmware='';
                }
                else
                {

                    $printer = new printer();
                    $dataPrinter = $printer->getPrinterBySerial($this->$nameOfModel->_filedsToEdit['serial']['value']);


                          $modelurzadzenia=$dataPrinter[0]['model'];
                          $nrseryjny=$this->$nameOfModel->_filedsToEdit['serial']['value'];
                          $przebieg=$dataPrinter[0]['iloscstron_total'];
                          $stantonera=$dataPrinter[0]['black_toner']."%";
                          $adresip=$dataPrinter[0]['ip'];
                          $firmware=$dataPrinter[0]['nr_firmware'];

                    unset($printer);

                }
                $dataZalacznikiFirst = array();
              
            
                $dataZalacznikiFirst = $this->$nameOfModel->getZalacznikiPierwszyMail($wynik['keyval']);
                  
                   $mailing = new mailing();
              $mailing->sendMailPrzydzielonoZlecenie($wynik['keyval'],$dataMail[0]['mail'], nl2br($this->$nameOfModel->_filedsToEdit['tresc_wiadomosci']['value']),
                      "[Ticket#{$wynik['keyval']}] ".$this->$nameOfModel->_filedsToEdit['temat']['value'],
                      $wynik['clientname'],
                      $this->$nameOfModel->_filedsToEdit['osobazglaszajaca']['value'],
                      $this->$nameOfModel->_filedsToEdit['nr_telefonu']['value'],
                      $modelurzadzenia,$nrseryjny,$przebieg,$stantonera,$adresip,$firmware,$this->$nameOfModel->_filedsToEdit['data_planowana']['value'],
                              $dataZalacznikiFirst
                      );
              unset($mailing);
                
            }
            
            
            
        }
      
     
       
        
        if(isset($wynik['isnew']) && $this->$nameOfModel->_filedsToEdit['email']['value']!='')
        {
            
            
            if($this->$nameOfModel->_filedsToEdit['serial']['value']=='')
            {
                   $modelurzadzenia='';
                      $nrseryjny='';
                      $przebieg='';
                      $stantonera='';
                      $adresip='';
                      $firmware='';
            }
            else
            {
                
                $printer = new printer();
                $dataPrinter = $printer->getPrinterBySerial($this->$nameOfModel->_filedsToEdit['serial']['value']);
                
                
                      $modelurzadzenia=$dataPrinter[0]['model'];
                      $nrseryjny=$this->$nameOfModel->_filedsToEdit['serial']['value'];
                      $przebieg=$dataPrinter[0]['iloscstron_total'];
                      $stantonera=$dataPrinter[0]['black_toner']."%";
                      $adresip=$dataPrinter[0]['ip'];
                      $firmware=$dataPrinter[0]['nr_firmware'];
                
                unset($printer);
                
            }
            
            
            
            if($this->$nameOfModel->_filedsToEdit['email']['value']!='')
            {
               
           
              $mailing = new mailing();
              $mailing->sendMailZarejestrowano($wynik['keyval'],$this->$nameOfModel->_filedsToEdit['email']['value'],nl2br($this->$nameOfModel->_filedsToEdit['tresc_wiadomosci']['value']),
                      "[Ticket#{$wynik['keyval']}] ".$this->$nameOfModel->_filedsToEdit['temat']['value']);
              unset($mailing);
              
              
              
            }
            
              $mailing = new mailing();
              $mailing->sendMailInfoNowy($wynik['keyval'],$this->$nameOfModel->_filedsToEdit['date_email']['value'], nl2br($this->$nameOfModel->_filedsToEdit['tresc_wiadomosci']['value']),
                      "[Ticket#{$wynik['keyval']}] ".$this->$nameOfModel->_filedsToEdit['temat']['value'],
                      $wynik['clientname'],
                      $this->$nameOfModel->_filedsToEdit['osobazglaszajaca']['value'],
                      $this->$nameOfModel->_filedsToEdit['nr_telefonu']['value'],
                      $modelurzadzenia,$nrseryjny,$przebieg,$stantonera,$adresip,$firmware
                      );
              unset($mailing);
              
        }
        
        echo(json_encode($wynik));
    }

}