<?php
// Set the content type to JSON to ensure the browser interprets the response correctly
header('Content-Type: application/json');

// Include the database configuration file
require_once 'db_config.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $image_url = isset($_POST['image_url']) ? trim($_POST['image_url']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;

    // Check if required fields are empty or invalid
    if (empty($name) || empty($location) || empty($description) || empty($image_url) || !is_numeric($price) || $price <= 0) {
        echo json_encode(["status" => "error", "message" => "Toate câmpurile sunt obligatorii și prețul trebuie să fie un număr pozitiv."]);
        exit;
    }

    try {
        // Prepare the SQL statement for inserting the hotel data
        // The ? placeholders are used to prevent SQL injection attacks
        $sql = "INSERT INTO hotels (name, location, description, image_url, price) VALUES (?, ?, ?, ?, ?)";

        // Use a prepared statement to bind the values securely
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            // Throw an exception if the SQL statement preparation failed
            throw new Exception("Eroare la pregătirea interogării: " . $conn->error);
        }

        // Bind the parameters to the statement
        // The 'ssssd' string indicates the types of the parameters: string, string, string, string, double
        $stmt->bind_param("ssssd", $name, $location, $description, $image_url, $price);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Return a success message if the hotel was added successfully
            echo json_encode(["status" => "success", "message" => "Hotelul a fost adăugat cu succes."]);
        } else {
            // Throw an exception if the execution failed
            throw new Exception("Eroare la adăugarea hotelului: " . $stmt->error);
        }

        // Close the statement
        $stmt->close();
    } catch (Exception $e) {
        // Catch any exceptions and return a generic error message
        echo json_encode(["status" => "error", "message" => "A apărut o eroare la server: " . $e->getMessage()]);
    }

    // Close the database connection
    $conn->close();
} else {
    // If the request method is not POST, return an error
    echo json_encode(["status" => "error", "message" => "Metodă de cerere invalidă."]);
}
