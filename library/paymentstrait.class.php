<?php

trait PaymentsTrait
{
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

        $newPayment = json_decode(curl_exec($ch), true);

        curl_close($ch);

        $splitPayments = array();
        if (floatval($newPayment['overpaid']) > 0) {
            $splitPayments = $this->splitPayments($clientId);
        }

        return array_merge(array($newPayment), $splitPayments);
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
    function getClientPayments($clientId, $dateFrom, $dateTo = null, int $perPage = 100)
    {
        $payments = array();

        $tz = new DateTimeZone('Europe/Warsaw');
        $to = $dateTo
            ? new DateTimeImmutable($dateTo, $tz)
            : new DateTimeImmutable('today', $tz);
        $apiDateTo = $to->modify('-1 day')->format('Y-m-d');

        if (empty($dateTo)) {
            $dateTo = date('Y-m-d');
        }

        $ch = curl_init();
        $pageNb = 1;
        $url = FAKTUROWNIA_ENDPOINT . '/banking/payments.json?'
            . 'client_id=' . $clientId
            . '&date_from=' . $dateFrom
            . '&date_to=' . $apiDateTo
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        do {
            curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb . '&per_page=' . $perPage);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if (USE_PROXY) {
                curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
            }
            $data = json_decode(curl_exec($ch), true);

            $payments = array_merge($payments, $data);
            $pageNb++;
        } while (count($data) == $perPage);

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
    function splitPayment($invoices, $payment)
    {

        $allNewPayments = array();
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

                $newPayments = $this->addPayment(
                    $leftToPay,
                    $invoice['id'],
                    $invoice['client_id'],
                    $invoice['buyer_tax_no'],
                    'rozksiegowanie - (automatyczna)',
                    $paidDate,
                    ''
                );
                $allNewPayments = array_merge($newPayments, $allNewPayments);

                $overpaid -= $leftToPay;

                $idx++;
            } while ($overpaid > 0 && $idx < count($invoices));


        }

        return $allNewPayments;
    }
}