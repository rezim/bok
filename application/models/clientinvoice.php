<?php

require_once (ROOT . DS . 'application' . DS . 'utils' . DS . 'import_invoices.php');

class clientinvoice extends Model
{
    protected $dataod='',$datado='',$filterklient='',$filterdrukarka='',$nazwakrotka='';

    function getAgreements() {
        $query =
            "select c.rowid as client_id, c.nazwapelna as client_name, c.nip as client_nip, c.telefon as client_phone, c.mailfaktury as client_mailfaktury,
                    c.naliczacodsetki as client_naliczacodsetki, c.monitoringplatnosci as client_monitoringplatnosci,
                    a.nrumowy as agreement_id, a.rowid as agreement_rowid, c.terminplatnosci as agreement_paymentdate,
                    a.activity as agreement_isactive
             from agreements a inner join clients c on a.rowidclient = c.rowid
             where c.nip <> '0000000000' OR (c.nip = '0000000000' AND a.activity = 1)
             order by nazwakrotka";
        return json_encode($this->query($query,null,false));
    }

    function addPaymentMessage($postParams, $tableName) {
        $postParams['active'] = 1;
        $postParams['owner'] = $_SESSION['user']['imie'] . ' ' . $_SESSION['user']['nazwisko'];
        $result = $this->insertFromPostParams($postParams, $tableName);

        $query = "select * from {$tableName} where rowid={$result['rowid']}";
        return json_encode($this->query($query, null, false));
    }

    function removePaymentMessage($rowid) {
        return $this->update
        (
            "update `payments_messages` 
                   set `active`=0
                   where `rowid`=?"
            ,'i',
            array
            (
                $rowid
            )
        );
    }

    function getPaymentMessages($client_nip) {
        $query = "select * from payments_messages where client_nip='{$client_nip}' and active = 1 order by message_date desc, created desc";
        return json_encode($this->query($query, null, false));
    }

    function getTrackedDeptors() {
        $query = "select nip from clients where monitoringplatnosci=1";
        return $this->query($query, null, false);
    }

    function createInterestNote($clientTaxNb, $externalClientId, $amount, $invoice, $filePath, $created, $paid) {
        $client = $this->getClientByTaxNb($clientTaxNb);

        if (!$client) {
            return "Nie można pobrać klienta po NIP: " . $clientTaxNb;
        }

        $interestNote = array(
            'rowidclient' => $client['rowid'],
            'externalclientid' => $externalClientId,
            'amount' => $amount,
            'invoice' => $invoice,
            'filepath' => $filePath,
            'created' => $created,
            'paid' => $paid
        );

        $namesWihTypes = array(
            'rowidclient' => 'integer',
            'externalclientid' => 'integer',
            'amount' => 'integer',
            'invoice' => 'string',
            'filepath' => 'string',
            'created' => 'timestamp',
            'paid' => 'boolean'
        );

        return $this->insertIntoTable('interest_notes', $namesWihTypes, $interestNote);
    }

    function getClientByTaxNb($clientTaxNb, $activeOnly = true)
    {
        $query = "select * from clients where nip={$clientTaxNb}";
        if ($activeOnly === true) {
            $query .= " and activity=1";
        }
        $clients = $this->query($query, null, false);

        if (!count($clients) == 1) {
            return null;
        }

        return $clients[0];
    }

    function getClientAccountNb($clientTaxNb) {
        $client = $this->getClientByTaxNb($clientTaxNb);

        if (!$client) {
            return;
        }

        return $this->formatIBAN($client["numerrachunku"]);

    }


    function formatIBAN($iban)
    {
        // remove whitespaces before formatting, it could happen iban is already formatted
        $iban = preg_replace('/\s+/', '', $iban);

        $controlNb = substr($iban, 0, 2);

        $arrAccountNb = str_split(substr($iban, 2, 6 * 4), 4);

        return implode(' ', array($controlNb, implode(' ', $arrAccountNb)));
    }


