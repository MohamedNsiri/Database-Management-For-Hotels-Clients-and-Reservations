<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['owner_name']) || !isset($data['owner_id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
    exit();
}

$owner_name = $data['owner_name'];
$owner_id = $data['owner_id'];

$stmt = $conn->prepare("UPDATE owners SET owner_name = ? WHERE owner_id = ?");
$stmt->bind_param("si", $owner_name, $owner_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Owner updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error updating owner: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
