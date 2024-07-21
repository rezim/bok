<?php
include 'config.php';

// Pobierz lata dostępne w tabeli cars_e100
$yearsSql = "SELECT DISTINCT YEAR(data) as year FROM cars_e100 ORDER BY year DESC";
$yearsResult = $conn->query($yearsSql);

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

// Sprawdź, czy filtr został ustawiony
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';

// Zapytanie SQL z filtrem na rok i miesiąc, jeśli są ustawione
$sql = "SELECT cars.nr_rej, cars.kierowca, cars.model, 
               IFNULL(SUM(cars_e100.kwota), 0) AS koszty_paliwa,
               IFNULL(SUM(cars_e100.ilosc), 0) AS ilosc_paliwa
        FROM cars
        LEFT JOIN cars_e100 ON cars.nr_rej = cars_e100.numer_samochodu";

if ($selectedYear && $selectedMonth) {
    $sql .= " WHERE YEAR(cars_e100.data) = '$selectedYear' AND MONTH(cars_e100.data) = '$selectedMonth'";
} elseif ($selectedYear) {
    $sql .= " WHERE YEAR(cars_e100.data) = '$selectedYear'";
} elseif ($selectedMonth) {
    $sql .= " WHERE MONTH(cars_e100.data) = '$selectedMonth'";
}

$sql .= " GROUP BY cars.nr_rej, cars.kierowca, cars.model";

$result = $conn->query($sql);

// Zmienna do przechowywania sumy kosztów paliwa
$totalKosztyPaliwa = 0;

// Tablica do przechowywania miesięcznych kosztów paliwa
$monthlyCosts = array_fill(1, 12, 0);

if ($selectedYear) {
    $monthlySql = "SELECT MONTH(data) as month, IFNULL(SUM(kwota), 0) as monthly_cost
                   FROM cars_e100
                   WHERE YEAR(data) = '$selectedYear'
                   GROUP BY MONTH(data)";
    $monthlyResult = $conn->query($monthlySql);
    if ($monthlyResult->num_rows > 0) {
        while ($row = $monthlyResult->fetch_assoc()) {
            $monthlyCosts[$row['month']] = $row['monthly_cost'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statystyki Samochodów</title>
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
        .chart-container {
            width: 80%;
            margin: 0 auto;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Statystyki Samochodów</h1>

    <form method="GET" action="">
        <label for="year">Wybierz rok:</label>
        <select name="year" id="year">
            <option value="">Wszystkie lata</option>
            <?php
            if ($yearsResult->num_rows > 0) {
                while($row = $yearsResult->fetch_assoc()) {
                    $selected = $selectedYear == $row['year'] ? 'selected' : '';
                    echo "<option value='{$row['year']}' $selected>{$row['year']}</option>";
                }
            }
            ?>
        </select>
        
        <label for="month">Wybierz miesiąc:</label>
        <select name="month" id="month">
            <option value="">Wszystkie miesiące</option>
            <?php
            foreach ($months as $num => $name) {
                $selected = $selectedMonth == $num ? 'selected' : '';
                echo "<option value='$num' $selected>$name</option>";
            }
            ?>
        </select>
        <button type="submit">Filtruj</button>
    </form>

    <a href="display_cars.php">Powrót do Cars</a>

    <table>
        <tr>
            <th>Nr Rejestracyjny</th>
            <th>Kierowca</th>
            <th>Model</th>
            <th>Koszty Paliwa</th>
            <th>Ilość Paliwa</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $totalKosztyPaliwa += $row["koszty_paliwa"]; // Dodaj wartość do sumy
                echo "<tr>
                        <td>" . $row["nr_rej"]. "</td>
                        <td>" . $row["kierowca"]. "</td>
                        <td>" . $row["model"]. "</td>
                        <td>" . number_format($row["koszty_paliwa"], 2, ',', ' ') . " PLN</td>
                        <td>" . number_format($row["ilosc_paliwa"], 2, ',', ' ') . " L</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Brak wyników</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <h3>Łączne Koszty Paliwa: <?php echo number_format($totalKosztyPaliwa, 2, ',', ' '); ?> PLN</h3>
    <br>

    <div class="chart-container">
        <canvas id="monthlyCostsChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('monthlyCostsChart').getContext('2d');
        var monthlyCostsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_values($months)); ?>,
                datasets: [{
                    label: 'Koszty Paliwa',
                    data: <?php echo json_encode(array_values($monthlyCosts)); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
