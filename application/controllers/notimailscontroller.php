<?php
class notimailsController extends Controller 
{
   
   function show()
   {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
          {
       global $smarty;
          $this->notimail->populateWithPost();
          $dateEmail = $this->notimail->getDanePrzypisane();
          $smarty->assign('dateEmail',$dateEmail);
          unset($dateEmail);
          }
          else
          {
             header('Location: /');
          }
   }
    function neweditmail() {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
          {
                global $smarty;
               
                $noti = new notification();
                $daneNoti = $noti->getNotificationByRowid2($_POST['noti_rowid']);
                $smarty->assign('daneNoti',$daneNoti);
                $smarty->assign('czyedit',$_POST['czyedit']);
                $smarty->assign('noti_rowid',$_POST['noti_rowid']);
                $smarty->assign('replyrowid',$_POST['replyrowid']);
                $smarty->assign('uniqueid',getUniqueIdNumber());getMailByRowid
                
                
                unset($noti);
                
                if(isset($_POST['replyrowid']) && (string)$_POST['replyrowid']!='' && $_POST['replyrowid']!=0)
                {
                    $daneReply = $this->notimail->getMailByRowid($_POST['replyrowid']);
                    $smarty->assign('daneReply',$daneReply);
                    unset($daneReply);
                }
                
          }
          else
          {
                 header("Location: /");
          }
    }
    function wyslijmail()
    {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
          {
        if($_POST['temat']=='')
        {
            echo('Uzupełnij pole "temat');
            die();
        }
        if($_POST['tresc']=='')
        {
            echo('Uzupełnij pole "tresc');
            die();
        }
        if($_POST['mail']=='')
        {
            echo('Uzupełnij pole "mail');
            die();
        }
        if($_POST['noti_rowid']=='')
        {
            echo('Brak tokenu');
            die();
        }
            
            if($_POST['replyrowid']=='0')
            {
                $czy = strpos($_POST['temat'], "[Ticket#");
                if($czy==false)
                    $_POST['temat'] = "[Ticket#".$_POST['noti_rowid']."] ".$_POST['temat'];
            }
        
            
            
            
            
            
                     if (strpos($_POST['tresc'],'----------------------------------------') !== false) {
                   
                   
                           
                           $arr = explode('----------------------------------------',$_POST['tresc']);
                           
                           $_POST['tresc'] = 
$arr[0].
"
Pozdrawiamy,
Otus Sp. z o.o.
+48 71 321 19 06
<a href='http://www.otus.pl'>www.otus.pl</a>
<img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0' height='82' width='150'></img>
<br/><br/>
".
$arr[1]
                            ;
                   }
                   else
                   {
$_POST['tresc'] = $_POST['tresc'].
"
Pozdrawiamy,
Otus Sp. z o.o.
+48 71 321 19 06
<a href='http://www.otus.pl'>www.otus.pl</a>
<img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0' height='82' width='150'></img>
<br/><br/>
";
}
            
            
            
            
            $mailing = new mailing();
                 $mailing->sendNewMail(
                         $_POST['mail'],
                         nl2br($_POST['tresc']),
                        $_POST['temat'],
                         $_POST['zalaczniki']
                         );
                unset($mailing);
        
        
                
          $this->notimail->populateWithPost();
             echo(json_encode($this->notimail->savenewmail()));      
                
                
                
            }
          else
          {
                 header("Location: /");
          }     
        
    }
    
}