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

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$owner_id = $request->owner_id;
$check_owner_stmt = $conn->prepare("SELECT owner_id FROM owners WHERE owner_id = ?");
$check_owner_stmt->bind_param("i", $owner_id);
$check_owner_stmt->execute();
$check_owner_stmt->store_result();

if ($check_owner_stmt->num_rows > 0) {
  $insert_stmt = $conn->prepare("INSERT INTO products (product_name, product_price, product_pic, owner_id, product_desc) VALUES (?, ?, ?, ?, ?)");
  $insert_stmt->bind_param("sdsis", $request->product_name, $request->product_price, $request->product_pic, $request->owner_id, $request->product_desc);

  if ($insert_stmt->execute()) {
    $response = array('message' => 'Product added successfully');
  } else {
    $response = array('message' => 'Error inserting product: ' . $conn->error);
  }

  $insert_stmt->close();
} else {
  $response = array('message' => 'Error: Owner ID does not exist');
}

$check_owner_stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>

