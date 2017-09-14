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

   function groupByAgreement($reports) {
       $result = array();

       foreach($reports as $report) {
           if (!isset($result[$report['rowidumowa']])) {
               $result[$report['rowidumowa']] = $report;
               $result[$report['rowidumowa']]['serials'] = array($report['serial']);
           } else {
               if ($report['serial'] == $report['currentserial']) {
                   $tmpReport = $report;
                   $report = $result[$report['rowidumowa']];
                   $result[$report['rowidumowa']] = $tmpReport;

                   $result[$report['rowidumowa']]['serials'] = array($result[$report['rowidumowa']]['serial']);

               }
               $result[$report['rowidumowa']]['strony_black_koniec'] = array_merge($result[$report['rowidumowa']]['strony_black_koniec'], $report['strony_black_koniec']);
               $result[$report['rowidumowa']]['strony_black_start'] = array_merge($result[$report['rowidumowa']]['strony_black_start'], $report['strony_black_start']);
               $result[$report['rowidumowa']]['strony_kolor_koniec'] = array_merge($result[$report['rowidumowa']]['strony_kolor_koniec'], $report['strony_kolor_koniec']);
               $result[$report['rowidumowa']]['strony_kolor_start'] = array_merge($result[$report['rowidumowa']]['strony_kolor_start'], $report['strony_kolor_start']);

               $result[$report['rowidumowa']]['data_wiadomosci_black_koniec'] = array_merge($result[$report['rowidumowa']]['data_wiadomosci_black_koniec'], $report['data_wiadomosci_black_koniec']);
               $result[$report['rowidumowa']]['data_wiadomosci_black_start'] = array_merge($result[$report['rowidumowa']]['data_wiadomosci_black_start'], $report['data_wiadomosci_black_start']);
               $result[$report['rowidumowa']]['data_wiadomosci_kolor_koniec'] = array_merge($result[$report['rowidumowa']]['data_wiadomosci_kolor_koniec'], $report['data_wiadomosci_kolor_koniec']);
               $result[$report['rowidumowa']]['data_wiadomosci_kolor_start'] = array_merge($result[$report['rowidumowa']]['data_wiadomosci_kolor_start'], $report['data_wiadomosci_kolor_start']);

               $result[$report['rowidumowa']]['strony_black_sum'] += ($report['strony_black_sum']);
               $result[$report['rowidumowa']]['strony_kolor_sum'] += ($report['strony_kolor_sum']);

               $result[$report['rowidumowa']]['serials'][] = $report['serial'];
           }
       }

       return $result;
   }

   function applySerivice($reports, $service) {
        $result = array();

        foreach($reports as $report) {

            if (isset($service[$report['serial']])) {

                $srvs = $service[$report['serial']];

                $result[$report['serial']] = $report;

                $result[$report['serial']]['strony_black_koniec'] = array();
                $result[$report['serial']]['strony_black_start'] = array($report['strony_black_start']);
                $result[$report['serial']]['strony_kolor_koniec'] = array();
                $result[$report['serial']]['strony_kolor_start'] = array($report['strony_kolor_start']);

                $result[$report['serial']]['data_wiadomosci_black_koniec'] = array();
                $result[$report['serial']]['data_wiadomosci_black_start'] = array($report['data_wiadomosci_black_start']);
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'] = array();
                $result[$report['serial']]['data_wiadomosci_kolor_start'] = array($report['data_wiadomosci_kolor_start']);

                $result[$report['serial']]['serials'] = array($report['serial']);
                foreach($srvs as $srv) {
                    $result[$report['serial']]['strony_black_koniec'][] = $srv['ilosc_koniec'];
                    $result[$report['serial']]['strony_black_start'][] = $srv['ilosc_start'];
                    $result[$report['serial']]['strony_kolor_koniec'][] = $srv['ilosc_kolor_koniec'];
                    $result[$report['serial']]['strony_kolor_start'][] = $srv['ilosc_kolor_start'];

                    $result[$report['serial']]['data_wiadomosci_black_koniec'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_black_start'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_kolor_koniec'][] = $srv['date'];
                    $result[$report['serial']]['data_wiadomosci_kolor_start'][] = $srv['date'];

                    $result[$report['serial']]['serials'][] = $report['serial'];
                }
                $result[$report['serial']]['strony_black_koniec'][] = $report['strony_black_koniec'];
                $result[$report['serial']]['strony_kolor_koniec'][] = $report['strony_kolor_koniec'];

                $result[$report['serial']]['data_wiadomosci_black_koniec'][] = $report['data_wiadomosci_black_koniec'];
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'][] = $report['data_wiadomosci_kolor_koniec'];

                $result[$report['serial']]['strony_black_sum'] = 0;
                $result[$report['serial']]['strony_kolor_sum'] = 0;
                for($i=0; $i < count($result[$report['serial']]['strony_black_koniec']); $i++) {
                    $result[$report['serial']]['strony_black_sum'] += $result[$report['serial']]['strony_black_koniec'][$i] - $result[$report['serial']]['strony_black_start'][$i];
                    $result[$report['serial']]['strony_kolor_sum'] += $result[$report['serial']]['strony_kolor_koniec'][$i] - $result[$report['serial']]['strony_kolor_start'][$i];
                }

            } else {
                $result[$report['serial']] = $report;
                $result[$report['serial']]['strony_black_koniec'] = array($report['strony_black_koniec']);
                $result[$report['serial']]['strony_black_start'] = array($report['strony_black_start']);
                $result[$report['serial']]['strony_kolor_koniec'] = array($report['strony_kolor_koniec']);
                $result[$report['serial']]['strony_kolor_start'] = array($report['strony_kolor_start']);

                $result[$report['serial']]['data_wiadomosci_black_koniec'] = array($report['data_wiadomosci_black_koniec']);
                $result[$report['serial']]['data_wiadomosci_black_start'] = array($report['data_wiadomosci_black_start']);
                $result[$report['serial']]['data_wiadomosci_kolor_koniec'] = array($report['data_wiadomosci_kolor_koniec']);
                $result[$report['serial']]['data_wiadomosci_kolor_start'] = array($report['data_wiadomosci_kolor_start']);

                $result[$report['serial']]['strony_black_sum'] = $report['strony_black_koniec'] - $report['strony_black_start'];
                $result[$report['serial']]['strony_kolor_sum'] = $report['strony_kolor_koniec'] - $report['strony_kolor_start'];

                $result[$report['serial']]['serials'] = array($report['serial']);
            }
        }

        return $result;
   }

   function getPrinterServiceMap($arrPrinterService) {
       $result = array();

       foreach ($arrPrinterService as $service) {
        if (!isset($result[$service['serial']])) {
            $result[$service['serial']] = array($service);
        } else {
            $result[$service['serial']][] = $service;
        }
       }

       return $result;
   }
    function showdaneklient()
   {
  
       $this->report->populateWithPost();
       $dataReportsMiesieczne = $this->report->getReportsMiesieczne();
       $dataReportsRoczne = $this->report->getReportsRoczne();
       $dataPrinterService = $this->getPrinterServiceMap($this->report->getPrinterService());

       $dataReportsMiesieczne = $this->applySerivice($dataReportsMiesieczne, $dataPrinterService);
       // $dataReportsMiesieczne = $this->groupByAgreement($dataReportsMiesieczne);

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

            for ($i = 0; $i < count($item['strony_black_koniec']); $i++) {
                if ($item['strony_black_koniec'][$i] == 0 && $item['strony_black_start'][$i] == 0) {
                    $dataReports[$item['rowidclient']]['blad'] = 1;
                    $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['blad'] = 1;
                }
                if (($item['strony_black_koniec'][$i] - $item['strony_black_start'][$i]) < 0) {
                    $dataReports[$item['rowidclient']]['blad'] = 1;
                    $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['blad'] = 1;
                }
                if (($item['strony_kolor_koniec'][$i] - $item['strony_kolor_start'][$i]) < 0) {
                    $dataReports[$item['rowidclient']]['blad'] = 1;
                    $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['blad'] = 1;
                }
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
                $stronwsumie = ($item['strony_black_sum'])+($item['strony_kolor_sum']);
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
                $stronblackpowyzej = $item['strony_black_sum']-$item['stronwabonamencie'];
                $stronblackpowyzej = $stronblackpowyzej < 0 ? 0: $stronblackpowyzej;
                $stronblackpowyzej = round($stronblackpowyzej);
                $wartoscblacktemp = $stronblackpowyzej*(empty($item['cenazastrone'])?0:$item['cenazastrone']);
                $wartoscblack = ($wartoscblacktemp - ($wartoscblacktemp*($item['rabatdowydrukow']/100)));
                $dataReports[$item['rowidclient']]['wartoscblack'] = $dataReports[$item['rowidclient']]['wartoscblack']+$wartoscblack;
                
                $stronkolorpowyzej =(($item['strony_kolor_sum'])-$item['iloscstron_kolor'])<0?0:(($item['strony_kolor_sum'])-$item['iloscstron_kolor']);
                $stronkolorpowyzej = $stronkolorpowyzej < 0 ? 0: $stronkolorpowyzej;
                
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

            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_black_sum'] = $item['strony_black_sum'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_kolor_sum'] = $item['strony_kolor_sum'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['serials'] = $item['serials'];

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

            // TODO: this is temporary solution, this should be also updated with the same code as for month agreements
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_black_sum'] = $item['strony_black_koniec'] - $item['strony_black_start'];
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['strony_kolor_sum'] = $item['strony_kolor_koniec'] - $item['strony_kolor_start'];
            // TODO: this probably wont work
            $dataReports[$item['rowidclient']]['umowy'][$item['rowidumowa']]['serials'] = array($item['serial']);

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
