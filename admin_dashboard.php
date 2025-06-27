<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "myshop";
$port = 3306;


include('includes/admin_navbar.php');
include('includes/admin_leftbar.php');

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$totalOrders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
$totalCustomers = $conn->query("SELECT COUNT(*) AS count FROM customer")->fetch_assoc()['count'];
$totalProducts = $conn->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc()['count'];
$pendingOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'Pending'")->fetch_assoc()['count'];
$shippedOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'Shipped'")->fetch_assoc()['count'];
$deliveredOrders = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE status = 'Delivered'")->fetch_assoc()['count'];
$totalEarnings = $conn->query("SELECT SUM(products.price) AS earnings 
                               FROM orders 
                               JOIN products ON orders.product_id = products.id 
                               WHERE orders.status = 'Delivered'")->fetch_assoc()['earnings'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .dashboard-card {
            transition: transform 0.3s ease;
        }
        .dashboard-card:hover {
            transform: scale(1.05);
        }
        .icon-bg {
            width: 70px;
            height: 70px;
            background-color: rgba(0, 123, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .icon-bg i {
            font-size: 2rem;
            color:rgb(244, 192, 4);
        }
    </style>
</head>
<body>
<div class="container-fluid my-5">
    <h1 class="text-center mb-4"><br>Admin Dashboard</h1>
    <div class="row g-4">
        <!-- Total Orders -->
         <div class="col-md-2"></div>
        <div class="col-md-3">
        <a href="view_orders.php">
            <div class="card shadow dashboard-card p-3">
                <div class="icon-bg"><i class="fas fa-shopping-cart"></i></div>
                <h5>Total Orders</h5>
                <h2><?= $totalOrders ?></h2>
            </div>
    </a>
        </div>
        
        <!-- Total Customers -->
        <div class="col-md-3">
            <a href="view_customers.php">
            <div class="card shadow dashboard-card p-3">
                <div class="icon-bg"><i class="fas fa-users"></i></div>
                <h5>Total Customers</h5>
                <h2><?= $totalCustomers ?></h2>
            </div>
    </a>
        </div>
        <!-- Total Products -->
        <div class="col-md-3">
        <a href="edit_product.php">
            <div class="card shadow dashboard-card p-3">
                <div class="icon-bg"><i class="fas fa-box-open"></i></div>
                <h5>Total Products</h5>
                <h2><?= $totalProducts ?></h2>
            </div>
    </a>
        </div>
        <!-- Pending Orders -->
        <div class="col-md-2">
    </div>
        <div class="col-md-3">
            <div class="card shadow dashboard-card p-3">
                <div class="icon-bg"><i class="fas fa-hourglass-half"></i></div>
                <h5>Pending Orders</h5>
                <h2><?= $pendingOrders ?></h2>
            </div>
        </div>
        <!-- Shipped Orders -->
        <div class="col-md-3">
            <div class="card shadow dashboard-card p-3">
                <div class="icon-bg"><i class="fas fa-truck"></i></div>
                <h5>Shipped Orders</h5>
                <h2><?= $shippedOrders ?></h2>
            </div>
        </div>
        <!-- Delivered Orders -->
        <div class="col-md-3">
            <div class="card shadow dashboard-card p-3">
                <div class="icon-bg"><i class="fas fa-check-circle"></i></div>
                <h5>Delivered Orders</h5>
                <h2><?= $deliveredOrders ?></h2>
            </div>
        </div>
        <!-- Total Earnings -->
         <div class="col-md-2"></div>
        <div class="col-md-9">
            <div class="card shadow dashboard-card p-3">
                <div class="icon-bg"><i class="fas fa-wallet"></i></div>
                <h5>Total Earnings</h5>
                <h2>₹<?= number_format($totalEarnings, 2) ?></h2>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php

include('linking.php');

?>