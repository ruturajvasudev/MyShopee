<?php
include('includes/customer_navbar.php');
include('linking.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<script>    location.replace("login2.php");
    </script>';
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'myshop', 3306);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$customer_id = $_SESSION['user_id'];

// Fetch customer orders
$query = "
    SELECT o.id AS order_id, o.order_date, o.status, o.payment_mode, o.address, 
           p.name AS product_name, p.price, p.image1 
    FROM orders o 
    INNER JOIN products p ON o.product_id = p.id 
    WHERE o.customer_id = $customer_id
    ORDER BY o.order_date DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-shipped {
            color: #17a2b8;
            font-weight: bold;
        }
        .status-delivered {
            color: #28a745;
            font-weight: bold;
        }
        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }

        
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4"><br><br>My Order History</h1>
    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Payment Mode</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['order_id']; ?></td>
                        <td>
                            <img src="<?php echo $row['image1']; ?>" alt="Product Image" class="product-image">
                            <?php echo $row['product_name']; ?>
                        </td>
                        <td><?php echo date('d M Y, h:i A', strtotime($row['order_date'])); ?></td>
                        <td>
                            <span class="
                                <?php
                                switch (strtolower($row['status'])) {
                                    case 'pending': echo 'status-pending'; break;
                                    case 'shipped': echo 'status-shipped'; break;
                                    case 'delivered': echo 'status-delivered'; break;
                                    case 'cancelled': echo 'status-cancelled'; break;
                                }
                                ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>
                        <td>₹<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo strtoupper($row['payment_mode']); ?></td>
                        <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetailsModal" 
                            data-id="<?php echo $row['order_id']; ?>" 
                            data-product="<?php echo $row['product_name']; ?>"
                            data-price="₹<?php echo number_format($row['price'], 2); ?>"
                            data-status="<?php echo ucfirst($row['status']); ?>"
                            data-date="<?php echo date('d M Y, h:i A', strtotime($row['order_date'])); ?>"
                            data-address="<?php echo $row['address']; ?>"
                            data-image="<?php echo $row['image1']; ?>"> <!-- Pass product image URL -->
                            View Details
                        </button>

                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">You have no orders yet!</p>
        <?php endif; ?>
    </div>
</div>

<!-- Order Details Modal -->
<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Product Image -->
                    <div class="col-md-4 text-center">
                        <img id="modal-product-image" src="" alt="Product Image" class="img-fluid rounded shadow">
                    </div>
                    <!-- Order and Customer Details -->
                    <div class="col-md-8">
                        <p><strong>Order ID:</strong> <span id="modal-order-id"></span></p>
                        <p><strong>Product Name:</strong> <span id="modal-product-name"></span></p>
                        <p><strong>Price:</strong> <span id="modal-price"></span></p>
                        <p><strong>Status:</strong> <span id="modal-status"></span></p>
                        <p><strong>Order Date:</strong> <span id="modal-date"></span></p>
                        <p><strong>Delivery Address:</strong> <span id="modal-address"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Populate modal with order details
    // Populate modal with order details
document.querySelectorAll('button[data-bs-toggle="modal"]').forEach(button => {
    button.addEventListener('click', function () {
        document.getElementById('modal-order-id').innerText = this.getAttribute('data-id');
        document.getElementById('modal-product-name').innerText = this.getAttribute('data-product');
        document.getElementById('modal-price').innerText = this.getAttribute('data-price');
        document.getElementById('modal-status').innerText = this.getAttribute('data-status');
        document.getElementById('modal-date').innerText = this.getAttribute('data-date');
        document.getElementById('modal-address').innerText = this.getAttribute('data-address');
        document.getElementById('modal-product-image').src = this.getAttribute('data-image'); // Set product image
    });
});

</script>
</body>
</html>
<?php $conn->close(); ?>
