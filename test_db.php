<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_config.php';

echo "Conexiune reușită la baza de date!<br>";

$result = $conn->query("SELECT COUNT(*) as total FROM hotels");
if ($result) {
    $row = $result->fetch_assoc();
    echo "Ai " . $row['total'] . " hoteluri în baza de date.";
} else {
    echo "Eroare la interogare: " . $conn->error;
}
