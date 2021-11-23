<?php
  


$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$typ=1;

if(mysqli_connect_errno())
{
     if($typ==0)
            file_put_contents(LOGFILE, 'Błąd:'.mysqli_connect_error().date("Y-m-d H:i:s")."\n",FILE_APPEND | LOCK_EX);
     else
        echo mysqli_connect_error();
        die();
}
$mysqli ->query("SET NAMES 'utf8'");  


        
function check_ceses() 
{

    $noti = new notification();
    $dataNotiKonczace = $noti->getNotiKonczace();

    if(!empty($dataNotiKonczace))
    {
        $mailing = new mailing();
        foreach ($dataNotiKonczace as $key => $item) 
        {
            
            if((string)$item['mail']!='')
            {
                
                   $modelurzadzenia='';
                          $nrseryjny='';
                          $przebieg='';
                          $stantonera='';
                          $adresip='';
                          $firmware='';
                          $printerLogs='';
                          
                if((string)$item['serial']!='')
                {

                    $printer = new printer();
                    $dataPrinter = $printer->getPrinterBySerial($item['serial']);

                    if(!empty($dataPrinter))
                    {
                          $modelurzadzenia=$dataPrinter[0]['model'];
                          $nrseryjny=$item['serial'];
                          $przebieg=$dataPrinter[0]['iloscstron_total'];
                          $stantonera=$dataPrinter[0]['black_toner']."%";
                          $adresip=$dataPrinter[0]['ip'];
                          $firmware=$dataPrinter[0]['nr_firmware'];
                    }

                    $dataPrinterLogs = $printer->getPrinterLogs($item['serial']);
                    if (!empty($dataPrinterLogs)) {
                        $printerLogs = implode('<br/>', array_map(function ($value) {return $value['timestamp'] . ' - ' . $value['eventcode'];}, $dataPrinterLogs));
                    }

                    unset($printer);

                }
                
                      $mailing->sendMailPrzypomnienie(
                              $item['rowid'],
                              $item['mail'], 
                              nl2br($item['tresc_wiadomosci']),
                      "[Ticket#{$item['rowid']}] ".$item['temat'],
                      $item['nazwakrotka'],
                      $item['osobazglaszajaca'],
                      $item['nr_telefonu'],
                      $modelurzadzenia,$nrseryjny,$przebieg,$stantonera,$adresip,$firmware,$printerLogs,$item['pozostalo_godzin']
                      );
                
            }
        }
        unset($mailing);
    }
    
    
    
    
    
    unset($noti);
            
}
        
function saveSprawa()
{
 
    $noti = new notification();
    $noti->populateFieldsToSave('fields','0');
    $wynik = $noti->save('1');
    
    if(isset($wynik['keyval']))
    {
        
        $_POST['notimailfields']['noti_rowid']=$wynik['keyval'];
         if (!strpos($_POST['notimailfields']['temat'],"[Ticket#") ) 
                $_POST['notimailfields']['temat']="[Ticket#{$wynik['keyval']}] ".$_POST['notimailfields']['temat'];        
    }
    if(isset($wynik['isnew']))
    {
          $mailing = new mailing();
          $mailing->sendMailZarejestrowano($_POST['notimailfields']['noti_rowid'],
                  $_POST['notimailfields']['email'],
                 nl2br($_POST['notimailfields']['tresc_wiadomosci']),$_POST['notimailfields']['temat']);
          unset($mailing);
          
          $mailing = new mailing();
          $mailing->sendMailInfoNowy($_POST['notimailfields']['noti_rowid'],$_POST['notimailfields']['date_email'],nl2br($_POST['notimailfields']['tresc_wiadomosci']),$_POST['notimailfields']['temat'],$wynik['clientname']);
          unset($mailing);
          
    }
    unset($noti);
}
function saveMail()
{
   
    $notimail = new notimail();
    $notimail->populateFieldsToSave('notimailfields','0');
   
    $notimail->save();
    unset($notimail);
}
function validatesAsInt($number)
{
    $number = filter_var($number, FILTER_VALIDATE_INT);
    return ($number !== FALSE);
}
function validatesAsDecimal( $number )
{
    $number = filter_var($number, FILTER_VALIDATE_FLOAT);
    return ($number !== FALSE);
}