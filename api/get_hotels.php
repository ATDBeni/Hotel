<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


require_once 'db_config.php';

$hotels = [];
$conn = null;

try {

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    
    if ($conn->connect_error) {
        throw new Exception("Conexiune eșuată: " . $conn->connect_error);
    }


    $sql = "SELECT id, name, location, description, image_url, price FROM hotels";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hotels[] = $row;
        }
    }


    echo json_encode($hotels);
} catch (Exception $e) {

    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if ($conn) {
        $conn->close();
    }
}
