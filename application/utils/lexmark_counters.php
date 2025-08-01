<?php
function getLexmarkPrinterCounters(): array
{
    $oauthUrl = LEXMARK_OAUTH_URL;
    $clientId = LEXMARK_CLIENT_ID;
    $clientSecret = LEXMARK_CLIENT_SECRET;
    $scope = 'api-read';
    $countersUrl = LEXMARK_GET_COUNTERS_URL;
    $userAgent = LEXMARK_USER_AGENT;

    // get access token
    $data = http_build_query([
        'grant_type' => 'client_credentials',
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'scope' => $scope,
    ]);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $oauthUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'User-Agent: ' . $userAgent
        ],
        CURLOPT_SSL_VERIFYPEER => false, // ❗ tylko do testów
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $responseRaw = curl_exec($ch);
    if ($curlError = curl_error($ch)) {
        curl_close($ch);
        return [
            "error" => "CURL error during token request",
            "message" => $curlError
        ];
    }
    curl_close($ch);

    $response = json_decode($responseRaw, true);


    if (!isset($response['access_token'])) {
        return [
            "error" => "Token error",
            "message" => "access_token not returned",
            "response" => $responseRaw
        ];
    }

    $accessToken = $response['access_token'];

    // get counters
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $countersUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $accessToken",
            'Accept: application/json',
            'User-Agent: ' . $userAgent
        ],
        CURLOPT_SSL_VERIFYPEER => false, // ❗ tylko do testów
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $responseRaw = curl_exec($ch);
    if ($curlError = curl_error($ch)) {
        curl_close($ch);
        return [
            "error" => "CURL error during counters request",
            "message" => $curlError
        ];
    }
    curl_close($ch);

    $response = json_decode($responseRaw, true);
    if (!is_array($response)) {
        return [
            "error" => "Invalid response",
            "message" => "API did not return valid JSON",
            "raw" => $responseRaw
        ];
    }

    return $response;
}

function getLexmarkPrinterCountersSummary(): array
{
    $response = getLexmarkPrinterCounters();

    if (isset($response['error'])) {
        return $response;
    }

    if (!isset($response['content']) || !is_array($response['content'])) {
        return [
            'error' => 'Invalid response format',
            'message' => 'Missing "content" array in API response'
        ];
    }

    $summary = [];

    foreach ($response['content'] as $device) {
        $counters = $device['counters'] ?? null;
        $serial = $device['serialNumber'] ?? 'UNKNOWN';

        $timestampMs = $device['lastDataRefresh'] ?? null;
        $counterReadDate = $timestampMs
            ? date('Y-m-d H:i:s', (int)($timestampMs / 1000))
            : null;

        $summary[] = [
            'serialNumber' => $serial,
            'monoPrintSideCount' => $counters['monoSideCount'] ?? null,
            'colorPrintSideCount' => $counters['colorSideCount'] ?? null,
            'totalPrintCount' => $counters['totalSideCount'] ?? null,
            'totalScanCount' => $counters['totalScanCount'] ?? null,
            'counterReadDate' => $counterReadDate,
        ];
    }

    return $summary;
}

function insertLexmarkCounters(): void
{
    $host = DB_HOST;
    $dbname = DB_NAME;
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("❌ Błąd połączenia z bazą: " . $e->getMessage());
    }

    $result = getLexmarkPrinterCountersSummary();

if (isset($result['error'])) {
    die("❌ Błąd danych: " . $result['message']);
}

    foreach ($result as $device) {
        $serial = $device['serialNumber'];
        $ilosc = $device['monoPrintSideCount'] ?? 0;
        $ilosckolor = $device['colorPrintSideCount'] ?? 0;
        $ilosctotal = $device['totalPrintCount'] ?? 0;
        $totalScanCount = $device['totalScanCount'] ?? 0;
        $datawiadomosci = $device['counterReadDate'] ?? null;
        $dateinsert = date('Y-m-d H:i:s');

        // get rowid from agreements
        $stmt = $pdo->prepare("SELECT rowid FROM agreements WHERE serial = ?");
        $stmt->execute([$serial]);
        $row = $stmt->fetch();

//        if (!$row) {
//            echo "⚠️ Pominięto SN: $serial – brak wpisu w agreements.\n";
//            continue;
//        }

        $rowid_agreement = $row ? $row['rowid'] : null;

        // INSERT to pages
        $insertPages = $pdo->prepare("
        INSERT INTO pages (serial, ilosc, ilosckolor, ilosctotal, rowid_agreement, dateinsert, datawiadomosci)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
        $insertPages->execute([
            $serial,
            $ilosc,
            $ilosckolor,
            $ilosctotal,
            $rowid_agreement,
            $dateinsert,
            $datawiadomosci
        ]);

        // INSERT to scans
        $insertScans = $pdo->prepare("
        INSERT INTO scans (serial, ilosctotal, datawiadomosci, rowid_agreement, dateinsert)
        VALUES (?, ?, ?, ?, ?)
    ");
        $insertScans->execute([
            $serial,
            $totalScanCount,
            $datawiadomosci,
            $rowid_agreement,
            $dateinsert
        ]);

        echo "✅ SN: $serial – dodano do pages i scans.\n";
    }
}