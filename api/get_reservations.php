<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Verifică conexiunea
if ($conn->connect_error) {
    echo json_encode(["error" => "Conexiune eșuată: " . $conn->connect_error]);
    exit();
}

// Interogare SQL pentru a prelua rezervările, împreună cu numele hotelului
$sql = "SELECT 
            r.id, 
            h.nume AS nume_hotel, 
            r.nume_client, 
            r.email_client, 
            r.data_cazare, 
            r.data_plecare,
            r.data_rezervarii
        FROM 
            rezervari r
        JOIN 
            hoteluri h ON r.hotel_id = h.id
        ORDER BY 
            r.data_rezervarii DESC";

$result = $conn->query($sql);

$reservations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}

$conn->close();

echo json_encode($reservations);
