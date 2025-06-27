<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
       
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            color: black;
            padding-top: 150px;
            box-shadow: 3px 0 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar .brand-logo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            padding: 15px 0;
            color: black;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            width: 100%;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: black;
            font-size: 16px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.3s ease;
        }

        .sidebar ul li a i {
            margin-right: 15px;
            font-size: 18px;
        }

        .sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffdd00;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .sidebar ul li a.active {
            background: rgba(255, 255, 255, 0.2);
            color: #ffdd00;
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }
    </style>
</head>

<body><br>
    <div class="sidebar">
        <div class="brand-logo">
            <i class="fas fa-cogs"></i> Admin Portal
        </div>
        <ul>
            <li><a href="admin_dashboard.php" class=""><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="view_orders.php"><i class="fas fa-box"></i> View Orders</a></li>
            <li><a href="view_contactus_admin.php"><i class="fas fa-envelope"></i> View Contact Us</a></li>
            <li><a href="view_customers.php"><i class="fas fa-users"></i> Manage Users</a></li>
            <li><a href="sell_summary.php"><i class="fas fa-chart-line"></i> Analytics</a></li>
            <li><a href="add_product.php"><i class="fas fa-plus-circle"></i> Add Product</a></li>
            <li><a href="edit_product.php"><i class="fa fa-edit"></i> View/Edit Product</a></li>
            <li><a href="#"><i class="fas fa-power-off"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
