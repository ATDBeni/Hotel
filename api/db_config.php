<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_app_db";

// Creare conexiune
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificare conexiune
if ($conn->connect_error) {
    // În caz de eroare, returnează un răspuns JSON, nu un simplu text
    header('Content-Type: application/json');
    die(json_encode(["status" => "error", "message" => "Conexiune la baza de date esuata: " . $conn->connect_error]));
}
