
<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Verifică dacă există o conexiune la baza de date
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexiune eșuată: " . $conn->connect_error]));
}

$sql = "SELECT id, nume, descriere, imagine, rating FROM hotels";
$result = $conn->query($sql);

$hotels = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hotels[] = $row;
    }
}

// Returnează datele ca JSON
echo json_encode($hotels);

$conn->close();
