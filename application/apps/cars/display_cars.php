<?php
// display_cars.php
include 'config.php';

$sql = "
    SELECT 
        c.id, 
        c.model, 
        c.VIN, 
        c.nr_rej, 
        c.paliwo, 
        c.Rok_produkcji, 
        c.kierowca, 
        COALESCE(cr.przebieg, 0) AS przebieg, 
        c.przegląd, 
        c.ubezpieczenie,
        c.data_ost_przegladu
    FROM cars c
    LEFT JOIN (
        SELECT 
            car_id, 
            przebieg 
        FROM cars_requests 
        WHERE (car_id, data_zdarzenia) IN (
            SELECT car_id, MAX(data_zdarzenia)
            FROM cars_requests
            GROUP BY car_id
        )
    ) cr ON c.id = cr.car_id
    WHERE c.status = 'aktywny'
    ORDER BY c.model";

$result = $conn->query($sql);

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
    <title>Wyświetlanie Tabeli Cars</title>
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
            cursor: pointer;
        }
        .link {
            color: green;
            text-decoration: underline;
        }
    </style>
    <script>
        function editRow(id) {
            window.location.href = 'addedit.php?id=' + id;
        }
        function viewRequests(car_id) {
            window.location.href = 'display_requests.php?car_id=' + car_id;
        }
    </script>
</head>
<body>
    <h1>Tabela Cars</h1>
    <a href="cars_statystyki.php">Statystyki paliwa</a>
    <br>
    <a href="e100.php">E100</a>
    <br><br>
    <a href="addedit.php">Dodaj Pojazd</a>
    <table>
        <tr>
            <th>Model</th>
            <th>VIN</th>
            <th>Nr Rejestracyjny</th>
            <th>Paliwo</th>
            <th>Rok</th>
            <th>Kierowca</th>
            <th>Przebieg</th>
            <th>Przegląd</th>
            <th>Ubezpieczenie</th>
            <th>Wymiana oleju</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td onclick=\"editRow(" . $row["id"] . ")\">" . $row["model"]. "</td>
                        <td onclick=\"editRow(" . $row["id"] . ")\">" . $row["VIN"]. "</td>
                        <td onclick=\"editRow(" . $row["id"] . ")\">" . $row["nr_rej"]. "</td>
                        <td onclick=\"editRow(" . $row["id"] . ")\">" . $row["paliwo"]. "</td>
                        <td onclick=\"editRow(" . $row["id"] . ")\">" . $row["Rok_produkcji"]. "</td>
                        <td onclick=\"editRow(" . $row["id"] . ")\">" . $row["kierowca"]. "</td>
                        <td class='link' onclick=\"viewRequests(" . $row["id"] . ")\">" . $row["przebieg"]. "</td>
                        <td " . highlightDate($row["przegląd"]) . " onclick=\"editRow(" . $row["id"] . ")\">" . $row["przegląd"]. "</td>
                        <td " . highlightDate($row["ubezpieczenie"]) . " onclick=\"editRow(" . $row["id"] . ")\">" . $row["ubezpieczenie"]. "</td>
                        <td onclick=\"editRow(" . $row["id"] . ")\">" . $row["data_ost_przegladu"]. "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Brak wyników</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
