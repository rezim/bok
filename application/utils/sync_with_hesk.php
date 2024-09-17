<?php

$local_conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Sprawdzenie połączenia
if ($local_conn->connect_error) {
    die("Połączenie z lokalną bazą danych nieudane: " . $local_conn->connect_error);
}

// Plik logu
$log_file = '../../public_html/log/hesk-bok.log';

// Otwieranie pliku logu w trybie zapisu, co usuwa wcześniejsze dane
$log_handle = null; // fopen($log_file, 'w');

// Funkcja do zapisywania logu
function log_message($message, $log_handle) {
//    fwrite($log_handle, $message . "\n");
    echo $message . "\n";
}

// Połączenie z bazą danych HESK
$conn = new mysqli(HESK_HOST, HESK_DB_USER, HESK_DB_PASSWORD, HESK_DB_NAME);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    log_message("Połączenie nieudane: " . $conn->connect_error, $log_handle);
    fclose($log_handle);
    die();
}

$notificationIdsToUpdateInHESK = array();

// Ustawienie kodowania znaków na UTF-8
$conn->set_charset("utf8mb4");

// Etap 1: Przetwarzanie zgłoszeń z status != 3
$sql = "SELECT id, name, dt, trackid, message, custom1, custom2, custom3, closedat, email, subject, priority, status FROM hesk_tickets WHERE status != 3 ORDER BY id ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $local_conn->set_charset("utf8mb4");

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $dt = $row['dt'];
        $trackid = $row['trackid'];
        $message = $row['message'];
        $custom1 = $row['custom1'];
        $custom2 = $row['custom2'];
        $custom3 = $row['custom3'];
        $closedat = $row['closedat'];
        $email = $row['email'];
        $subject = $row['subject'];
        $priority = $row['priority'];

        $date_insert = date('Y-m-d H:i:s', strtotime($dt));
        // 2 - w trakcie realizacji, 4 - nierozliczone
        $status_update = is_null($closedat) ? 2 : 4;

        $check_sql = "SELECT * FROM notifications WHERE trackid = '$trackid'";
        $check_result = $local_conn->query($check_sql);

        $serial = null;
        $rowid_client = null;
        $rowid_agreements = null;


        $needle = "SN:";
        $position = strpos($message, $needle);
        $serial = '-';
        if ($position !== false) {
            $position += strlen($needle);
            $remainingString = substr($message, $position);
            $serial = strtok($remainingString, " <");
        }

        // Pobranie wartości serial i rowidclient z tabeli agreements
        $serialLike = $custom1 !== '' ? $custom1 : $serial;
        $serial_sql = "SELECT serial, rowidclient, rowid FROM agreements WHERE serial LIKE '%$serialLike%' and activity=1";
        $serial_result = $local_conn->query($serial_sql);
        if ($serial_result->num_rows == 1) {
            $serial_row = $serial_result->fetch_assoc();
            $serial = $serial_row['serial'];
            $rowid_client = $serial_row['rowidclient'];
            $rowid_agreements = $serial_row['rowid'];  // Dodanie rowid do zmiennej
        } elseif ($serial_result->num_rows > 1) {
            log_message("Znaleziono wiele dopasowań dla custom1: $custom1. Numer seryjny nie zostanie dodany.", $log_handle);
        }

        $name = $local_conn->real_escape_string($name);
        $trackid = $local_conn->real_escape_string($trackid);
        $message = $local_conn->real_escape_string($message);
        $custom1 = $local_conn->real_escape_string($custom1);
        $custom2 = $local_conn->real_escape_string($custom2);
        $custom3 = $local_conn->real_escape_string($custom3);
        $email = $local_conn->real_escape_string($email);
        $subject = $local_conn->real_escape_string($subject);
        $date_insert = $local_conn->real_escape_string($date_insert);
        $priority = $local_conn->real_escape_string($priority);

        if ($check_result->num_rows == 0) {
            $insert_sql = "INSERT INTO notifications (osobazglaszajaca, trackid, activity, status, tresc_wiadomosci, serial, rowid_client, rowid_agreements, email, temat, nr_telefonu, date_insert, addres_custom3, rowid_priority) VALUES ('$name', '$trackid', 1, $status_update, '$message', ";
            if ($serial && $rowid_client) {
                $insert_sql .= "'$serial', '$rowid_client', '$rowid_agreements', '$email', '$subject', '$custom2', '$date_insert', '$custom3', '$priority')";
            } else {
                $insert_sql .= "NULL, NULL, NULL, '$email', '$subject', '$custom2', '$date_insert', '$custom3', '$priority')";
            }

            if ($local_conn->query($insert_sql) === TRUE && $serial) {
                log_message("Nowe zgłoszenie zostało dodane do bazy danych bok.", $log_handle);

                // Pobranie ostatnio dodanego ID
                $last_id = $local_conn->insert_id;

                $notificationIdsToUpdateInHESK[] = $last_id;

            } else {
                log_message("Błąd: " . $insert_sql . " - " . $local_conn->error, $log_handle);
            }
        } else {
            $update_sql = "UPDATE notifications SET osobazglaszajaca='$name', tresc_wiadomosci='$message'";
            if ($serial && $rowid_client) {
                $update_sql .= ",serial='$serial', rowid_client='$rowid_client', rowid_agreements='$rowid_agreements', email='$email', temat='$subject', nr_telefonu='$custom2', date_insert='$date_insert', addres_custom3='$custom3', rowid_priority='$priority', status=$status_update ";
            } else {
                $update_sql .= ",email='$email', temat='$subject', nr_telefonu='$custom2', date_insert='$date_insert', addres_custom3='$custom3', rowid_priority='$priority', status=$status_update ";
            }

            $update_sql .= "WHERE trackid='$trackid'";

            // jeżeli aktualizacja z hesk na status nie rozliczone, aktualizuj tylko jeżeli w bazie nie zamknięte
            if ($status_update === 4) {
                $update_sql .= " and status <> 3";
            }

            if ($local_conn->query($update_sql) === TRUE) {
                log_message("Zaktualizowano zgłoszenie o trackid: $trackid", $log_handle);
            } else {
                log_message("Błąd aktualizacji: " . $update_sql . " - " . $local_conn->error, $log_handle);
            }
        }
    }

    $local_conn->close();
} else {
    log_message("Brak nowych zgłoszeń.", $log_handle);
}

