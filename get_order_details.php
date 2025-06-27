<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myshop";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_id = $_GET['order_id'];

$sql = "SELECT 
            o.status AS order_status,
            o.address AS customer_address,
            CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
            c.phone AS customer_phone,
            p.id AS product_id,
            p.name AS product_name,
            p.category AS product_category,
            p.price AS product_price,
            p.description AS product_description,
            p.image1 AS product_image1,
            p.image2 AS product_image2
        FROM orders o
        JOIN customer c ON o.customer_id = c.id
        JOIN products p ON o.product_id = p.id
        WHERE o.id = $order_id";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

echo json_encode($data);

$conn->close();


?>
