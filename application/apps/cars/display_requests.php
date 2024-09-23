<?php
// display_requests.php
include 'config.php';

$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;
$model = '';
$nr_rej = '';
$sum_wartosc = 0; // Zmienna do przechowywania sumy wartości
$selected_year = isset($_GET['year']) ? intval($_GET['year']) : '';
$selected_month = isset($_GET['month']) ? intval($_GET['month']) : '';

if ($car_id > 0) {
    // Pobierz dane samochodu
    $sql_car = "SELECT model, nr_rej FROM cars WHERE id = $car_id";
    $result_car = $conn->query($sql_car);
    if ($result_car->num_rows > 0) {
        $car = $result_car->fetch_assoc();
        $model = $car['model'];
        $nr_rej = $car['nr_rej'];
    } else {
        echo "Nie znaleziono pojazdu o podanym ID.";
        exit;
    }

    // Zbuduj zapytanie SQL z uwzględnieniem filtrów
    $sql = "SELECT id, przebieg, data_zdarzenia, usługa, wartość, nr_faktury, kto_odpowiada, nazwa_firmy FROM cars_requests WHERE car_id = $car_id";
    if ($selected_year) {
        $sql .= " AND YEAR(data_zdarzenia) = $selected_year";
    }
    if ($selected_month) {
        $sql .= " AND MONTH(data_zdarzenia) = $selected_month";
    }
    $result = $conn->query($sql);
} else {
    echo "Nieprawidłowy ID pojazdu.";
    exit;
}

// Lista miesięcy po polsku
$months = [
    1 => 'Styczeń',
    2 => 'Luty',
    3 => 'Marzec',
    4 => 'Kwiecień',
    5 => 'Maj',
    6 => 'Czerwiec',
    7 => 'Lipiec',
    8 => 'Sierpień',
    9 => 'Wrzesień',
    10 => 'Październik',
    11 => 'Listopad',
    12 => 'Grudzień'
];

// Pobierz dostępne lata i miesiące
$years = [];
$sql_dates = "SELECT DISTINCT YEAR(data_zdarzenia) AS year FROM cars_requests WHERE car_id = $car_id ORDER BY year";
$result_dates = $conn->query($sql_dates);
if ($result_dates->num_rows > 0) {
    while ($row_dates = $result_dates->fetch_assoc()) {
        if (!in_array($row_dates['year'], $years)) {
            $years[] = $row_dates['year'];
        }
    }
}

function highlightDate($date) {
    if ($date) {
        $currentDate = new DateTime();
        $dateToCheck = new DateTime($date);
        $currentMonth = $currentDate->format('Y-m');
        $nextMonth = $currentDate->modify('first day of next month')->format('Y-m');
        
        if ($dateToCheck->format('Y-m') == $currentMonth || $dateToCheck->format('Y-m') == $nextMonth) {
            return 'style="color: red;"';
        }
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyświetlanie Zgłoszeń dla Pojazdu</title>
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
    </style>
</head>
<body>
    <h1>Zgłoszenia dla Pojazdu: <?php echo $model . " " . $nr_rej; ?></h1>
    <button onclick="window.location.href='display_cars.php'">Powrót do Tabeli Cars</button>
    <button onclick="window.location.href='addedit_request.php?car_id=<?php echo $car_id; ?>'">Dodaj Zgłoszenie</button>
    
    <form method="get" action="">
        <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
        <label for="year">Rok:</label>
        <select name="year" id="year">
            <option value="">Wszystkie</option>
            <?php foreach ($years as $year): ?>
                <option value="<?php echo $year; ?>" <?php if ($year == $selected_year) echo 'selected'; ?>><?php echo $year; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="month">Miesiąc:</label>
        <select name="month" id="month">
            <option value="">Wszystkie</option>
            <?php foreach ($months as $month_num => $month_name): ?>
                <option value="<?php echo $month_num; ?>" <?php if ($month_num == $selected_month) echo 'selected'; ?>><?php echo $month_name; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtruj</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Przebieg</th>
            <th>Data Zdarzenia</th>
            <th>Usługa</th>
            <th>Wartość</th>
            <th>Nr Faktury</th>
            <th>Kto Odpowiada</th>
            <th>Nazwa Firmy</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $sum_wartosc += $row["wartość"]; // Dodaj wartość do sumy
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td>" . $row["przebieg"]. "</td>
                        <td>" . $row["data_zdarzenia"]. "</td>
                        <td>" . $row["usługa"]. "</td>
                        <td>" . $row["wartość"]. "</td>
                        <td>" . $row["nr_faktury"]. "</td>
                        <td>" . $row["kto_odpowiada"]. "</td>
                        <td>" . $row["nazwa_firmy"]. "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Brak wyników</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <h3>Łączna wartość: <?php echo number_format($sum_wartosc, 2); ?> PLN</h3>
</body>
</html>
