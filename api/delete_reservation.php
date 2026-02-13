<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'db_config.php';

$response = [];
$conn = null;

try {
    // Creează conexiunea
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        throw new Exception("Conexiune eșuată: " . $conn->connect_error);
    }

    // Interogare completă pentru rezervări + hoteluri
    $sql = "
        SELECT 
            r.id,
            h.name AS hotel_name,
            r.client_name,
            r.client_email,
            r.checkin_date,
            r.checkout_date
        FROM rezervari r
        INNER JOIN hotels h ON r.hotel_id = h.id
        ORDER BY r.id DESC
    ";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Eroare SQL: " . $conn->error);
    }

    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }

    $response = [
        "status" => "success",
        "count" => count($reservations),
        "data" => $reservations
    ];
} catch (Exception $e) {
    $response = [
        "status" => "error",
        "message" => $e->getMessage()
    ];
} finally {
    if ($conn) {
        $conn->close();
    }
}

echo json_encode($response);
