<?php
header('Content-Type: application/json');


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db_config.php';

if (!isset($conn) || $conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexiunea la baza de date a eșuat."]);
    exit;
}


$sql = "SELECT r.id, h.name AS hotel_name, r.client_name, r.client_email, 
               r.checkin_date, r.checkout_date
        FROM reservations r
        INNER JOIN hotels h ON r.hotel_id = h.id
        ORDER BY r.created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["status" => "error", "message" => "Eroare SQL: " . $conn->error]);
    exit;
}

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $reservations
]);

$conn->close();
