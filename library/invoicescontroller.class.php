<?php

class InvoicesController extends Controller
{
    use ExternalClientsTrait, PaymentsTrait, InterestNotesTrait, WarehouseTrait;

    function __construct($model, $controller, $action, $queryString)
    {
        parent::__construct($model, $controller, $action, $queryString);
    }

    function __destruct()
    {
        parent::__destruct();
    }

    function getAllInvoices($filters = null): array {
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'api_token=' . FAKTUROWNIA_APITOKEN
            . '&order=issue_date'
            . ($filters ? "&{$filters}" : "");

        return getResultsByUrlQuery($url);
    }

    function getInvoicesByClientId($clientId, $isPaid): array
    {
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'client_id=' . $clientId
            . '&status=' . (($isPaid) ? 'paid' : 'not_paid')
            . '&order=issue_date'
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        return getResultsByUrlQuery($url);
    }

    function getInvoicesByClientTaxNo($taxNo, $dateFrom, $dateTo): array
    {
        $clientId = $this->getClientIdByTaxNo($taxNo);

        if ($clientId === null) {
            return [];
        }

        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'period=more'
            . '&date_from=' . $dateFrom
            . '&date_to=' . $dateTo
            . '&client_id=' . $clientId
            . 'search_date_type=issue_date'
            . '&order=issue_date.desc'
            . '&api_token=' . FAKTUROWNIA_APITOKEN;
        return getResultsByUrlQuery($url);
    }


