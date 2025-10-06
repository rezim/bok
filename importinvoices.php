<?php
include 'config/config.php';
include 'application/utils/import_invoices.php';


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

importInvoices($db, $api);