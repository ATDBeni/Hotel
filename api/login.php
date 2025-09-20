<?php
// Porneste sesiunea PHP
session_start();

// Seteaza capul de raspuns ca JSON
header('Content-Type: application/json');

// Definim credențialele de administrator
$admin_username = "admin";
$admin_password = "password123";

// Verificam daca cererea este de tip POST si daca datele au fost trimise
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verificam credențialele
    if ($username === $admin_username && $password === $admin_password) {
        // Autentificare reusita, setam o variabila de sesiune
        $_SESSION['loggedin'] = true;
        echo json_encode(["status" => "success", "message" => "Autentificare reusita!"]);
    } else {
        // Autentificare esuata
        echo json_encode(["status" => "error", "message" => "Nume de utilizator sau parolă incorectă."]);
    }
} else {
    // Cererea nu este de tip POST
    echo json_encode(["status" => "error", "message" => "Metodă de cerere invalidă."]);
}
