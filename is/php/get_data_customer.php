<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; // Change if using a different database username
$password = "";
$dbname = "login"; // Make sure your database name is correct

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed']));
}

// Query to get the user count
$sql = "SELECT COUNT(*) AS user_count FROM users";
$result = $conn->query($sql);

$user_count = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_count = $row['user_count'];
}

echo json_encode(['user_count' => $user_count]);

$conn->close();
?>
