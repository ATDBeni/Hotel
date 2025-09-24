<?php
header('Content-Type: application/json');

// Afișare erori pentru debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_config.php';

// Dacă nu există conexiune, trimite răspuns JSON cu eroare
if (!isset($conn) || $conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexiunea la baza de date a eșuat."]);
    exit;
}

// Query pentru rezervări + numele hotelului
$sql = "SELECT r.id, h.name AS hotel_name, r.client_name, r.client_email, 
               r.checkin_date, r.checkout_date
        FROM reservations r
        INNER JOIN hotels h ON r.hotel_id = h.id
        ORDER BY r.created_at DESC";

$result = $conn->query($sql);

// Dacă interogarea a eșuat, returnează mesaj de eroare
if (!$result) {
    echo json_encode(["status" => "error", "message" => "Eroare SQL: " . $conn->error]);
    exit;
}

// Construiește array-ul cu rezervări
$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

// Returnează datele în format JSON
echo json_encode([
    "status" => "success",
    "data" => $reservations
]);

$conn->close();
