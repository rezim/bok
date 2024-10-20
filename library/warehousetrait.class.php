<?php

trait WarehouseTrait
{
    use CommonTrait;

    function getAllWarehouses(): array
    {
        $url = FAKTUROWNIA_ENDPOINT . '/warehouses.json?'
            . '&api_token=' . FAKTUROWNIA_APITOKEN;

        return $this->getAllData($url);
    }

    function getAllProducts(string $warehouseId = ''): array
    {
        $url = FAKTUROWNIA_ENDPOINT . '/products.json?'
            . 'quantity=not_zero'
            . '&filter=active'
            . '&warehouse_id=' . $warehouseId
            . '&api_token=' . FAKTUROWNIA_APITOKEN;

        return $this->getAllData($url);

    }

    function getDocumentsByNotification(string $notificationId): array
    {
        $url = FAKTUROWNIA_ENDPOINT . '/warehouse_documents.json?'
            . '&query=' . $notificationId
            . '&include_positions=true'
            . '&api_token=' . FAKTUROWNIA_APITOKEN;

        $allDocuments = $this->getAllData($url);

        // it could happen that we much also another documents with the same pattern,
        // that is why we have to filter them before return
        $filteredDocuments = array_filter($allDocuments, function($document) use ($notificationId) {
            return $document['oid'] === $notificationId;
        });

        return $filteredDocuments;
    }


    function addEditDocument(string $warehouseId, string $notificationId, string $productId, string $quantity) {
        $existingDocuments = $this->getDocumentsByNotification($notificationId);

        $foundDocument = array_filter($existingDocuments, function($doc) use ($warehouseId, $notificationId) {
            return $doc['warehouse_id'] == $warehouseId && $doc['oid'] == $notificationId;
        });
        // reduce to first document (if exists)
        $foundDocument = reset($foundDocument);

        if ($foundDocument) {
            return $this->editDocument($foundDocument['id'], $productId, $quantity);
        } else {
            return $this->addDocument($warehouseId, $notificationId, $productId, $quantity);
        }
    }

    function addDocument(string $warehouseId, string $notificationId, string $productId, string $quantity)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/warehouse_documents.json';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "warehouse_document" => array(
                "number" => null,
                "warehouse_id" => $warehouseId,
                "kind" => "rw",
                "oid" => $notificationId,
                "warehouse_actions" => array(
                    array("product_id" => $productId, "quantity" => $quantity))
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

        $data = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return array("status" => 0, "info" => "Dodanie dokumentu " . $data['number'] . " zakończone poprawnie!");
    }

    function editDocument(string $documentId, string $productId, string $quantity) {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/warehouse_documents/' . $documentId . '.json?';

        $data = array(
            "api_token" => FAKTUROWNIA_APITOKEN,
            "warehouse_document" => array(
                "warehouse_actions" => array(
                    array("product_id" => $productId, "quantity" => $quantity))
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

        $data = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return array("status" => 0, "info" => "Edycja dokumentu " . $data['number'] . " zakończona poprawnie!");
    }

    function removeDocument($documentId, $documentNumber)
    {
        $ch = curl_init();
        $url = FAKTUROWNIA_ENDPOINT . '/warehouse_documents/' . $documentId . '.json';

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
        $data = json_decode(curl_exec($ch), true);

        curl_close($ch);

        return array("status" => 0, "info" => "Usunięcie dokumentu " . $documentNumber . " zakończone poprawnie!");
    }

    function bokToFaktOrderNumber($notificationId)
    {
        return "BOK-$notificationId$";
    }
}