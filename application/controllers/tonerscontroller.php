<?php
class tonersController extends Controller 
{  
   function delete()
   {
       if($_POST['stronkoniec']=='')
       {
           echo('Uzupełnij ilość stron');
           die();
       }
       else
            echo(json_encode($this->toner->delete($_POST['rowid'],$_POST['typ'],$_POST['stronkoniec'])));   
   } 
   function saveupdate()
   {
       
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {
            
            if($_POST['serial']=='')
                die('Uzupełnij serial');
            if($_POST['serialdrukarka']=='')
                die('Uzupełnij drukarkę');
            if($_POST['typ']=='')
                die('Wybierz typ tonera');
            if($_POST['datainstalacji']=='')
                die('Uzupełnij datę instalacji');
            $this->toner->populateWithPost();
            echo(json_encode($this->toner->saveupdate()));
        }
        else 
        {
                echo('Błędne wywołanie');
        }
   }
   function addedit()
   {
       
       global $smarty;
       if($_POST['rowid']!='')
       {
            $dataToner = $this->toner->getTonerByRowid($_POST['rowid'],$_POST['typ']);
            $smarty->assign('dataToner',$dataToner );
            unset($dataToner);
            $smarty->assign('rowid',$_POST['rowid']);
       }
       
       $printer = new printer();
       $dataPrinters = $printer->getPrinters();
       unset($printer);
       $smarty->assign('dataPrinters',$dataPrinters);
       unset($dataPrinters);
       
   }
   function showdane()
   {
       global $smarty;
       $this->toner->populateWithPost();
       $dataToners = $this->toner->getToners();
       $smarty->assign('dataToners',$dataToners);
       if(isset($_POST['czyhistoria']))
        $smarty->assign('czyhistoria',$_POST['czyhistoria']);
       unset($dataToners);
   }
}
