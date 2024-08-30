<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Methods: GET");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM hotels";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $hotels = array();
    while ($row = $result->fetch_assoc()) {
        $hotels[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($hotels);
} else {
    echo json_encode([]);
}
$conn->close();
?>
