<?php

class InvoicesController extends Controller {

	function __construct($model, $controller, $action, $queryString) {
            parent::__construct($model, $controller, $action, $queryString);
	}

	function __destruct() {
        parent::__destruct();
	}

    function getInvoicesByDateRange($period, $dateFrom, $dateTo) {
        $invoices = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT .'/invoices.json?'
            .'period='.$period
            .'&date_from='.$dateFrom
            .'&date_to='.$dateTo
            .'&api_token='.FAKTUROWNIA_APITOKEN;
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $invoices = array_merge($invoices, $data);
            $pageNb++;
        } while(count($data) == 50);

        curl_close ($ch);

// // Filter example:
//        return json_encode(array_filter($invoices, function($value) {
//            return $value['paid_date'] === null;
//        }));

        return json_encode($invoices);
    }

    function addPayment($price, $invoiceId, $clientId, $invoiceTaxNo, $name, $paidDate, $description) {

        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments.json';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "banking_payment" => array(
                "name" => $name,
                "price" => $price,
                "invoice_id" => $invoiceId,
                "client_id" => $clientId,
                "invoice_tax_no" => $invoiceTaxNo,
                "paid_date" => $paidDate,
                "description" => $description,
                "paid" => true,
                "kind" => "api"
            )
        );
        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        curl_close ($ch);

        return json_encode($result);
    }


    public function deletePaymentById($paymentId)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments/' . $paymentId . '.json?'
            .'api_token='.FAKTUROWNIA_APITOKEN;

        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        $result = json_decode($result);

        curl_close($ch);

        return $result;
    }

    function getClientPayments($clientId, $dateFrom) {
        $payments = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT .'/banking/payments.json?'
            .'client_id='.$clientId
            .'&date_from='.$dateFrom
            .'&api_token='.FAKTUROWNIA_APITOKEN;
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $payments = array_merge($payments, $data);
            $pageNb++;
        } while(count($data) == 50);

        curl_close ($ch);

        return json_encode($payments);
    }

    function getAllOverpaidPayments() {
        $payments = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT .'/banking/payments.json?'
            .'status=overpaid'
            .'&api_token='.FAKTUROWNIA_APITOKEN;
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $payments = array_merge($payments, $data);
            $pageNb++;
        } while(count($data) == 50);

        curl_close ($ch);

        return json_encode($payments);
    }

}