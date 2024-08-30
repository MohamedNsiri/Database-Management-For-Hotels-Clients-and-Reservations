<?php
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Allow only DELETE method
header("Access-Control-Allow-Methods: DELETE");

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' parameter is set in GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute DELETE query
    $sql = "DELETE FROM owners WHERE owner_id = $id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo json_encode(array("message" => "Owner deleted successfully"));
    } else {
        echo json_encode(array("error" => "Error deleting owner: " . $conn->error));
    }
} else {
    echo json_encode(array("error" => "ID parameter is required"));
}

// Close connection
$conn->close();
?>
