<?php
// Start the PHP session
session_start();

// Set the response header as JSON
header('Content-Type: application/json');

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Send a success message back to the client
echo json_encode(["status" => "success", "message" => "Deconectare reușită!"]);
