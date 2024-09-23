<?php
include 'config.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id) {
    $sql = "DELETE FROM cars WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: display_cars.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
