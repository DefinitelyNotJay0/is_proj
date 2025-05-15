<?php
// Database connection
$servername = "localhost";
$username = "root"; // Update if needed
$password = "";
$dbname = "login"; // Confirmed database name

$conn = new mysqli($servername, $username, $password, $dbname); // Fix variable name

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to group products by category and sum their quantities
$sql = "SELECT category, SUM(quantity) AS total_quantity FROM product_stocks GROUP BY category";
$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error);
}

if ($result->num_rows > 0) {
    echo "<table border='1' class='category-table'>";
    echo "<tr><th>Category</th><th>Total Quantity</th></tr>"; // Table Headers
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["category"]) . "</td>"; // Category
        echo "<td>" . htmlspecialchars($row["total_quantity"]) . "</td>"; // Total Quantity
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No categories found in inventory.</p>";
}

$conn->close();
?>