    function getClientsWithChargeInterest() {
        $query = "SELECT * FROM `clients` where naliczacodsetki = 1 and activity = 1";

        return $this->query($query, null, false);
    }

    function getPaymentsByClientTaxNo($clientTaxNo, $startDate, $endDate)
    {
        $where = "WHERE p.date >= '{$startDate}' and p.date <= '{$endDate}' and c.nip = '{$clientTaxNo}'";
        $orderBy = 'p.date DESC';

        $query = "SELECT p.details as 'content', TRUNCATE(p.amount / 100, 2) as 'price_gross', (select GROUP_CONCAT(pp.ext_invoice_nb separator ', ') from payments_processed pp where pp.rowid_payments = p.rowid) as 'invoice', CONCAT(c.nazwakrotka, CONCAT(' NIP: ', c.nip)) as 'client', p.date as 'issue_date' FROM `payments` p 
                        inner join clients c on substring(p.recipient_acount, -10) = c.nip
                      {$where}
                      ORDER BY {$orderBy}";

        return $this->query($query, null, null);
    }

    function getNotProcessedPaymentsByClientTaxNo($clientTaxNo, $startDate, $endDate)
    {
        // this is because for older payments we do not have records in `payments_processed` table,
        // therefore we do not know if they were processed or not
        $PROCESSED_PAYMENTS_START_DATE = PROCESSED_PAYMENTS_START_DATE;
        $where = "WHERE p.date >= '{$startDate}' and p.date >= '{$PROCESSED_PAYMENTS_START_DATE}' and p.date <= '{$endDate}' and c.nip = '{$clientTaxNo}'";
        $orderBy = 'p.date DESC';

        $query = "SELECT p.details as 'content', TRUNCATE(p.amount / 100, 2) as 'price_gross', (select GROUP_CONCAT(pp.ext_invoice_nb separator ', ') from payments_processed pp where pp.rowid_payments = p.rowid) as 'invoice', CONCAT(c.nazwakrotka, CONCAT(' NIP: ', c.nip)) as 'client', p.date as 'issue_date' FROM `payments` p 
                        inner join clients c on substring(p.recipient_acount, -10) = c.nip
                      {$where}
                  HAVING invoice is NULL                                                                                                                                                                                                                                                                                   
                  ORDER BY {$orderBy}";

        return $this->query($query, null, null);
    }

    function pullAllInvoices() {
        $db = [
            'host'    => DB_HOST,
            'name'    => DB_NAME,
            'user'    => DB_USER,
            'pass'    => DB_PASSWORD,
            'charset' => 'utf8mb4',
        ];

        $api = [
            'endpoint' => FAKTUROWNIA_ENDPOINT,
            'api_token' => FAKTUROWNIA_APITOKEN,
            'per_page'  => 100,
            'timeout'   => 25,
        ];

        return importInvoices($db, $api);
    }


    function getInvoicesByDateRangeFromDb(string $period, string $dateFrom, string $dateTo, string $additionalFilters = ''): array
    {
        $sql = "
        SELECT invoice_json 
        FROM invoices
        WHERE issue_date BETWEEN :date_from AND :date_to
    ";

        if (!empty($additionalFilters)) {
            $sql .= " " . $additionalFilters;
        }

        $sql .= " ORDER BY issue_date";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':date_from' => $dateFrom,
            ':date_to' => $dateTo,
        ]);

        $invoices = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $invoice = json_decode($row['invoice_json'], true);

            if (!is_array($invoice)) {
                continue; // pomiń uszkodzone JSON-y
            }

            if (($invoice['buyer_tax_no'] === '' || $invoice['buyer_tax_no'] === null) && $invoice['buyer_name'] === 'Inna Petrianyk') {
                $invoice['buyer_tax_no'] = '89102113580';
            }

            $invoices[] = $invoice;
        }

        return $invoices;
    }
}