    function getInvoiceByNumber($number, $period = 'all')
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'number=' . $number
            . '&period=' . $period
            . '&api_token=' . FAKTUROWNIA_APITOKEN;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        $invoice = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return count($invoice) > 0 ? $invoice[0] : null;
    }

    function getInvoicesByDateRange($period, $dateFrom, $dateTo, $additionalFilters = ''): array
    {
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?'
            . 'period=' . $period
            . '&date_from=' . $dateFrom
            . '&date_to=' . $dateTo
            . '&api_token=' . FAKTUROWNIA_APITOKEN
            . '&order=issue_date'
            . $additionalFilters;

        $invoices = getResultsByUrlQuery($url);

        foreach ($invoices as &$invoice) {
            if ($invoice['buyer_tax_no'] === '' && $invoice['buyer_name'] === 'Inna Petrianyk') {
                $invoice['buyer_tax_no'] = '89102113580';
            }
        }

        return $invoices;
    }

    function addInvoice($kind, $number, $sellDate, $issueDate, $paymentTo, $buyerName, $buyerTaxNo, $buyerEmail,
                        $buyerPostCode, $buyerCity, $buyerStreet, $recipientId, $positions, $showDiscount, $internalNote,
                        $additionalInfo, $additionalInfoDesc)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/invoices.json';

        if ($this->isNIP($buyerTaxNo)) {

            $client = $this->getClientByTaxNo($buyerTaxNo);

            $data = array(
                "api_token" => FAKTUROWNIA_APITOKEN,
                "invoice" => array(
                    "kind" => $kind,
                    "number" => $number,
                    "sell_date" => $sellDate,
                    "issue_date" => $issueDate,
                    "payment_to" => $paymentTo,
                    "buyer_name" => $buyerName,
                    "buyer_tax_no" => $buyerTaxNo,
                    "buyer_email" => $buyerEmail,
                    "buyer_post_code" => $buyerPostCode,
                    "buyer_city" => $buyerCity,
                    "buyer_street" => $buyerStreet,
                    "recipient_id" => $recipientId,
                    "positions" => $positions,
                    "show_discount" => $showDiscount,
                    "internal_note" => $internalNote,
                    "additional_info" => $additionalInfo,
                    "additional_info_desc" => $additionalInfoDesc,
                    "client_id" => $client[0]['id']
                )
            );
        } else if ($this->isValidPesel($buyerTaxNo)) {
            $nameParts = explode(" ", $buyerName);
            $buyer_first_name = $nameParts[0];
            $buyer_last_name = $nameParts[1] ?? '';

            $data = array(
                "api_token" => FAKTUROWNIA_APITOKEN,
                "invoice" => array(
                    "kind" => $kind,
                    "number" => $number,
                    "sell_date" => $sellDate,
                    "issue_date" => $issueDate,
                    "payment_to" => $paymentTo,
                    "buyer_first_name" => $buyer_first_name,
                    "buyer_last_name" => $buyer_last_name,
                    "buyer_email" => $buyerEmail,
                    "buyer_post_code" => $buyerPostCode,
                    "buyer_city" => $buyerCity,
                    "buyer_street" => $buyerStreet,
                    "recipient_id" => $recipientId,
                    "positions" => $positions,
                    "show_discount" => $showDiscount,
                    "internal_note" => $internalNote,
                    "additional_info" => $additionalInfo,
                    "additional_info_desc" => $additionalInfoDesc
                )
            );
        } else {
            curl_close($ch);
            return null;
        }

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

        return $result;
    }

    function removeInvoice($invoiceId)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/invoices/' . $invoiceId . '.json';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN
        );

        $data_string = json_encode($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
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

        return $result;
    }

    // split single payment

    function normalizeCurrencyValue($value)
    {
        return str_replace(',', '.', $value);
    }

    function splitPayments($clientId)
    {
        $overPaidPayments = $this->getAllOverpaidPayments($clientId);

        $allNewPayments = array();
        foreach ($overPaidPayments as $payment) {
            $notPaidInvoices = $this->getInvoicesByClientId($clientId, false);

            if (count($notPaidInvoices) > 0) {
                $newPayments = $this->splitPayment($notPaidInvoices, $payment);
                $allNewPayments = array_merge($newPayments, $allNewPayments);
            }
        }

        return $allNewPayments;
    }

    function sendOverduePaymentsReminder($invoices, $interestNotes, $buyerTaxNo, $clientEmail)
    {
        $clientAccountNb = $this->clientinvoice->getClientAccountNb($buyerTaxNo);

        $mailingBody = '';
        $fmt = new NumberFormatter('pl_PL', NumberFormatter::CURRENCY);
        $fmt->setTextAttribute(NumberFormatter::CURRENCY_CODE, 'zł');
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 2);

        if (count($invoices) > 0) {

            $invoicesAmount = array_sum(array_map(function ($note) {
                return floatval($note['price_gross']) - floatval($note['paid']);
            }, $invoices));

            $invoicesSummary = join('<br/>', array_map(function ($invoice) use (&$fmt) {
                $calculatedAmount = $fmt->format(floatval($invoice['price_gross']) - floatval($invoice['paid']));
                return "faktura numer {$invoice['number']} na kwotę {$calculatedAmount} termin płatności {$invoice['payment_to']}";
            },
                $invoices));

            $mailingBody .= "$invoicesSummary<br /><br />pozostało do zapłaty faktury: <b>{$fmt->format($invoicesAmount)}</b><br /><br />";
        }

        if (count($interestNotes) > 0) {
            $interestNotesAmount = array_sum(array_map(function ($note) use (&$fmt) {
                return floatval($note['amount']);
            }, $interestNotes));

            $interestNotesSummary = join('<br/>', array_map(function ($note) use (&$fmt) {
                $normalizedName = str_replace("-", "/", substr($note['name'], 0, -4));
                return "nota odsetkowa do faktury numer $normalizedName na kwotę {$fmt->format($note['amount'])}";
            },
                $interestNotes));

            $mailingBody .= "$interestNotesSummary<br /><br />pozostało do zapłaty noty: <b>{$fmt->format($interestNotesAmount)}</b><br /><br />";
        }

        $customerMessage = '';
        if ($mailingBody !== '') {

            $overdueAmount = $fmt->format($invoicesAmount + $interestNotesAmount);

            $OTUSBankAccount = BANK_NAME . ' ' . $clientAccountNb;
            $mailingBody = "Bardzo proszę o uregulowanie poniższej kwoty: <b>$overdueAmount</b> (Łącznie do zapłaty faktury i noty odsetkowe) <br />na konto:&nbsp;"
                . $OTUSBankAccount . "<br /><br />"
                . $mailingBody;

            $mailing = new mailing();

            $overduePaymentsClientEmail = !OVERDUE_PAYMENTS_DEBUG_MODE ? $clientEmail : OVERDUE_PAYMENTS_DEBUG_EMAIL;

            $mailing->sendNewOverduePaymentsMail(
                $overduePaymentsClientEmail,
                $mailingBody,
                "Przypomnienie o zaległych płatnościach"
            );
            unset($mailing);


            $customerMessage = "Wiadomość o zaległości w wysokości $overdueAmount, została wysłana do klienta.";
        } else {
            $customerMessage = "Klient nie posiada zaległości, wiadomość nie została wysłana.";

        }
        $customerMessageParams = array("client_nip" => $buyerTaxNo, "message_date" => date("Y-m-d"), "message" => $customerMessage);

        if (!OVERDUE_PAYMENTS_DEBUG_MODE) {
            $this->clientinvoice->addPaymentMessage($customerMessageParams, 'payments_messages');
        }
    }

    function isNIP($nip)
    {
        if (strlen($nip) == 10) {
            $aWeight = array(0 => 6, 5, 7, 2, 3, 4, 5, 6, 7);

            $iSum = 0;
            for ($i = 0; $i < strlen($nip) - 1; $i++) {
                $iSum += (int)$nip[$i] * $aWeight[$i];
            }

            $iCheck = $iSum % 11;

            return (int)$nip[strlen($nip) - 1] == $iCheck ? true : false;
        }

        return false;
    }

    function isValidPesel($pesel) {

        if (strlen($pesel) != 11 || !ctype_digit($pesel)) {
            return false;
        }

        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];

        $controlSum = 0;
        for ($i = 0; $i < 10; $i++) {
            $controlSum += $weights[$i] * $pesel[$i];
        }

        $controlDigit = (10 - ($controlSum % 10)) % 10;

        return $controlDigit == $pesel[10];
    }
}

function curl_get($url, $useProxy = USE_PROXY)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    if ($useProxy) {
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response = array("error" => curl_errno($ch), "message" => curl_error($ch));
    }
    curl_close($ch);

    return $response;
}

function curl_post($url, $data = array(), $useProxy = USE_PROXY)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    if ($useProxy) {
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response = array("error" => curl_errno($ch), "message" => curl_error($ch));
    }
    curl_close($ch);

    return $response;
}

function curl_put($url, $data, $useProxy = USE_PROXY)
{
    $ch = curl_init();

    if ($useProxy) {
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
    );
    if (USE_PROXY) {
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
    }

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response = array("error" => curl_errno($ch), "message" => curl_error($ch));
    }
    curl_close($ch);

    return $response;
}

/**
 * @param string $url
 * @param int $pageNb
 * @param int $perPage
 * @return array
 */
function getResultsByUrlQuery(string $url, int $pageNb = 1, int $perPage = 100): array
{
    $ch = curl_init();

    $results = array();
    do {
        curl_setopt($ch, CURLOPT_URL, $url . '&page=' . $pageNb . '&per_page=' . $perPage);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (USE_PROXY) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        }
        $data = json_decode(curl_exec($ch), true);

        $results = array_merge($results, $data);
        $pageNb++;
    } while (count($data) == $perPage);

    curl_close($ch);

    return $results;
}