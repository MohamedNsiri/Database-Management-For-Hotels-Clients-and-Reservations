<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: DELETE");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute DELETE query
    $sql = "DELETE FROM hotels WHERE id = $id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo json_encode(array("message" => "Hotel deleted successfully"));
    } else {
        echo json_encode(array("error" => "Error deleting Hotel: " . $conn->error));
    }
} else {
    echo json_encode(array("error" => "ID parameter is required"));
}

// Close connection
$conn->close();
?>
