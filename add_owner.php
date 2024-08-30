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

$checkStmt = $conn->prepare("SELECT * FROM `owners` WHERE `owner_id` = ?");
$checkStmt->bind_param("s", $data->owner_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["message" => "Owner already exists"]);
    $checkStmt->close();
    $conn->close();
    exit();
}
$checkStmt->close();

$stmt = $conn->prepare("INSERT INTO `owners`(`owner_id`, `owner_name`) VALUES (?, ?)");
$stmt->bind_param("ss", $data->owner_id, $data->owner_name);

if ($stmt->execute()) {
  echo json_encode(["message" => "User added successfully"]);
} else {
  echo json_encode(["message" => "Error adding user"]);
}

$stmt->close();
$conn->close();
?>
