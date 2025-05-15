<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'login';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die(json_encode(['error' => 'Connection failed']));
}

// Query to fetch the 5 products with the lowest quantities
$sql = "SELECT product_name, quantity FROM product_stocks ORDER BY quantity ASC LIMIT 5";
$result = $conn->query($sql);

$categories = [];
$data = [];

while ($row = $result->fetch_assoc()) {
  $categories[] = $row['product_name'];
  $data[] = (int)$row['quantity'];
}

echo json_encode([
  "categories" => $categories,
  "data" => $data
]);

$conn->close();
?>
