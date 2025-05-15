<?php
// Database connection
$servername = "localhost";
$username = "root"; // Update if needed
$password = "";
$dbname = "login"; // Confirmed database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to mask email addresses for privacy
function maskEmail($email) {
    $parts = explode("@", $email);
    $username = substr($parts[0], 0, 2) . str_repeat("*", max(0, strlen($parts[0]) - 2)); // Show first 2 chars, mask the rest
    return $username . "@" . $parts[1]; // Keep domain visible
}

// Function to mask names for privacy
function maskName($name) {
    return substr($name, 0, 1) . str_repeat("*", max(0, strlen($name) - 1)); // Show first letter, mask the rest
}

// Query to get customer details
$sql = "SELECT firstName, lastName, email FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' class='customer-table'>";
    echo "<tr><th>#</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>"; // Table Headers
    $count = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $count++ . "</td>"; // Number each row
        echo "<td>" . htmlspecialchars(maskName($row["firstName"])) . "</td>"; // Masked First Name
        echo "<td>" . htmlspecialchars(maskName($row["lastName"])) . "</td>"; // Masked Last Name
        echo "<td>" . htmlspecialchars(maskEmail($row["email"])) . "</td>"; // Masked Email
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No customers found.</p>";
}

$conn->close();
?>
