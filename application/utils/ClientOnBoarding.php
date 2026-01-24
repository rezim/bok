<?php

/**
 * Parses text in the format:
 * "Key: Value"
 * and inserts the data into the client_onboarding_forms table.
 *
 * Requirements:
 * - $pdo: PDO instance connected to MariaDB
 * - table created using the SQL script provided earlier
 */
function insertClientOnboardingFromText(PDO $pdo, string $inputText): int
{
    $parsed = parseKeyValueFormText($inputText);

    // Mapping "form keys" -> "database columns"
    $map = [
        'Nazwa firmy' => 'company_name',
        'NIP' => 'nip',
        'KRS' => 'krs',
        'Osoba reprezentująca firmę w umowie' => 'contract_representative',

        'Adres ulica i numer' => 'address_street_no',
        'Miejscowość' => 'city',
        'Kod pocztowy' => 'postal_code',

        'Adres email do faktur' => 'invoice_email',
        'Osoba odpowiedzialna za płatności' => 'payments_contact_person',
        'Telefon (płatności)' => 'payments_phone',

        'Osoba odpowiedzialna za urządzenie' => 'device_contact_person',
        'Adres email w sprawie licznika drukarki' => 'printer_counter_email',

        'Adres instalacji ulica i numer' => 'installation_address_street_no',
        'Miejscowość instalacji' => 'installation_city',
        'Kod pocztowy instalacji' => 'installation_postal_code',

        'Osoba do pomocy wyjęcia i wniesienia ksera' => 'helper_person',
        'Telefon (pomoc)' => 'helper_phone',
        'Piętro' => 'floor',

        'Osoba kontaktowa w dziale IT' => 'it_contact_person',
        'Telefon (IT)' => 'it_phone',

        'Systemy operacyjne' => 'operating_systems',
        'Instalacja sterowników' => 'driver_installation',
        'Instalacja SMB' => 'smb_installation',
        'Podłączenie drukarki' => 'printer_connection',

        'Skan do email' => 'scan_to_email',
        'OCR' => 'ocr',

        'Uwagi dodatkowe' => 'additional_notes',
        'Jak nas znalazłeś ?' => 'how_found_us',
        'Pakiet' => 'package_name',
    ];

    /**
     * The input contains multiple "Telefon:" fields without explicit context.
     * In parseKeyValueFormText() they are disambiguated as:
     * - Telefon (płatności)
     * - Telefon (pomoc)
     * - Telefon (IT)
     * If no context can be determined, the field becomes "Telefon (inne)"
     * and is intentionally ignored here.
     */

    $row = [];
    foreach ($map as $formKey => $column) {
        $row[$column] = normalizeEmptyToNull(isset($parsed[$formKey]) ? $parsed[$formKey] : null);
    }

    // Store the original raw text for debugging and traceability
    $row['raw_text'] = $inputText;

    // Build INSERT query dynamically
    $columns = array_keys($row);
    $placeholders = [];
    foreach ($columns as $c) {
        $placeholders[] = ':' . $c;
    }

    $sql = "INSERT INTO client_onboarding_forms (" . implode(',', $columns) . ")
            VALUES (" . implode(',', $placeholders) . ")";

    $stmt = $pdo->prepare($sql);
    foreach ($row as $col => $val) {
        $stmt->bindValue(':' . $col, $val);
    }
    $stmt->execute();

    return (int)$pdo->lastInsertId();
}

/**
 * Parses raw text into an associative array [key => value].
 *
 * Supported cases:
 * - spaces before the colon (e.g. "Address street and number : XYZ")
 * - empty values (e.g. "Telefon:" or "Telefon :")
 * - repeated "Telefon:" fields (context-aware handling)
 */
function parseKeyValueFormText(string $inputText): array
{
    // 1) Normalize <br> tags (including whitespace and different variants) into new lines
    // Examples matched: <br>, <br/>, <br />, < br >, <br    />, etc.
    $normalized = preg_replace('/<\s*br\s*\/?\s*>/iu', "\n", $inputText);

    // 2) Decode HTML entities (&nbsp; etc.) and strip remaining HTML tags
    $normalized = html_entity_decode($normalized, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $normalized = strip_tags($normalized);

    // 3) Split into lines, trim, drop empty
    $lines = preg_split('/\R/u', $normalized);
    $result = [];

    // Current logical section, used to disambiguate repeated keys
    $section = null; // company | installation | payments | helper | it | null

    foreach ($lines as $rawLine) {
        $line = trim($rawLine);

        if ($line === '') {
            continue;
        }

        // 4) Stop parsing at the footer separator (e.g. "---")
        // The email footer starts after a line containing "---"
        if (preg_match('/^-{3,}$/u', $line) || strpos($line, '---') !== false) {
            break;
        }

        // 5) Match "Key: Value" with optional whitespace around ":"
        // Handles keys like "Adres ulica i numer : Polska"
        if (!preg_match('/^(.+?)\s*:\s*(.*)$/u', $line, $m)) {
            // Line without a colon – ignore
            continue;
        }

        $key = trim($m[1]);
        $value = trim($m[2]);

        // 6) Detect logical sections based on anchor fields
        if ($key === 'Osoba odpowiedzialna za płatności') {
            $section = 'payments';
        } elseif (
            $key === 'Adres instalacji ulica i numer' ||
            $key === 'Miejscowość instalacji' ||
            $key === 'Kod pocztowy instalacji'
        ) {
            $section = 'installation';
        } elseif ($key === 'Osoba do pomocy wyjęcia i wniesienia ksera') {
            $section = 'helper';
        } elseif ($key === 'Osoba kontaktowa w dziale IT') {
            $section = 'it';
        } elseif ($key === 'Nazwa firmy' || $key === 'NIP' || $key === 'KRS') {
            $section = 'company';
        }

        // 7) Special handling for repeated "Telefon" fields (PHP 7.4 compatible)
        if (mb_strtolower($key, 'UTF-8') === 'telefon') {
            switch ($section) {
                case 'payments':
                    $key = 'Telefon (płatności)';
                    break;
                case 'helper':
                    $key = 'Telefon (pomoc)';
                    break;
                case 'it':
                    $key = 'Telefon (IT)';
                    break;
                default:
                    $key = 'Telefon (inne)';
                    break;
            }
        }

        // 8) Normalize slight variations of the same field
        // Handles "Jak nas znalazłeś ?:" and "Jak nas znalazłeś ?"
        if ($key === 'Jak nas znalazłeś ?:' || $key === 'Jak nas znalazłeś ?' || $key === 'Jak nas znalazłeś ?') {
            $key = 'Jak nas znalazłeś ?';
        }

        $result[$key] = $value;
    }

    return $result;
}

/**
 * Converts empty strings to NULL for database storage.
 */
function normalizeEmptyToNull($value): ?string
{
    if ($value === null) {
        return null;
    }

    $v = trim((string)$value);
    return $v === '' ? null : $v;
}
