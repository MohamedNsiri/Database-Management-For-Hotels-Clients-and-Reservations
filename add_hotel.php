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

$input = file_get_contents("php://input");
$data = json_decode($input);

if ($data === null) {
    echo json_encode(["message" => "No data received", "input" => $input, "json_error" => json_last_error_msg()]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO `hotels`(`hotel_name`, `room_price`) VALUES (?, ?)");
$stmt->bind_param("ss", $data->hotel_name, $data->room_price);

if ($stmt->execute()) {
  echo json_encode(["message" => "Hotel added successfully"]);
} else {
  echo json_encode(["message" => "Error adding Hotel"]);
}

$stmt->close();
$conn->close();
?>
