<?php
class logsController extends Controller 
{  
   function showdane()
   {
       global $smarty;
       $this->printer->populateWithPost();
       $dataLogs = $this->log->getLogs();
       $smarty->assign('dataLogs',$dataLogs);
       unset($dataLogs);
   }
}
