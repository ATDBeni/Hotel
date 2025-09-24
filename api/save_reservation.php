<?php
header('Content-Type: application/json');

// Activăm raportarea erorilor (doar pentru dezvoltare!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificăm dacă toate câmpurile necesare sunt trimise
    if (!empty($_POST['hotel_id']) && !empty($_POST['nume_client']) && !empty($_POST['email_client']) && !empty($_POST['data_cazare']) && !empty($_POST['data_plecare'])) {
        
        $hotel_id = $_POST['hotel_id'];
        $client_name = $_POST['nume_client'];
        $client_email = $_POST['email_client'];
        $checkin_date = $_POST['data_cazare'];
        $checkout_date = $_POST['data_plecare'];

        // Validare simplă: data check-in < data check-out
        if (strtotime($checkin_date) >= strtotime($checkout_date)) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Data de plecare trebuie să fie după data de cazare."]);
            exit;
        }

        $sql = "INSERT INTO reservations (hotel_id, client_name, client_email, checkin_date, checkout_date)
                VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("issss", $hotel_id, $client_name, $client_email, $checkin_date, $checkout_date);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Rezervarea a fost efectuată cu succes!"]);
            } else {
                http_response_code(500);
                echo json_encode(["status" => "error", "message" => "Eroare la salvarea rezervării: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Eroare pregătire interogare: " . $conn->error]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Toate câmpurile sunt obligatorii."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Metodă de cerere invalidă."]);
}

$conn->close();
exit;
