<?php
class profitabilityController extends InvoicesController
{  
    function show()
    {
        global $smarty;
        global $months;
        $smarty->assign('months',$months );
        $smarty->assign('rok',date("Y"));

        $smarty->assign('fakturownia_conf_file_path', ROOT . DS . 'config' . DS . 'fakturownia.conf');
    }

    function getagreementnotifications() {
        if ($_POST['date_from'] && $_POST['date_to'] && $_POST['rowagreement_id']) {
            echo $this->profitability->getAgreementNotifications($_POST['date_from'], $_POST['date_to'], $_POST['rowagreement_id']);
        } else {
            echo "blędne parametry wejściowe";
        }
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
            echo json_encode($this->getInvoicesByDateRange($_POST['period'], $_POST['date_from'], $_POST['date_to']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }

}
