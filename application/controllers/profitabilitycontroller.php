<?php
class profitabilityController extends Controller
{  
    function show()
    {
        global $smarty;
        global $months;
        $smarty->assign('months',$months );
        $smarty->assign('rok',date("Y"));

        $smarty->assign('fakturownia_conf_file_path', ROOT . DS . 'config' . DS . 'fakturownia.conf');
    }

    function getoveralcosts() {
        if ($_POST['date_from'] && $_POST['date_to']) {
            echo $this->profitability->getOveralCosts($_POST['date_from'], $_POST['date_to']);
        } else {
            echo "blędne parametry wejściowe";
        }
    }

    function getinvoices() {
       if ($_POST['period'] && $_POST['date_from'] && $_POST['date_to']) {
           echo $this->profitability->getInvoices($_POST['period'], $_POST['date_from'], $_POST['date_to']);
       } else {
           echo "błędne parametry wejściowe";
       }
    }

}
