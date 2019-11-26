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
        do {
            $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?period=' . $period . '&page='. $pageNb .'&date_from=' . $dateFrom . '&date_to=' . $dateTo . '&api_token=' . FAKTUROWNIA_APITOKEN;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $data = json_decode(curl_exec($ch), true);

            $invoices = array_merge($invoices, $data);
            $pageNb++;
        } while(count($data) == 50);

        curl_close ($ch);

        return json_encode(array_filter($invoices, function($value) {
            return $value['paid_date'] === null;
        }));
    }

}