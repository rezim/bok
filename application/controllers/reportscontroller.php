<?php
class reportsController extends Controller 
{  
   function show()
   {
       global $smarty;
       global $months;
        $smarty->assign('months',$months );
        $smarty->assign('rok',date("Y"));

       $smarty->assign('fakturownia_conf_file_path', ROOT . DS . 'config' . DS . 'fakturownia.conf');
   }
  
    function showdaneklient()
   {
  
       $this->report->populateWithPost();
       $dataReportsMiesieczne = $this->report->getReportsMiesieczne();
        $dataReportsRoczne = $this->report->getReportsRoczne();
      
        foreach($dataReportsMiesieczne as $key=>$item)
        {
         $dzien=0;  
         $oplatainstalacyjna = 0;
         $iloscDni = date("t",strtotime($item['dataod']));
        
            if(
                    date("m",strtotime($item['dataod']))==date("m",strtotime($item['dacik'])) &&
                    date("Y",strtotime($item['dataod']))==date("Y",strtotime($item['dacik'])))
            {
                $dzien = date("j",strtotime($item['dataod']))-1;
                $oplatainstalacyjna = $item['cenainstalacji'];
            }
            if(!isset($dataReports[$item['rowidclient']]['drukumowy']))
               $dataReports[$item['rowidclient']]['drukumowy']=1;
            else
               $dataReports[$item['rowidclient']]['drukumowy']+=1;
            
            $dataReports[$item['rowidclient']]['rowidclient']=$item['rowidclient'];
            $dataReports[$item['rowidclient']]['nazwapelna']=$item['nazwapelna'];
            $dataReports[$item['rowidclient']]['nazwakrotka']=$item['nazwakrotka'];
            $dataReports[$item['rowidclient']]['terminplatnosci']=$item['terminplatnosci'];
            $dataReports[$item['rowidclient']]['nip']=$item['nip'];
            $dataReports[$item['rowidclient']]['mailfaktury']=$item['mailfaktury'];
            $dataReports[$item['rowidclient']]['ulica']=$item['ulica'];
            $dataReports[$item['rowidclient']]['miasto']=$item['miasto'];
            $dataReports[$item['rowidclient']]['kodpocztowy']=$item['kodpocztowy'];
            $dataReports[$item['rowidclient']]['pokaznumerseryjny']=$item['pokaznumerseryjny'];
            $dataReports[$item['rowidclient']]['pokazstanlicznika']=$item['pokazstanlicznika'];
            $dataReports[$item['rowidclient']]['fakturadlakazdejumowy']=$item['fakturadlakazdejumowy'];


            if($item['strony_black_koniec']==0  && $item['strony_black_start'] == 0)
            {
                $dataReports[$item['rowidclient']]['blad']=1;
                $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['blad'] = 1;
            }
            if(($item['strony_black_koniec']-$item['strony_black_start'])<0)
            {
                $dataReports[$item['rowidclient']]['blad']=1;
                $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['blad'] = 1;
            }
            if(($item['strony_kolor_koniec']-$item['strony_kolor_start'])<0)
            {
                $dataReports[$item['rowidclient']]['blad']=1;
                $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['blad'] = 1;
            }
            
            if(!isset($dataReports['suma']))
            {
                $dataReports['suma'] = 0;
            }
            
             if(!isset($dataReports[$item['rowidclient']]['wartosc']))
            {
                $dataReports[$item['rowidclient']]['wartosc'] = 0;
            }
            if(!isset($dataReports[$item['rowidclient']]['wartoscblack']))
            {
                $dataReports[$item['rowidclient']]['wartoscblack'] = 0;
            }
            if(!isset($dataReports[$item['rowidclient']]['wartosckolor']))
            {
                $dataReports[$item['rowidclient']]['wartosckolor'] = 0;
            }
            if(!isset($dataReports[$item['rowidclient']]['wartoscabonament']))
            {
                $dataReports[$item['rowidclient']]['wartoscabonament'] = 0;
            }
            
            if(empty($item['rabatdoabonamentu']) || $item['rabatdoabonamentu']=='')
            {
                $item['rabatdoabonamentu']=0;
            }
            if(empty($item['rabatdowydrukow']) || $item['rabatdowydrukow']=='')
            {
                $item['rabatdowydrukow']=0;
            }
                $abonament = (empty($item['abonament'])==true?0:$item['abonament']);
                if($dzien!=0)
                {
                  
                    $abonament = $abonament - ($dzien*($abonament/$iloscDni));
                
                 }
                $abonament = $abonament-($abonament*($item['rabatdoabonamentu']/100));
            $dataReports[$item['rowidclient']]['wartoscabonament']=$dataReports[$item['rowidclient']]['wartoscabonament']+$abonament;
                
            
             if($dzien!=0)
             {
                 $item['stronwabonamencie'] = $item['stronwabonamencie'] - ($dzien*($item['stronwabonamencie']/$iloscDni));
                 $item['iloscstron_kolor'] = $item['iloscstron_kolor'] - ($dzien*($item['iloscstron_kolor']/$iloscDni));
             }
            
            
            
            if(isset($item['jakczarne']) && !empty($item['jakczarne']) && $item['jakczarne']==1)
            {
                $stronwsumie = 0;
                $stronwsumie = ($item['strony_black_koniec']-$item['strony_black_start'])+($item['strony_kolor_koniec']-$item['strony_kolor_start']);
                $stronblackpowyzej = ($stronwsumie-$item['stronwabonamencie'])<0?0:($stronwsumie-$item['stronwabonamencie']);
                $stronblackpowyzej = round($stronblackpowyzej);
                $wartoscblacktemp = $stronblackpowyzej*(empty($item['cenazastrone'])?0:$item['cenazastrone']);
                $wartoscblack = ($wartoscblacktemp - ($wartoscblacktemp*($item['rabatdowydrukow']/100)));
                $dataReports[$item['rowidclient']]['wartoscblack'] = $dataReports[$item['rowidclient']]['wartoscblack']+$wartoscblack;
                
                
                 $stronkolorpowyzej =0; 
                $wartosckolortemp =$stronkolorpowyzej *(empty($item['cenazastrone_kolor'])?0:$item['cenazastrone_kolor']);
                $wartosckolor = ($wartosckolortemp - ($wartosckolortemp*($item['rabatdowydrukow']/100)));
                
                $dataReports[$item['rowidclient']]['wartosckolor'] = $dataReports[$item['rowidclient']]['wartosckolor']+$wartosckolor;
            }    
            else
            {   
                $stronblackpowyzej = (($item['strony_black_koniec']-$item['strony_black_start'])-$item['stronwabonamencie'])<0?0:(($item['strony_black_koniec']-$item['strony_black_start'])-$item['stronwabonamencie']);
                $stronblackpowyzej = round($stronblackpowyzej);
                $wartoscblacktemp = $stronblackpowyzej*(empty($item['cenazastrone'])?0:$item['cenazastrone']);
                $wartoscblack = ($wartoscblacktemp - ($wartoscblacktemp*($item['rabatdowydrukow']/100)));
                $dataReports[$item['rowidclient']]['wartoscblack'] = $dataReports[$item['rowidclient']]['wartoscblack']+$wartoscblack;
                
                $stronkolorpowyzej =(($item['strony_kolor_koniec']-$item['strony_kolor_start'])-$item['iloscstron_kolor'])<0?0:(($item['strony_kolor_koniec']-$item['strony_kolor_start'])-$item['iloscstron_kolor']); 
                
                
                $stronkolorpowyzej = round($stronkolorpowyzej);
                
                
                
                $wartosckolortemp =$stronkolorpowyzej *(empty($item['cenazastrone_kolor'])?0:$item['cenazastrone_kolor']);
          
                $wartosckolor = ($wartosckolortemp - ($wartosckolortemp*($item['rabatdowydrukow']/100)));
               
                $dataReports[$item['rowidclient']]['wartosckolor'] = $dataReports[$item['rowidclient']]['wartosckolor']+$wartosckolor;
            }
            $wartosc= $abonament+
                                    $wartoscblack+
                                            $wartosckolor+
                                                $oplatainstalacyjna;
            $dataReports[$item['rowidclient']]['wartosc'] = 
                    $dataReports[$item['rowidclient']]['wartosc']+
                           $abonament+
                                    $wartoscblack+
                                            $wartosckolor
                                                    +$oplatainstalacyjna;
            $dataReports['suma'] = 
                    $dataReports['suma']+
                            $abonament+
                                    $wartoscblack+
                                            $wartosckolor+
                                                    $oplatainstalacyjna;


            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['nrumowy'] = $item['nrumowy'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['rowidumowa'] = $item['rowidumowa'];

            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['model'] = $item['model'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['stronwabonamencie'] = $item['stronwabonamencie'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['cenazastrone'] = $item['cenazastrone'];
            
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['iloscstron_kolor'] = $item['iloscstron_kolor'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['cenazastrone_kolor'] = $item['cenazastrone_kolor'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['rozliczenie'] = $item['rozliczenie'];
            
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['wartoscabonament'] = $abonament;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['serial'] = $item['serial'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['oplatainstalacyjna'] = $oplatainstalacyjna;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['wartoscblack'] = $wartoscblack;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['wartosckolor'] = $wartosckolor;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['stronblackpowyzej'] = $stronblackpowyzej;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['stronkolorpowyzej'] = $stronkolorpowyzej;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['wartosc'] = $wartosc;
            
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_black_start'] = $item['strony_black_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['data_wiadomosci_black_start'] = $item['data_wiadomosci_black_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_black_koniec'] = $item['strony_black_koniec'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['data_wiadomosci_black_koniec'] = $item['data_wiadomosci_black_koniec'];
            
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_kolor_start'] = $item['strony_kolor_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['data_wiadomosci_kolor_start'] = $item['data_wiadomosci_kolor_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_kolor_koniec'] = $item['strony_kolor_koniec'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['data_wiadomosci_kolor_koniec'] = $item['data_wiadomosci_kolor_koniec'];

            // device localization
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_ulica'] = $item['lokalizacja_ulica'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_miasto'] = $item['lokalizacja_miasto'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_kodpocztowy'] = $item['lokalizacja_kodpocztowy'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_telefon'] = $item['lokalizacja_telefon'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_mail'] = $item['lokalizacja_mail'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_nazwa'] = $item['lokalizacja_nazwa'];

       }

        foreach($dataReportsRoczne as $key=>$item)
        {
         
            if(!isset($dataReports[$item['rowidclient']]['drukumowy']))
               $dataReports[$item['rowidclient']]['drukumowy']=1;
            else
               $dataReports[$item['rowidclient']]['drukumowy']+=1;
            
            $dataReports[$item['rowidclient']]['rowidclient']=$item['rowidclient'];
            $dataReports[$item['rowidclient']]['nazwapelna']=$item['nazwapelna'];
            $dataReports[$item['rowidclient']]['nazwakrotka']=$item['nazwakrotka'];
            $dataReports[$item['rowidclient']]['terminplatnosci']=$item['terminplatnosci'];
            $dataReports[$item['rowidclient']]['nip']=$item['nip'];
            $dataReports[$item['rowidclient']]['mailfaktury']=$item['mailfaktury'];
            $dataReports[$item['rowidclient']]['ulica']=$item['ulica'];
            $dataReports[$item['rowidclient']]['miasto']=$item['miasto'];
            $dataReports[$item['rowidclient']]['kodpocztowy']=$item['kodpocztowy'];
            $dataReports[$item['rowidclient']]['pokaznumerseryjny']=$item['pokaznumerseryjny'];
            $dataReports[$item['rowidclient']]['pokazstanlicznika']=$item['pokazstanlicznika'];
            $dataReports[$item['rowidclient']]['fakturadlakazdejumowy']=$item['fakturadlakazdejumowy'];

            $oplatainstalacyjna = 0;
         
        
            if(
                    (date("Y",strtotime($item['dataod']))+1)==date("Y",strtotime($item['dacik'])))
            {
               
                $oplatainstalacyjna = $item['cenainstalacji'];
            }
            
            
            
            
            if(!isset($dataReports['suma']))
            {
                $dataReports['suma'] = 0;
            }
            
             if(!isset($dataReports[$item['rowidclient']]['wartosc']))
            {
                $dataReports[$item['rowidclient']]['wartosc'] = 0;
            }
            if(!isset($dataReports[$item['rowidclient']]['wartoscblack']))
            {
                $dataReports[$item['rowidclient']]['wartoscblack'] = 0;
            }
            if(!isset($dataReports[$item['rowidclient']]['wartosckolor']))
            {
                $dataReports[$item['rowidclient']]['wartosckolor'] = 0;
            }
            if(!isset($dataReports[$item['rowidclient']]['wartoscabonament']))
            {
                $dataReports[$item['rowidclient']]['wartoscabonament'] = 0;
            }
            
            if(empty($item['rabatdoabonamentu']) || $item['rabatdoabonamentu']=='')
            {
                $item['rabatdoabonamentu']=0;
            }
            if(empty($item['rabatdowydrukow']) || $item['rabatdowydrukow']=='')
            {
                $item['rabatdowydrukow']=0;
            }
                $abonament = (empty($item['abonament'])==true?0:$item['abonament']);
               
            $dataReports[$item['rowidclient']]['wartoscabonament']=$dataReports[$item['rowidclient']]['wartoscabonament']+$abonament;
                
           
            
            $stronblackpowyzej = 0;
            $wartoscblacktemp = 0;
            $wartoscblack = 0;
            $dataReports[$item['rowidclient']]['wartoscblack'] = $dataReports[$item['rowidclient']]['wartoscblack']+$wartoscblack;
            
            $stronkolorpowyzej =0;
            $wartosckolortemp =0;
            $wartosckolor = 0;
            $dataReports[$item['rowidclient']]['wartosckolor'] = 0;
            $wartosc= $abonament+
                                    $wartoscblack+
                                            $wartosckolor+
                                                $oplatainstalacyjna;;
            $dataReports[$item['rowidclient']]['wartosc'] = 
                    $dataReports[$item['rowidclient']]['wartosc']+
                           $abonament+
                                    $wartoscblack+
                                            $wartosckolor+
                                                $oplatainstalacyjna;;
            $dataReports['suma'] = 
                    $dataReports['suma']+
                            $abonament+
                                    $wartoscblack+
                                            $wartosckolor+
                                                $oplatainstalacyjna;;
            
            
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['nrumowy'] = $item['nrumowy'];
          $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['serial'] = $item['serial'];
          $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['model'] = $item['model'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['stronwabonamencie'] = $item['stronwabonamencie'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['cenazastrone'] = $item['cenazastrone'];
             $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['oplatainstalacyjna'] = $oplatainstalacyjna;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['iloscstron_kolor'] = $item['iloscstron_kolor'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['cenazastrone_kolor'] = $item['cenazastrone_kolor'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['rozliczenie'] = $item['rozliczenie'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['wartoscabonament'] = $abonament;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['wartoscblack'] = $wartoscblack;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['wartosckolor'] = $wartosckolor;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['stronblackpowyzej'] = $stronblackpowyzej;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['stronkolorpowyzej'] = $stronkolorpowyzej;
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['wartosc'] = $wartosc;
             $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_black_start'] = $item['strony_black_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['data_wiadomosci_black_start'] = $item['data_wiadomosci_black_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_black_koniec'] = $item['strony_black_koniec'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['data_wiadomosci_black_koniec'] = $item['data_wiadomosci_black_koniec'];
            
             $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_kolor_start'] = $item['strony_kolor_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['data_wiadomosci_kolor_start'] = $item['data_wiadomosci_kolor_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_kolor_koniec'] = $item['strony_kolor_koniec'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['data_wiadomosci_kolor_koniec'] = $item['data_wiadomosci_kolor_koniec'];

            // device localization
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_ulica'] = $item['lokalizacja_ulica'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_miasto'] = $item['lokalizacja_miasto'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_kodpocztowy'] = $item['lokalizacja_kodpocztowy'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_telefon'] = $item['lokalizacja_telefon'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_mail'] = $item['lokalizacja_mail'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['lokalizacja_nazwa'] = $item['lokalizacja_nazwa'];
        }
        
         global $smarty;
       $smarty->assign('dataReports',$dataReports);
       unset($dataReports);   
       
       

   }
}
