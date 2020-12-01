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
            echo json_encode(
                $this->getInvoicesByDateRange($_POST['period'], $_POST['date_from'], $_POST['date_to'])
            );
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getnotpaidinvoices() {
        if ($_POST['period'] && $_POST['date_from'] && $_POST['date_to']) {
            echo json_encode(
                $this->getNotPaidInvoicesByDateRange($_POST['period'], $_POST['date_from'], $_POST['date_to'])
            );
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getinvoicesbyclientid() {
        if ($_POST['client_id'] && $_POST['is_paid']) {
            echo json_encode(
                $this->geInvoicesByClientId($_POST['client_id'], ($_POST['is_paid'] === 'true') ? true : false)
            );
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getpayments() {
        if ($_POST['client_id'] && $_POST['date_from']) {
            echo json_encode($this->getClientPayments($_POST['client_id'], $_POST['date_from']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }
    function getoverpaidpayments() {
        if (isset($_POST['client_id'])) {
            echo json_encode($this->getAllOverpaidPayments($_POST['client_id']));
        } else {
            echo json_encode($this->getAllOverpaidPayments());
        }
    }

    function addinvoicepayment() {
        if ($_POST['price'] && $_POST['invoice_id'] && $_POST['invoice_tax_no'] && $_POST['client_id'] && $_POST['paid_name'] && $_POST['paid_date']) {
            echo json_encode(
                $this->addPayment(
                    $_POST['price'],
                    $_POST['invoice_id'],
                    $_POST['client_id'],
                    $_POST['invoice_tax_no'],
                    $_POST['paid_name'],
                    $_POST['paid_date'],
                    $this->normalizeCurrencyValue($_POST['price'])
                )
            );
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function addpaymentclientmessage() {
        if ($_POST['client_nip'] && $_POST['message_date'] && $_POST['message']) {
            echo $this->clientinvoice->addPaymentMessage($_POST, 'payments_messages');
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function removeclientmessage() {
        if ($_POST['rowid']) {
            echo $this->clientinvoice->removePaymentMessage($_POST['rowid']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getpaymentclientmessages() {
        if ($_POST['client_nip']) {
            echo $this->clientinvoice->getPaymentMessages($_POST['client_nip']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function splitclientpayments() {
        if (isset($_POST['client_id'])) {
            echo $this->splitPayments($_POST['client_id']);
        } else {
            echo "clientId is required";
        }
    }

    function deleteinvoicepayment() {
        if ($_POST['payment_id']) {
            echo json_encode($this->deletePaymentById($_POST['payment_id']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function updateinvoicepayment() {
        if ($_POST['payment_id'] && $_POST['price']) {
            echo json_encode($this->updatePaymentById($_POST['payment_id'], $_POST['price']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }
}
