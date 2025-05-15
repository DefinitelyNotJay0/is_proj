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

$sql = "SELECT product_name, SUM(quantity) AS total_sold FROM sales GROUP BY product_name ORDER BY total_sold DESC LIMIT 5";
$result = $conn->query($sql);

$categories = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['product_name'];
    $data[] = (int)$row['total_sold'];
}

echo json_encode([
    "categories" => $categories,
    "data" => $data
]);

$conn->close();
?>
