<?php

function httpGetJson(string $url, int $timeout = 25): array
{
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => $timeout,
        CURLOPT_TIMEOUT => $timeout,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => ['Accept: application/json'],
    ]);
    $body = curl_exec($ch);
    $err = curl_error($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($err) {
        throw new RuntimeException("HTTP error: $err");
    }
    if ($code < 200 || $code >= 300) {
        throw new RuntimeException("HTTP status $code, body: " . substr((string)$body, 0, 500));
    }

    $data = json_decode((string)$body, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException("JSON decode error: " . json_last_error_msg());
    }
    // Fakturownia zwraca tablicę faktur (array) lub obiekt {invoices: [...]}; obsłużmy oba warianty
    if (isset($data['invoices']) && is_array($data['invoices'])) {
        return $data['invoices'];
    }
    if (is_array($data)) {
        return $data;
    }
    return [];
}

function valueOrNull($v)
{
    // Uporządkuj wartości: puste stringi -> null
    if ($v === '' || $v === []) return null;
    return $v;
}

function normalizeDate(?string $s): ?string
{
    if (!$s) return null;
    $dt = date_create($s);           // rozumie ISO-8601, +02:00, Z, itd.
    if (!$dt) return null;
    return $dt->format('Y-m-d');
}

function normalizeTimestamp(?string $s): ?string
{
    if (!$s) return null;
    $dt = date_create($s);
    if (!$dt) return null;
    return $dt->format('Y-m-d H:i:s');
}

function normalizeStatus($raw, $paid = null, $priceGross = null): ?string {
    if ($raw !== null && $raw !== '') {
        $s = strtolower(trim((string)$raw));
        // Ujednolicenie typowych wartości z Fakturowni
        $map = [
            'paid'                => 'paid',
            'partially_paid'      => 'partially_paid',
            'unpaid'              => 'unpaid',
            'issued'              => 'issued',
            'sent'                => 'sent',
            'canceled'            => 'canceled',
            'cancelled'           => 'canceled',
            'draft'               => 'draft',
            'deleted'             => 'deleted',
        ];
        return $map[$s] ?? $s; // jeśli trafi się coś nietypowego – zapisz surową wartość po lowercase
    }

    // Fallback z kwot: jeśli brak statusu, spróbuj wywnioskować po paid vs gross
    if ($paid !== null && $priceGross !== null) {
        if ((float)$paid <= 0.0) return 'unpaid';
        if ((float)$paid + 0.01 < (float)$priceGross) return 'partially_paid'; // mała tolerancja
        return 'paid';
    }
    return null;
}

