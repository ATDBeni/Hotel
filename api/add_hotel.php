<?php
session_start();

header('Content-Type: application/json');

// Activăm afișarea erorilor pentru debugging (doar în dezvoltare!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Neautorizat."]);
    exit;
}

require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['description']) && !empty($_POST['image_url']) && !empty($_POST['price'])) {
        
        $name = $_POST['name'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $image_url = $_POST['image_url'];
        $price = $_POST['price'];

        $sql = "INSERT INTO hotels (name, location, description, image_url, price) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssd", $name, $location, $description, $image_url, $price);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Hotelul a fost adăugat cu succes!"]);
            } else {
                http_response_code(500);
                echo json_encode(["success" => false, "message" => "Eroare SQL: " . $stmt->error]);
            }

            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Eroare pregătire interogare: " . $conn->error]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Toate câmpurile sunt obligatorii."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Metodă invalidă."]);
}

$conn->close();
exit;
