<?php
// Datele de conectare la baza de date
define('DB_SERVER', 'localhost'); 
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'hotel_app_db');

// Crearea conexiunii la baza de date
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificarea conexiunii
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Conexiune eșuată: " . $conn->connect_error]);
    exit;
}
