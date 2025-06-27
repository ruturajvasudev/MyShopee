<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myshop";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch category-wise sales data
$categorySalesQuery = "
    SELECT p.category AS category, SUM(p.price) AS total_sales 
    FROM orders o 
    JOIN products p ON o.product_id = p.id 
    GROUP BY p.category";
$categorySalesResult = $conn->query($categorySalesQuery);

$categorySales = [];
while ($row = $categorySalesResult->fetch_assoc()) {
    $categorySales[] = $row;
}

// Fetch month-wise sales data
$monthlySalesQuery = "
    SELECT MONTH(o.order_date) AS month, SUM(p.price) AS total_sales 
    FROM orders o 
    JOIN products p ON o.product_id = p.id 
    GROUP BY MONTH(o.order_date)";
$monthlySalesResult = $conn->query($monthlySalesQuery);

$monthlySales = [];
while ($row = $monthlySalesResult->fetch_assoc()) {
    $monthlySales[] = $row;
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode([
    'categorySales' => $categorySales,
    'monthlySales' => $monthlySales
]);

$conn->close();
?>
