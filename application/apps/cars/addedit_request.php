<?php
// addedit_request.php
include 'config.php';

$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;
$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$request = null;

if ($request_id > 0) {
    $sql = "SELECT * FROM cars_requests WHERE id = $request_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $request = $result->fetch_assoc();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST["car_id"];
    $przebieg = $_POST["przebieg"];
    $data_zdarzenia = $_POST["data_zdarzenia"];
    $usługa = $_POST["usługa"];
    $wartość = $_POST["wartość"];
    $nr_faktury = $_POST["nr_faktury"];
    $kto_odpowiada = $_POST["kto_odpowiada"];
    $nazwa_firmy = $_POST["nazwa_firmy"];

    if ($request_id > 0) {
        // Update existing request
        $sql = "UPDATE cars_requests SET przebieg='$przebieg', data_zdarzenia='$data_zdarzenia', usługa='$usługa', wartość='$wartość', nr_faktury='$nr_faktury', kto_odpowiada='$kto_odpowiada', nazwa_firmy='$nazwa_firmy' WHERE id=$request_id";
    } else {
        // Add new request
        $sql = "INSERT INTO cars_requests (car_id, przebieg, data_zdarzenia, usługa, wartość, nr_faktury, kto_odpowiada, nazwa_firmy) VALUES ('$car_id', '$przebieg', '$data_zdarzenia', '$usługa', '$wartość', '$nr_faktury', '$kto_odpowiada', '$nazwa_firmy')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: display_requests.php?car_id=$car_id");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $request_id > 0 ? "Edytuj Zgłoszenie" : "Dodaj Zgłoszenie"; ?></title>
</head>
<body>
    <h1><?php echo $request_id > 0 ? "Edytuj Zgłoszenie" : "Dodaj Zgłoszenie"; ?></h1>
    <form method="post" action="">
        <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
        <div>
            <label for="przebieg">Przebieg:</label>
            <input type="text" id="przebieg" name="przebieg" value="<?php echo $request['przebieg'] ?? ''; ?>">
        </div>
        <div>
            <label for="data_zdarzenia">Data Zdarzenia:</label>
            <input type="date" id="data_zdarzenia" name="data_zdarzenia" value="<?php echo $request['data_zdarzenia'] ?? ''; ?>">
        </div>
        <div>
            <label for="usługa">Usługa:</label>
            <input type="text" id="usługa" name="usługa" value="<?php echo $request['usługa'] ?? ''; ?>">
        </div>
        <div>
            <label for="wartość">Wartość:</label>
            <input type="text" id="wartość" name="wartość" value="<?php echo $request['wartość'] ?? ''; ?>">
        </div>
        <div>
            <label for="nr_faktury">Nr Faktury:</label>
            <input type="text" id="nr_faktury" name="nr_faktury" value="<?php echo $request['nr_faktury'] ?? ''; ?>">
        </div>
        <div>
            <label for="kto_odpowiada">Kto Odpowiada:</label>
            <input type="text" id="kto_odpowiada" name="kto_odpowiada" value="<?php echo $request['kto_odpowiada'] ?? ''; ?>">
        </div>
        <div>
            <label for="nazwa_firmy">Nazwa Firmy:</label>
            <input type="text" id="nazwa_firmy" name="nazwa_firmy" value="<?php echo $request['nazwa_firmy'] ?? ''; ?>">
        </div>
        <div>
            <button type="submit"><?php echo $request_id > 0 ? "Zapisz Zmiany" : "Dodaj Zgłoszenie"; ?></button>
        </div>
    </form>
    <button onclick="window.location.href='display_requests.php?car_id=<?php echo $car_id; ?>'">Powrót do Zgłoszeń</button>
</body>
</html>
