<?php
class agreementsController extends Controller 
{  
     function delete()
    {
        $this->agreement->populateWithPost();
        echo(json_encode($this->agreement->delete()));
    }
     function saveupdate()
    {

         if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
         {
              if($_POST['nrumowy']=='')
                 die('Wpisz numer umowy');
             if($_POST['serial']=='')
                 die('Wybierz drukarkę');
             if($_POST['rowidclient']=='')
                 die('Wybierz klienta');
           

             $this->agreement->populateWithPost();
             echo(json_encode($this->agreement->saveupdate()));
         }
         else 
         {
                 echo('Błędne wywołanie');
         }
    }
      function addedit()
     {
 if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
          {
         global $smarty;
         
         $client = new client();
         $dataClient = $client->getClients();
         
         $smarty->assign('dataClients',$dataClient);
         unset($client);unset($dataClient);

         $smarty->assign('prtcntrowid', 0);

         $smarty->assign('dataAgreementTypes', $this->agreement->getAgreementTypes());

         if($_POST['rowid']!='0')
         {
              $dataUmowa = $this->agreement->getUmowaByRowid($_POST['rowid']);
             $smarty->assign('dataUmowa', $dataUmowa);

              if (isset($dataUmowa[0])) {
                  $dataCounters = $this->agreement->getAgreementPrinterCounters($_POST['rowid'], $dataUmowa[0]['serial']);
              }
              if (isset($dataCounters) && count($dataCounters) > 0) {
                  $smarty->assign('prtcntrowid', $dataCounters[0]['rowid']);
                  $smarty->assign('dataCounters', $dataCounters);
              }

              $printer = new printer();
                $dataPrinters = $printer->getPrintersUmowaBezSerialu($dataUmowa[0]['serial']);

                $smarty->assign('dataPrinters',$dataPrinters);
                unset($printer);unset($dataPrinters); unset($dataUmowa);
         }
         else
         {
            $printer = new printer();
            $dataPrinters = $printer->getPrintersUmowa();
            $smarty->assign('dataPrinters',$dataPrinters);
            
            unset($printer);unset($dataPrinters);
         }
         $smarty->assign('rowid',$_POST['rowid']);
          }
          else
          {
                 header("Location: /");
          }
     }

   function getAgreementPrinterCounters() {
         if (isset($_POST['rowid']) && isset($_POST['serial'])) {
             $result = $this->agreement->getAgreementPrinterCounters($_POST['rowid'], $_POST['serial']);
             if (isset($result) && count($result) > 0) {
                 echo json_encode($result[0]);
             }
         }
   }

   function showdane()
   {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
          {
       global $smarty;
       $this->agreement->populateWithPost();
       $dataAgreements = $this->agreement->getAgreements();
       $smarty->assign('dataAgreements',$dataAgreements);
       $smarty->assign('czycolorbox', isset($_POST['czycolorbox']) ? $_POST['czycolorbox'] : '');
       unset($dataAgreements);
        }
          else
          {
                 header("Location: /");
          }
   }
      function showdane2()
   {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
          {
       global $smarty;
       $this->agreement->populateWithPost();
       $dataAgreements = $this->agreement->getAgreements();
       $smarty->assign('dataAgreements',$dataAgreements);
       $smarty->assign('czycolorbox',$_POST['czycolorbox']);
       unset($dataAgreements);
        }
          else
          {
                 header("Location: /");
          }
   }
       function show()
   {
           
       global $smarty;
       if(isset($_POST['czycolorbox']))
       {
           $smarty->assign('clientnazwakrotka',$_POST['clientnazwakrotka']);
           $smarty->assign('serial',$_POST['serial']);
           $smarty->assign('czycolorbox','1');
       }
       else
           $smarty->assign('czycolorbox','');
     
   }
    function show2()
   {
         if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
          {
       global $smarty;
       if(isset($_POST['czycolorbox']))
       {
           $smarty->assign('clientnazwakrotka',$_POST['clientnazwakrotka']);
           $smarty->assign('serial',$_POST['serial']);
           $smarty->assign('czycolorbox','1');
       }
       else
           $smarty->assign('czycolorbox','');
        }
          else
          {
                 header("Location: /");
          }
   }
}