function importInvoices(array $db, array $api)
{
    try {
        // 1) Połączenie z DB
        $pdo = new PDO(
            'mysql:host=' . $db['host'] .
            ';dbname=' . $db['name'] .
            ';charset=' . ($db['charset'] ?? 'utf8mb4'),
            $db['user'],
            $db['pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        // 2) Wyczyszczenie tabeli
        $pdo->exec("TRUNCATE TABLE `invoices`");

        // 3) Przygotowanie INSERT
        $sql = "
        INSERT INTO `invoices`
            (`id`,`number`, `buyer_tax_no`, `buyer_name`, `buyer_email`,
             `payment_to`, `paid`, `paid_date`, `status`,
             `price_gross`, `price_net`, `price_tax`,
             `issue_date`, `created_at`, `updated_at`, `invoice_json`)
        VALUES
            (:id, :number, :buyer_tax_no, :buyer_name, :buyer_email,
             :payment_to, :paid, :paid_date, :status,
             :price_gross, :price_net, :price_tax,
             :issue_date, :created_at, :updated_at, :invoice_json)
    ";
        $insert = $pdo->prepare($sql);

        // 4) Pobieranie z paginacją
        $page = 1;
        $totalInserted = 0;

        do {
            $url = sprintf(
                '%s/invoices.json?api_token=%s&page=%d&per_page=%d',
                $api['endpoint'],
                urlencode($api['api_token']),
                $page,
                $api['per_page']
            );

            $invoices = httpGetJson($url, $api['timeout']);
            $count = is_countable($invoices) ? count($invoices) : 0;

            foreach ($invoices as $inv) {
                // --- MAPOWANIE PÓL ---
                // Nazwy w API Fakturowni mogą się różnić, więc dodane są bezpieczne fallbacki.
                $id = valueOrNull($inv['id'] ?? null);
                $number = valueOrNull($inv['number'] ?? null);
                $buyer_tax_no = valueOrNull($inv['buyer_tax_no'] ?? $inv['buyer_tax_no_int'] ?? $inv['buyer_tax_no_eu'] ?? null);
                $buyer_name = valueOrNull($inv['buyer_name'] ?? $inv['client_name'] ?? null);
                $buyer_email = valueOrNull($inv['buyer_email'] ?? $inv['client_email'] ?? null);

// DATY:
                $payment_to = normalizeDate($inv['payment_to'] ?? $inv['payment_due'] ?? null);
                $paid_date = normalizeDate($inv['paid_date'] ?? null);
                $issue_date = normalizeDate($inv['issue_date'] ?? null);

// TIMESTAMPY (mogą być ISO-8601 ze strefą)
                $created_at = normalizeTimestamp($inv['created_at'] ?? null);
                $updated_at = normalizeTimestamp($inv['updated_at'] ?? null);

// KWOTY:
                $paid = isset($inv['paid']) ? (float)$inv['paid'] : (isset($inv['payments_amount']) ? (float)$inv['payments_amount'] : null);
                $price_gross = isset($inv['total_price_gross']) ? (float)$inv['total_price_gross'] : (isset($inv['price_gross']) ? (float)$inv['price_gross'] : (isset($inv['sum']) ? (float)$inv['sum'] : null));
                $price_net = isset($inv['total_price']) ? (float)$inv['total_price'] : (isset($inv['price_net']) ? (float)$inv['price_net'] : null);
                $price_tax = isset($inv['tax_price']) ? (float)$inv['tax_price']
                    : (($price_gross !== null && $price_net !== null) ? ($price_gross - $price_net) : null);

// Jeśli brak paid_date, spróbuj wyciągnąć z listy płatności:
                if ($paid_date === null && !empty($inv['payments']) && is_array($inv['payments'])) {
                    $dates = array_column($inv['payments'], 'payment_date');
                    rsort($dates);
                    $paid_date = normalizeDate($dates[0] ?? null);
                }

                $status = normalizeStatus($inv['status'] ?? $inv['state'] ?? null, $paid, $price_gross);

// JSON do longtext
                $invoice_json = json_encode($inv, JSON_UNESCAPED_UNICODE);

                // --- INSERT ---
                $insert->execute([
                    ':id' => $id,
                    ':number' => $number,
                    ':buyer_tax_no' => $buyer_tax_no,
                    ':buyer_name' => $buyer_name,
                    ':buyer_email' => $buyer_email,
                    ':payment_to' => $payment_to,
                    ':paid' => $paid,
                    ':paid_date' => $paid_date,
                    ':status' => $status,
                    ':price_gross' => $price_gross,
                    ':price_net' => $price_net,
                    ':price_tax' => $price_tax,
                    ':issue_date' => $issue_date,
                    ':created_at' => $created_at,
                    ':updated_at' => $updated_at,
                    ':invoice_json' => $invoice_json,
                ]);

                $totalInserted++;
            }

            // mała pauza „uprzejmości” dla API
            usleep(200 * 1000); // 200 ms
            $page++;
        } while ($count === $api['per_page']); // jeśli ostatnia strona krótsza -> koniec

        echo "✅ Zaimportowano $totalInserted faktur.\n";
    } catch (Throwable $e) {
        http_response_code(500);
        echo "❌ Błąd: " . $e->getMessage() . "\n";
    }
}