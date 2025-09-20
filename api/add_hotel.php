<?php
// Pornim sesiunea pentru a gestiona datele de login
session_start();

// Asigurăm că doar administratorii autentificați pot accesa acest script
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.html");
    exit;
}

// Setăm antetul pentru a returna un răspuns JSON
header('Content-Type: application/json');

// Includem fișierul de configurare a bazei de date
require_once 'db_config.php';

// Verificăm dacă cererea este de tip POST și dacă toate câmpurile sunt completate
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificăm dacă toate câmpurile necesare sunt prezente
    if (isset($_POST['name']) && isset($_POST['location']) && isset($_POST['description']) && isset($_POST['image_url']) && isset($_POST['price'])) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $image_url = $_POST['image_url'];
        $price = $_POST['price'];

        // Pregătim interogarea SQL pentru a insera datele în baza de date
        $sql = "INSERT INTO hotels (name, location, description, image_url, price) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Legăm parametrii la interogare
            $stmt->bind_param("ssssd", $name, $location, $description, $image_url, $price);

            // Executăm interogarea
            if ($stmt->execute()) {
                // Returnăm un răspuns de succes în format JSON
                echo json_encode(["success" => true, "message" => "Hotelul a fost adăugat cu succes!"]);
            } else {
                // Returnăm un răspuns de eroare în format JSON
                echo json_encode(["success" => false, "message" => "Eroare la adăugarea hotelului: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Eroare de pregătire a interogării: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Toate câmpurile formularului sunt obligatorii."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Metodă de cerere invalidă."]);
}

$conn->close();
