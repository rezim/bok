<?php
include 'config.php';

// Sprawdź, czy jest przekazane ID (dla edycji)
$id = isset($_GET['id']) ? $_GET['id'] : '';
$model = $vin = $nr_rej = $paliwo = $kierowca = $status = $przeglad = $ubezpieczenie = $notatki = '';
$rok_produkcji = $data1rej = $moc = $własność = $koniec_leasingu = $data_ost_przegladu = '';

// Jeśli ID jest przekazane, pobierz dane z bazy
if ($id) {
    $sql = "SELECT * FROM cars WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $model = $row['model'];
        $vin = $row['VIN'];
        $nr_rej = $row['nr_rej'];
        $paliwo = $row['paliwo'];
        $kierowca = $row['kierowca'];
        $status = $row['status'];
        $przeglad = $row['przegląd'];
        $ubezpieczenie = $row['ubezpieczenie'];
        $notatki = $row['notatki'];
        $rok_produkcji = $row['Rok_produkcji'];
        $data1rej = $row['Data1rej'];
        $moc = $row['moc'];
        $własność = $row['własność'];
        $koniec_leasingu = $row['koniec_leasignu'];
        $data_ost_przegladu = $row['data_ost_przegladu'];
    }
}

// Zapisz dane po przesłaniu formularza
if ($_POST["isSubbmited"] == "true") {
    if (isset($_POST['delete'])) {
        $sql = "DELETE FROM cars WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: display_cars.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $model = isset($model) ? $model :  $_POST['model'];
        $vin = $_POST['vin'];
        $nr_rej = $_POST['nr_rej'];
        $paliwo = $_POST['paliwo'];
        $kierowca = $_POST['kierowca'];
        $status = $_POST['status'];
        $przeglad = $_POST['przeglad'];
        $ubezpieczenie = $_POST['ubezpieczenie'];
        $notatki = $_POST['notatki'];
        $rok_produkcji = $_POST['rok_produkcji'];
        $data1rej = $_POST['data1rej'];
        $moc = $_POST['moc'];
        $własność = $_POST['własność'];
        $koniec_leasingu = $_POST['koniec_leasingu'];
        $data_ost_przegladu = $_POST['data_ost_przegladu'];

        if ($id) {
            // Aktualizacja danych
            $sql = "UPDATE cars SET 
                        model='$model', 
                        VIN='$vin', 
                        nr_rej='$nr_rej', 
                        paliwo='$paliwo', 
                        kierowca='$kierowca', 
                        status='$status', 
                        przeglad='$przeglad', 
                        ubezpieczenie='$ubezpieczenie', 
                        notatki='$notatki',
                        Rok_produkcji='$rok_produkcji',
                        Data1rej='$data1rej',
                        moc='$moc',
                        wlasnosc='$własność',
                        koniec_leasignu=NULLIF('$koniec_leasingu', ''),
                        data_ost_przegladu='$data_ost_przegladu'
                    WHERE id=$id";
        } else {
            // Wstawienie nowych danych
            $sql = "INSERT INTO cars (model, VIN, nr_rej, paliwo, kierowca, status, przegląd, ubezpieczenie, notatki, Rok_produkcji, Data1rej, moc, własność, koniec_leasignu, data_ost_przegladu) 
                    VALUES ('$model', '$vin', '$nr_rej', '$paliwo', '$kierowca', '$status', '$przeglad', '$ubezpieczenie', '$notatki', '$rok_produkcji', '$data1rej', '$moc', '$własność', NULLIF('$koniec_leasingu', ''), '$data_ost_przegladu')";
        }

        if ($conn->query($sql) === TRUE) {
            header("Location: display_cars.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj/Edytuj Samochód</title>
</head>
<body>
    <h1><?php echo $id ? "Edytuj" : "Dodaj"; ?> Samochód</h1>
    <form method="post" action="">
        <label for="model">Model:</label>
        <input type="text" id="model" name="model" value="<?php echo $model; ?>" required><br>

        <label for="vin">VIN:</label>
        <input type="text" id="vin" name="vin" value="<?php echo $vin; ?>" required><br>

        <label for="nr_rej">Nr Rejestracyjny:</label>
        <input type="text" id="nr_rej" name="nr_rej" value="<?php echo $nr_rej; ?>" required><br>

        <label for="paliwo">Paliwo:</label>
        <select id="paliwo" name="paliwo" required>
            <option value="benzyna" <?php if ($paliwo == 'benzyna') echo 'selected'; ?>>Benzyna</option>
            <option value="diesel" <?php if ($paliwo == 'diesel') echo 'selected'; ?>>Diesel</option>
            <option value="hybryda" <?php if ($paliwo == 'hybryda') echo 'selected'; ?>>Hybryda</option>
            <option value="lpg" <?php if ($paliwo == 'lpg') echo 'selected'; ?>>LPG</option>
        </select><br>

        <label for="kierowca">Kierowca:</label>
        <input type="text" id="kierowca" name="kierowca" value="<?php echo $kierowca; ?>"><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="aktywny" <?php if ($status == 'aktywny') echo 'selected'; ?>>Aktywny</option>
            <option value="nieaktywny" <?php if ($status == 'nieaktywny') echo 'selected'; ?>>Nieaktywny</option>
            <option value="serwis" <?php if ($status == 'serwis') echo 'selected'; ?>>Serwis</option>
        </select><br>

        <label for="przeglad">Przegląd:</label>
        <input type="date" id="przeglad" name="przeglad" value="<?php echo $przeglad; ?>"><br>

        <label for="ubezpieczenie">Ubezpieczenie:</label>
        <input type="date" id="ubezpieczenie" name="ubezpieczenie" value="<?php echo $ubezpieczenie; ?>"><br>

        <label for="rok_produkcji">Rok produkcji:</label>
        <input type="number" id="rok_produkcji" name="rok_produkcji" value="<?php echo $rok_produkcji; ?>" required><br>

        <label for="data1rej">Data pierwszej rejestracji:</label>
        <input type="date" id="data1rej" name="data1rej" value="<?php echo $data1rej; ?>" required><br>

        <label for="moc">Moc:</label>
        <input type="number" id="moc" name="moc" value="<?php echo $moc; ?>" required><br>

        <label for="własność">Własność:</label>
        <select id="własność" name="własność" required>
            <option value="własny" <?php if ($własność == 'własny') echo 'selected'; ?>>Własny</option>
            <option value="leasing" <?php if ($własność == 'leasing') echo 'selected'; ?>>Leasing</option>
        </select><br>

        <label for="koniec_leasingu">Koniec leasingu:</label>
        <input type="date" id="koniec_leasingu" name="koniec_leasingu" value="<?php echo $koniec_leasingu; ?>"><br>

        <label for="data_ost_przegladu">Data ostatniej wymiany oleju:</label>
        <input type="date" id="data_ost_przegladu" name="data_ost_przegladu" value="<?php echo $data_ost_przegladu; ?>"><br>

        <label for="notatki">Notatki:</label>
        <textarea id="notatki" name="notatki"><?php echo $notatki; ?></textarea><br>

        <input type="hidden" name="isSubbmited" value="true" />

        <button type="submit"><?php echo $id ? "Zaktualizuj" : "Dodaj"; ?></button>
        <?php if ($id): ?>
            <button type="submit" name="delete" value="delete">Usuń</button>
        <?php endif; ?>
        <button type="button" onclick="window.location.href='display_cars.php'">Anuluj</button>
    </form>
</body>
</html>
