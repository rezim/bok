<?php
class clientinvoicesController extends InvoicesController
{  
    function show()
    {
        global $smarty;
        global $months;
        $smarty->assign('months',$months );
        $smarty->assign('rok',date("Y"));

        $smarty->assign('fakturownia_conf_file_path', ROOT . DS . 'config' . DS . 'fakturownia.conf');
    }

    function getagreements() {
        echo $this->clientinvoice->getAgreements();
    }


    function getinvoices() {
        if ($_POST['period'] && $_POST['date_from'] && $_POST['date_to']) {
            echo $this->getInvoicesByDateRange($_POST['period'], $_POST['date_from'], $_POST['date_to']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getpayments() {
        if ($_POST['client_id'] && $_POST['date_from']) {
            echo $this->getClientPayments($_POST['client_id'], $_POST['date_from']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }
    function getoverpaidpayments() {
        echo $this->getAllOverpaidPayments();
    }

    function addinvoicepayment() {
        if ($_POST['price'] && $_POST['invoice_id'] && $_POST['invoice_tax_no'] && $_POST['client_id'] && $_POST['paid_name'] && $_POST['paid_date']) {
            echo $this->addPayment(
                $_POST['price'],
                $_POST['invoice_id'],
                $_POST['client_id'],
                $_POST['invoice_tax_no'],
                $_POST['paid_name'],
                $_POST['paid_date'],
                $_POST['description']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function deleteinvoicepayment() {
        if ($_POST['payment_id']) {
            echo $this->deletePaymentById($_POST['payment_id']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }
}
