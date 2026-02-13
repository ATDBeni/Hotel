<?php

session_start();


header('Content-Type: application/json');

$admin_username = "admin";
$admin_password = "password123";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verificam credențialele
    if ($username === $admin_username && $password === $admin_password) {

        $_SESSION['loggedin'] = true;
        echo json_encode(["status" => "success", "message" => "Autentificare reusita!"]);
    } else {
        
        echo json_encode(["status" => "error", "message" => "Nume de utilizator sau parolă incorectă."]);
    }
} else {
   
    echo json_encode(["status" => "error", "message" => "Metodă de cerere invalidă."]);
}
