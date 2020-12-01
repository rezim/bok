<?php

class InvoicesController extends Controller
{

    function __construct($model, $controller, $action, $queryString)
    {
        parent::__construct($model, $controller, $action, $queryString);
    }

    function __destruct()
    {
        parent::__destruct();
    }

    function getClientByTaxNo($clientTaxNo)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/clients.json?'
            . 'tax_no=' . $clientTaxNo
            . '&api_token=' . FAKTUROWNIA_APITOKEN;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        $client = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return $client;
    }

    function geInvoicesByClientId($clientId, $isPaid)
    {
        $invoices = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'client_id=' . $clientId
            . '&status=' . (($isPaid) ? 'paid' : 'not_paid')
            . '&order=issue_date'
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $invoices = array_merge($invoices, $data);
            $pageNb++;
        } while (count($data) == 50);

        curl_close($ch);

        return $invoices;
    }

    function getInvoicesByDateRange($period, $dateFrom, $dateTo)
    {

        $max_multi_calls_count = 50;

        $invoices = array();

        $curl_arr = array();
        $mh = curl_multi_init();

        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'period=' . $period
            . '&date_from=' . $dateFrom
            . '&date_to=' . $dateTo
            . '&api_token=' . FAKTUROWNIA_APITOKEN;

        do {
            for ($i = 0; $i < $max_multi_calls_count; $i++) {

                $curl_arr[$i] = curl_init($url . '&page=' . $pageNb);
                curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
                if (USE_PROXY) {
                    curl_setopt($curl_arr[$i], CURLOPT_PROXY, '127.0.0.1:8888');
                }
                curl_multi_add_handle($mh, $curl_arr[$i]);

                $pageNb++;
            }

            do {
                $status = curl_multi_exec($mh, $running);
            } while ($running > 0 && $status === CURLM_OK);


            if ($status === CURLM_OK) {
                for ($i = 0; $i < $max_multi_calls_count; $i++) {
                    $results[] = curl_multi_getcontent($curl_arr[$i]);

                    curl_multi_remove_handle($mh, $curl_arr[$i]);

                    $data = json_decode(curl_multi_getcontent($curl_arr[$i]), true);

                    $invoices = array_merge($invoices, $data);
                }
            }
        } while (count($invoices) === ($pageNb - 1) * 50 && $status === CURLM_OK);

        curl_multi_close($mh);

        return ($status === CURLM_OK) ? $invoices : $status;
    }


    function getNotPaidInvoicesByDateRange($period, $dateFrom, $dateTo)
    {
        $invoices = $this->getInvoicesByDateRange($period, $dateFrom, $dateTo);

        if (!(is_array($invoices))) {
            // $invoices is a status of error return from getInvoicesByDateRange()
            return $invoices;
        }

        foreach ($invoices as $key => $element) {
            // remove paid invoices
            if ($element["paid"] === $element["price_gross"]) {
                unset($invoices[$key]);
            }
        }

        $keys_to_remove = ["view_url", "warehouse_id", "token"];
        foreach ($keys_to_remove as $key) {
            array_walk($invoices, function (&$v) use ($key) {
                unset($v[$key]);
            });
        }

        return $invoices;
    }


    function addPayment($price, $invoiceId, $clientId, $invoiceTaxNo, $name, $paidDate, $description)
    {

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
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if (floatval($result['overpaid']) > 0) {
            $this->splitPayments($clientId);
        }

        return $result;
    }

    function updatePaymentById($paymentId, $price)
    {

        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments/' . $paymentId . '.json?';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "banking_payment" => array(
                "price" => $price
            )
        );
        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }


    public function deletePaymentById($paymentId)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments/' . $paymentId . '.json?'
            . 'api_token=' . FAKTUROWNIA_APITOKEN;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    function getClientPayments($clientId, $dateFrom)
    {
        $payments = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments.json?'
            . 'client_id=' . $clientId
            . '&date_from=' . $dateFrom
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $payments = array_merge($payments, $data);
            $pageNb++;
        } while (count($data) == 50);

        curl_close($ch);

        return $payments;
    }

    function getAllOverpaidPayments($clientId = null)
    {
        $payments = array();

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments.json?'
            . 'status=overpaid'
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        if ($clientId) {
            $url .= '&client_id=' . $clientId;
        }
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $payments = array_merge($payments, $data);
            $pageNb++;
        } while (count($data) == 50);

        curl_close($ch);

        return $payments;
    }

    function splitPayments($clientId)
    {

        $overPaidPayments = $this->getAllOverpaidPayments($clientId);

        foreach ($overPaidPayments as $payment) {
            $notPaidInvoices = $this->geInvoicesByClientId($clientId, false);

            if (count($notPaidInvoices) > 0) {
                $this->splitPayment($notPaidInvoices, $payment);
            }
        }

        return 'OK';
    }

    // split single payment
    function splitPayment($invoices, $payment)
    {
        if (count($invoices) > 0 && $payment) {
            $overpaid = $payment['overpaid'];
            $paidDate = $payment['paid_date'];
            $this->updatePaymentById(
                $payment['id'],
                floatval($payment['price']) - floatval($payment['overpaid'])
            );

            $idx = 0;
            do {
                $invoice = $invoices[$idx];
                $leftToPay = floatval($invoice['price_gross']) - floatval($invoice['paid']);

                // if not enough overpaid for the invoice or it is last invoice,
                // pay all remaining many
                if ($leftToPay > $overpaid || $idx === count($invoices) - 1) {
                    $leftToPay = $overpaid;
                }

                $this->addPayment(
                    $leftToPay,
                    $invoice['id'],
                    $invoice['client_id'],
                    $invoice['buyer_tax_no'],
                    'rozksiegowanie',
                    $paidDate,
                    ''
                );

                $overpaid -= $leftToPay;

                $idx++;
            } while ($overpaid > 0 && $idx < count($invoices));
        }
    }

    function normalizeCurrencyValue($value)
    {
        return str_replace(',', '.', $value);
    }
}