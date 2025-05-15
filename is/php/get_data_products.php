<?php
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root"; // Update if needed
$password = "";
$dbname = "login"; // Replace with actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Query to calculate the total quantity of all products
$sql = "SELECT SUM(quantity) AS total_quantity FROM product_stocks";
$result = $conn->query($sql);

// Check if the query returned a result
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["total_quantity" => (int)$row['total_quantity']]);
} else {
    echo json_encode(["total_quantity" => 0]);
}

// Close the connection
$conn->close();
?>
