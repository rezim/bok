<?php
class printersController extends Controller 
{  
    
    
   function logi()
   {
       global $smarty;
       $dataLogi = $this->printer->getLogi($_POST['serial']);
       $smarty->assign('dataLogi',$dataLogi);
       unset($dataLogi);
   }
   function showdane()
   {
       global $smarty;
       $this->printer->populateWithPost();
       $dataPrinters = $this->printer->getPrinters();
       $smarty->assign('dataPrinters',$dataPrinters);
         $smarty->assign('czycolorbox',$_POST['czycolorbox']);
       unset($dataPrinters);
   }
    function delete()
   {
          $umowa = new agreement();
        $dane = $umowa->getUmowaByPrinter($_POST['serial']);
        unset($umowa);
        if(count($dane)!=0) 
        {
            echo('Ta drukarka jest przypisana do umowy  najpierw usuń umowę.');
        }
        else
            echo(json_encode($this->printer->delete($_POST['serial'])));   
   }
   function addedit()
   {
       
       global $smarty;
       if($_POST['serial']!='')
       {
            $dataPrinter = $this->printer->getPrinterBySerial($_POST['serial']);
            $smarty->assign('dataPrinter',$dataPrinter );
            unset($dataPrinter);
       }
       $smarty->assign('serial',$_POST['serial']);
   }
   function saveupdate()
   {
       
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {
            
            if($_POST['serial']=='')
                die('Uzupełnij serial');
            if($_POST['model']=='')
                die('Uzupełnij model');
            
            
            $this->printer->populateWithPost();
            echo(json_encode($this->printer->saveupdate()));
        }
        else 
        {
                echo('Błędne wywołanie');
        }
   }
   function savestanna()
   {
       
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {
            
            if($_POST['serial']=='')
                die('Uzupełnij serial');
            if($_POST['stanna']=='')
                die('Wybierz datę na którą ma być wpisane');
            if($_POST['iloscstron']!='' && !validatesAsInt(str_replace(' ','',$_POST['iloscstron'])))
                die('Wpisz poprawną ilość toner czarny');
            if($_POST['iloscstron_kolor']!='' && !validatesAsInt(str_replace(' ','',$_POST['iloscstron_kolor'])))
                die('Wpisz poprawną ilość toner kolorowy');
            
            
            $this->printer->populateWithPost();
            echo(json_encode($this->printer->savestanna()));
        }
        else 
        {
                echo('Błędne wywołanie');
        }
   }
      function show()
   {
       global $smarty;
       if(isset($_POST['czycolorbox']))
       {
           $smarty->assign('clientnazwakrotka',$_POST['clientnazwakrotka']);
           $smarty->assign('czycolorbox','1');
       }
       else
           $smarty->assign('czycolorbox','');
       
   }
}
