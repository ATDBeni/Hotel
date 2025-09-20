<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Verifică conexiunea
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexiune eșuată: " . $conn->connect_error]);
    exit();
}

// Verifică dacă ID-ul rezervării a fost primit
if (!isset($_POST['reservation_id'])) {
    echo json_encode(["status" => "error", "message" => "ID-ul rezervării lipsește."]);
    exit();
}

$reservation_id = $_POST['reservation_id'];

// Pregătește și execută interogarea SQL pentru ștergere
$sql = "DELETE FROM rezervari WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reservation_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Rezervare ștearsă cu succes."]);
} else {
    echo json_encode(["status" => "error", "message" => "Eroare la ștergerea rezervării: " . $stmt->error]);
}

$stmt->close();
$conn->close();
