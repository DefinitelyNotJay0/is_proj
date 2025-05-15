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

// Query to get total quantities for online and physical stores by month
$sql = "
    SELECT 
        MONTHNAME(sale_date) AS month,
        SUM(CASE WHEN sale_type = 'physical' THEN quantity ELSE 0 END) AS physical_store_sales,
        SUM(CASE WHEN sale_type = 'online' THEN quantity ELSE 0 END) AS online_sales
    FROM sales_history
    WHERE YEAR(sale_date) = YEAR(CURDATE())
    GROUP BY MONTH(sale_date)
    ORDER BY MONTH(sale_date)
";

$result = $conn->query($sql);

// Handle query errors
if (!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    $conn->close();
    exit;
}

// Handle empty results
if ($result->num_rows === 0) {
    echo json_encode(["months" => [], "physical_store_sales" => [], "online_sales" => []]);
    $conn->close();
    exit;
}

$months = [];
$physical_store_sales = [];
$online_sales = [];

while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $physical_store_sales[] = (int)$row['physical_store_sales'];
    $online_sales[] = (int)$row['online_sales'];
}

echo json_encode([
    "months" => $months,
    "physical_store_sales" => $physical_store_sales,
    "online_sales" => $online_sales
]);

$conn->close();
?>