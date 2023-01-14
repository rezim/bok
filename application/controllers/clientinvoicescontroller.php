<?php

class clientinvoicesController extends InvoicesController
{
    function show()
    {
        global $smarty;
        global $months;
        $smarty->assign('months', $months);
        $smarty->assign('rok', date("Y"));

        $smarty->assign('fakturownia_conf_file_path', ROOT . DS . 'config' . DS . 'fakturownia.conf');
    }

    function getagreements()
    {
        echo $this->clientinvoice->getAgreements();
    }


    function getinvoices()
    {
        if ($_POST['period'] && $_POST['date_from'] && $_POST['date_to']) {
            $filters = '';
            if (isset($_POST['filters'])) {
                $filters = $_POST['filters'];
            }
            echo json_encode(
                $this->getInvoicesByDateRange($_POST['period'], $_POST['date_from'], $_POST['date_to'], $filters)
            );
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function sendpaimentreminder()
    {
        if (!$_POST['client_id'] || !$_POST['client_nip'] || !$_POST['client_email']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "blędne parametery wejściowe";
            return;
        }

        try {
            // send all not paid invoices //$this->getOverdueInvoicesByClientId($_POST['client_id']);
            $clientOverdueInvoices = array_reverse($this->getInvoicesByClientId($_POST['client_id'], false));

            $clientInterestNotes = $this->resolveNotPaidInterestNotes($_POST['client_nip']);

            $clientEmail = $_POST['client_email'];

            $this->sendOverduePaymentsReminder($clientOverdueInvoices, $clientInterestNotes, $_POST['client_nip'], $clientEmail);

            echo "OK";
        } catch(Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo $e->getMessage();
        }
    }

    function getnotpaidinvoices()
    {
        if ($_POST['period'] && $_POST['date_from'] && $_POST['date_to']) {

            $trackedDeptors = $this->clientinvoice->getTrackedDeptors();

            $invoices = $this->getNotPaidInvoicesByDateRange($_POST['period'], $_POST['date_from'], $_POST['date_to']);

            foreach ($invoices as $key => $element) {
                // remove invoices for not tracked clients
                if (array_search($element["buyer_tax_no"], array_column($trackedDeptors, 'nip')) === false) {
                    unset($invoices[$key]);
                }
            }

            echo json_encode($invoices);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getclientinvoices()
    {
        if ($_POST['client_id'] && $_POST['is_paid']) {
            echo json_encode(
                $this->getInvoicesByClientId($_POST['client_id'], ($_POST['is_paid'] === 'true') ? true : false)
            );
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getpayments()
    {
        if ($_POST['client_id'] && $_POST['date_from']) {
            echo json_encode($this->getClientPayments($_POST['client_id'], $_POST['date_from']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getoverpaidpayments()
    {
        if (isset($_POST['client_id'])) {
            echo json_encode($this->getAllOverpaidPayments($_POST['client_id']));
        } else {
            echo json_encode($this->getAllOverpaidPayments());
        }
    }

    function removeinvoicebyid()
    {
        $required = ['invoice_id'];
        if ($this->validatePostParams($required)) {
            echo json_encode($this->removeInvoice($_POST['invoice_id']));
        }
    }

    function addnewinvoice()
    {
        $required = ['kind', 'sell_date', 'issue_date', 'payment_to', 'buyer_name', 'buyer_tax_no',
            'buyer_email', 'buyer_post_code', 'buyer_city', 'buyer_street', 'positions',
            'show_discount', 'internal_note', 'additional_info', 'additional_info_desc'];

        if ($this->validatePostParams($required)) {
            echo json_encode(
                $this->addInvoice(
                    $_POST['kind'], $_POST['number'], $_POST['sell_date'], $_POST['issue_date'], $_POST['payment_to'], $_POST['buyer_name'],
                    $_POST['buyer_tax_no'], $_POST['buyer_email'], $_POST['buyer_post_code'], $_POST['buyer_city'], $_POST['buyer_street'],
                    $_POST['recipient_id'], $_POST['positions'], $_POST['show_discount'], $_POST['internal_note'], $_POST['additional_info'],
                    $_POST['additional_info_desc'], $_POST['bank'], $_POST['numer_rachunku'])
            );
        }
    }

    function addinvoicepayment()
    {
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

    function interestnotehasbeenpaid()
    {
        if ($_POST['nip'] && $_POST['name'] && $_POST['number'] && $_POST['date']) {
            echo json_encode($this->markInterestNoteAsPaid($_POST['nip'], $_POST['name'], $_POST['number'], $_POST['date']));
        } else {
            echo "błędne parametry wyjściowe";
        }
    }

    function removeinterestnote()
    {
        if ($_POST['nip'] && $_POST['name'] && $_POST['number'] && $_POST['date']) {
            echo json_encode($this->removeNotPaidInterestNote($_POST['nip'], $_POST['name'], $_POST['number'], $_POST['date']));
        } else {
            echo "błędne parametry wyjściowe";
        }
    }

    /**
     * getInterestNotes()
     * get interest notes by client NIP
     */
    function getinterestnotes()
    {
        if ($_POST['nip']) {
            echo json_encode($this->resolveInterestNotes($_POST['nip']));
        } else {
            echo "błędne parametry wyjściowe";
        }
    }

    function getallinterestnotes()
    {
        echo json_encode($this->resolveAllInterestNotes());
    }

    /**
     * addInterestNotesInvoice()
     *
     */
    function addinterestnotestoinvoice()
    {

        $required = ['invoice_id', 'nip'];

        if ($this->validatePostParams($required)) {

            if ($_POST['invoice_id'] && $_POST['nip']) {
                echo json_encode($this->addNotPaidInterestNotesToInvoice($_POST['invoice_id'], $_POST['nip']));
            } else {
                echo "błędne parametry wyjściowe";
            }

        }
    }

    function generateinterestnote()
    {
        if ($_POST['id'] && $_POST['number'] && $_POST['buyer_tax_no'] && $_POST['sell_date'] && $_POST['payment_to'] && $_POST['is_late_days']) {
            echo json_encode($this->issueInterestNote($_POST['id'], $_POST['number'], $_POST['buyer_tax_no'], $_POST['buyer_email'], $_POST['sell_date'], $_POST['payment_to'], $_POST['paid_date'], $_POST['is_late_days']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function addpaymentclientmessage()
    {
        if ($_POST['client_nip'] && $_POST['message_date'] && $_POST['message']) {
            echo $this->clientinvoice->addPaymentMessage($_POST, 'payments_messages');
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function removeclientmessage()
    {
        if ($_POST['rowid']) {
            echo $this->clientinvoice->removePaymentMessage($_POST['rowid']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function getpaymentclientmessages()
    {
        if ($_POST['client_nip']) {
            echo $this->clientinvoice->getPaymentMessages($_POST['client_nip']);
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function splitclientpayments()
    {
        if (isset($_POST['client_id'])) {
            echo $this->splitPayments($_POST['client_id']);
        } else {
            echo "clientId is required";
        }
    }

    function deleteinvoicepayment()
    {
        if ($_POST['payment_id']) {
            echo json_encode($this->deletePaymentById($_POST['payment_id']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }

    function updateinvoicepayment()
    {
        if ($_POST['payment_id'] && $_POST['price']) {
            echo json_encode($this->updatePaymentById($_POST['payment_id'], $_POST['price']));
        } else {
            echo "błędne parametry wejściowe";
        }
    }
}
