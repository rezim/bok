<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a actual CSV or fake CSV
    if ($fileType != "csv") {
        echo "Sorry, only CSV files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
            importCsvToDatabase($target_file, $conn);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

function importCsvToDatabase($csvFile, $conn) {
    $file = fopen($csvFile, "r");
    fgetcsv($file); // Skip the header row

    while (($row = fgetcsv($file, 1000, ";")) !== FALSE) {
        // Convert the date to the correct format (dd.mm.yyyy to yyyy-mm-dd)
        $date_parts = explode('.', $row[3]);
        if (count($date_parts) == 3) {
            $date = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
        } else {
            $date = NULL;
        }

        // Convert the date_dodania to the correct format (dd.mm.yyyy hh:mm:ss to yyyy-mm-dd hh:mm:ss)
        $datetime_parts = explode(' ', $row[19]);
        $date_dodania_parts = explode('.', $datetime_parts[0]);
        if (count($date_dodania_parts) == 3) {
            $date_dodania = $date_dodania_parts[2] . '-' . $date_dodania_parts[1] . '-' . $date_dodania_parts[0] . ' ' . $datetime_parts[1];
        } else {
            $date_dodania = NULL;
        }

        // Convert the time to the correct format (hh:mm:ss)
        $time = date('H:i:s', strtotime($row[4]));

        // Replace commas with dots for numeric fields
        $ilosc = str_replace(',', '.', $row[13]);
        $cena = str_replace(',', '.', $row[14]);
        $kwota = str_replace(',', '.', $row[15]);

        // Check if the record already exists
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM cars_e100 WHERE numer_karty = ? AND data = ? AND czas = ? AND numer_samochodu = ?");
        $checkStmt->bind_param("ssss", $row[0], $date, $time, $row[6]);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count == 0) {
            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO cars_e100 (numer_karty, mobility, dzial, data, czas, gmt, numer_samochodu, kierowca, kraj, adres, brand, kategoria, stacja, ilosc, cena, kwota, waluta, usluga, paragon, data_dodania, obwod_stacji_paliw) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssssssssssss", $row[0], $row[1], $row[2], $date, $time, $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $ilosc, $cena, $kwota, $row[16], $row[17], $row[18], $date_dodania, $row[20]);

            if (!$stmt->execute()) {
                echo "Error inserting row: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Record already exists and was not imported.";
        }
    }

    fclose($file);
    echo "Data successfully imported to database.";
}

$query = "SELECT numer_karty, data, czas, numer_samochodu, kierowca, adres, brand, kategoria, ilosc, cena, kwota, waluta, usluga FROM cars_e100 ORDER BY data DESC";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload E100 CSV</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>Upload E100 CSV</h1>
    <form action="e100.php" method="post" enctype="multipart/form-data">
        Select CSV file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload CSV" name="submit">
    </form>
    <br>
    <a href="display_cars.php">Back to Cars</a>
    <h2>Cars E100 Data</h2>
    <table>
        <tr>
            <th>Numer Karty</th>
            <th>Data</th>
            <th>Czas</th>
            <th>Numer Samochodu</th>
            <th>Kierowca</th>
            <th>Adres</th>
            <th>Brand</th>
            <th>Kategoria</th>
            <th>Ilość</th>
            <th>Cena</th>
            <th>Kwota</th>
            <th>Waluta</th>
            <th>Usługa</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["numer_karty"]. "</td>
                        <td>" . $row["data"]. "</td>
                        <td>" . $row["czas"]. "</td>
                        <td>" . $row["numer_samochodu"]. "</td>
                        <td>" . $row["kierowca"]. "</td>
                        <td>" . $row["adres"]. "</td>
                        <td>" . $row["brand"]. "</td>
                        <td>" . $row["kategoria"]. "</td>
                        <td>" . $row["ilosc"]. "</td>
                        <td>" . $row["cena"]. "</td>
                        <td>" . $row["kwota"]. "</td>
                        <td>" . $row["waluta"]. "</td>
                        <td>" . $row["usluga"]. "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='13'>Brak wyników</td></tr>";
        }
        ?>
    </table>
</body>
</html>
