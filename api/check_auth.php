<?php
// Start the PHP session
session_start();

// Check if the user is not logged in.
// If the session variable 'loggedin' is not set or is not true, redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page
    header('Location: ../login.html');
    // Stop script execution to ensure the redirect works
    exit;
}