// Etap 2: Przetwarzanie zamkniętych zgłoszeń, które mogą wymagać aktualizacji
$sql_closed = "SELECT trackid, closedat FROM hesk_tickets WHERE status = 3 AND closedat > NOW() - INTERVAL 30 DAY ORDER BY id ASC";
$result_closed = $conn->query($sql_closed);

if ($result_closed->num_rows > 0) {
    $local_conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $local_conn->set_charset("utf8mb4");

    while ($row_closed = $result_closed->fetch_assoc()) {
        $trackid = $row_closed['trackid'];
        $closedat = $row_closed['closedat'];

        // Ustalenie statusu na podstawie closedat
        // 2 - w trakcie realizacji, 4 - nierozliczone
        $status_update = is_null($closedat) ? 2 : 4;

        // Sprawdzenie obecnego statusu w BOK
        $check_status_sql = "SELECT status FROM notifications WHERE trackid='$trackid'";
        $check_status_result = $local_conn->query($check_status_sql);
        if ($check_status_result->num_rows > 0) {
            $current_status = $check_status_result->fetch_assoc()['status'];

            // Aktualizacja statusu w tabeli notifications, tylko jeśli jest to konieczne
            if ($current_status != $status_update) {

                $update_sql = "UPDATE notifications SET status=$status_update WHERE trackid='$trackid'";

                if ($status_update === 4) {
                    $update_sql .= " and status <> 3";
                }

                if ($local_conn->query($update_sql) === TRUE) {
                    log_message("Zaktualizowano status na $status_update dla zgłoszenia o trackid: $trackid", $log_handle);
                } else {
                    log_message("Błąd aktualizacji: " . $update_sql . " - " . $local_conn->error, $log_handle);
                }
            }
        }
    }

    $local_conn->close();
}

$conn->close();

// aktualizacja HESK, dodanie notatek z danymi klientów

$model = 'notification';
$controller = 'notificationsController';
$action = 'updateHeskNotification';
$queryString = array('notemplate');
$dispatch = new $controller($model, $controller, $action, $queryString);

if ((int)method_exists($controller, $action)) {
    foreach ($notificationIdsToUpdateInHESK as $last_id) {


        $result = call_user_func_array(array($dispatch, $action), [$last_id]);

        log_message("Dodano notatkę w HESK dla zgłoszenia: " . $last_id, $log_handle);

    }
}


//fclose($log_handle);

