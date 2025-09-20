<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Include fișierul de configurare a bazei de date
require_once 'db_config.php';

$hotels = [];
$conn = null;

try {
    // Creează conexiunea la baza de date
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Verifică conexiunea
    if ($conn->connect_error) {
        throw new Exception("Conexiune eșuată: " . $conn->connect_error);
    }

    // Interogare pentru a prelua toate hotelurile
    $sql = "SELECT id, name, location, description, image_url, price FROM hotels";
    $result = $conn->query($sql);

    // Verifică dacă există rezultate
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hotels[] = $row;
        }
    }

    // Returnează rezultatul ca JSON
    echo json_encode($hotels);
} catch (Exception $e) {
    // În cazul unei erori, returnează un mesaj de eroare în format JSON
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if ($conn) {
        $conn->close();
    }
}
