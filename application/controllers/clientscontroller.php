<?php
class clientsController extends Controller 
{  
   
    
    
   function addedit()
   {
       
       global $smarty;
       if($_POST['rowid']!='0')
       {
            $dataClient = $this->client->getClientByRowid($_POST['rowid']);
            $smarty->assign('dataClient',$dataClient );
            unset($dataClient);
       }
       $smarty->assign('rowid',$_POST['rowid']);
   }
   function delete()
   {
       
        $umowa = new agreement();
        $dane = $umowa->getUmowaByClient($_POST['rowid']);
        unset($umowa);
        if(count($dane)!=0) 
        {
            echo('Ten klient jest przypisany do umowy  najpierw usuń umowę.');
        }
        else
            echo(json_encode($this->client->delete($_POST['rowid'])));   
   }
   function saveupdate()
   {
       
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {
            
            if($_POST['nazwakrotka']=='')
                die('Uzupełnij nazwę krótką');
            if($_POST['nazwapelna']=='')
                die('Uzupełnij nazwę pełną');
            if($_POST['nip']=='')
                die('Uzupełnij NIP');
            
            $this->client->populateWithPost();
            echo(json_encode($this->client->saveupdate()));
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
           $smarty->assign('czycolorbox','1');
           $smarty->assign('serial',$_POST['serial']);
       }
       else
           $smarty->assign('czycolorbox','');
   }
   function showdane()
   {
       global $smarty;
       $this->client->populateWithPost();
       $dataClient = $this->client->getClients();
       $smarty->assign('dataClient',$dataClient);
       $smarty->assign('czycolorbox', isset($_POST['czycolorbox']) ? $_POST['czycolorbox'] : '');
       unset($dataClient);
   }
}
