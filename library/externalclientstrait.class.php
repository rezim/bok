<?php

trait ExternalClientsTrait
{

    function getClientIdByTaxNo($clientTaxNo): ?int {
        $client = $this->getClientByTaxNo($clientTaxNo);
        if (empty($client)) {
            return null;
        }
        $client = $client[0];

        return $client['id'];
    }

    /**
     * @param $clientTaxNo
     * @return ExternalClient
     */
    function getClientByTaxNo($clientTaxNo): array
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

    function createClient($clientData)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/clients.json';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "client" => $clientData
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

        return $result;
    }

    function updateClientById($clientId, $clientData)
    {

        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/clients/' . $clientId . '.json?';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "client" => $clientData
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

    /**
     * @param $clientData
     * @return mixed|void
     */
    function createOrUpdateClientByTaxNo($clientData) {
        $taxNo = $clientData['tax_no'];
        $client = $this->getClientByTaxNo($taxNo);
        $isNewClient = empty($client);
        if ($isNewClient) {
            return $this->createClient($clientData);
        }
        $client = $client[0];

        $this->updateClientById($client['id'], $clientData);
    }
}