<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; // Update if needed
$password = "";
$dbname = "login"; // Replace with actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Query to count unique categories
$sql = "SELECT COUNT(DISTINCT category) AS category_count FROM product_stocks";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["category_count" => $row['category_count']]);
} else {
    echo json_encode(["category_count" => 0]);
}

$conn->close();
?>
