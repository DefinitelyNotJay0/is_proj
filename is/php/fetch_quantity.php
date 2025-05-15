<?php
// Database connection
$host = 'localhost';
$db = 'login';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the quantity for Sugino Zen CrankSet
$product_name = 'Sugino Zen CrankSet';
$stmt = $conn->prepare("SELECT quantity FROM product_stock WHERE product_name = ?");
$stmt->bind_param("s", $product_name);
$stmt->execute();
$result = $stmt->get_result();
$quantity = $result->num_rows > 0 ? $result->fetch_assoc()['quantity'] : 'N/A';

$stmt->close();
$conn->close();
?>