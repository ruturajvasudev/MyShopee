
<?php
include('includes/customer_navbar.php');
include('linking.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<script>    location.replace("login2.php");
    </script>';
}




$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myshop";
$port = 3306;


$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the selected product by product_id (passed via URL or session)
$product_id = isset($_GET['id']) ? $_GET['id'] : 1; // Default to 1 if not provided

$product_sql = "SELECT * FROM products WHERE id = $product_id";
$product = $conn->query($product_sql)->fetch_assoc();

// Fetch customer details (assuming customer is logged in and their ID is in session)
$customer_id = $_SESSION['user_id']; // Assuming customer ID is stored in session after login
$customer_sql = "SELECT * FROM customer WHERE id = $customer_id";
$customer = $conn->query($customer_sql)->fetch_assoc();

// Handle order placement
$modal_type = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $address = $customer['address']; // Use the customer's saved address for the order

    // Insert order with the current timestamp using NOW() function
    $order_sql = "INSERT INTO orders (customer_id, product_id, address, order_date) 
                  VALUES ('$customer_id', '$product_id', '$address', NOW())";
    if ($conn->query($order_sql) === TRUE) {
        $modal_type = 'success';
    } else {
        $modal_type = 'error';
    }

    // Show success or error modal based on the order result
  
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  

  <style>
       
        .product-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .product-card:hover {
            transform: scale(1.02);
        }
        .modal-header {
            background-color: #EAA636;
            color: white;
        }
        .btn-primary {
            background-color: #EAA636;
            border: none;
        }
        .btn-primary:hover {
            background-color: #EAA636;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="text-center mb-4"><br>Product Details</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card product-card">
                <img src="<?= $product['image1']; ?>" class="card-img-top" alt="Product Image">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name']; ?></h5>
                    <p class="card-text"><?= $product['description']; ?></p>
                    <p><strong>Price:</strong> ₹<?= $product['price']; ?></p>
                    <button 
                        class="btn btn-primary w-100" 
                        data-bs-toggle="modal" 
                        data-bs-target="#orderModal" 
                        onclick="setOrderDetails('<?= $product['id']; ?>', '<?= $product['name']; ?>', '<?= $product['price']; ?>')">
                        Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Order1 Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Product Name:</strong> <span id="product_name"><?= $product['name']; ?></span></p>
                    <p><strong>Price:</strong> ₹<span id="product_price"><?= $product['price']; ?></span></p>

                    <!-- Hidden Address Field -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" readonly><?= $customer['address']; ?></textarea>
                    </div>

                    <h5>Customer Details:</h5>
                    <p><strong>Name:</strong> <?= $customer['first_name'] . ' ' . $customer['last_name']; ?></p>
                    <p><strong>Email:</strong> <?= $customer['email']; ?></p>
                    <p><strong>Phone:</strong> <?= $customer['phone']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="place_order" class="btn btn-primary">Place Order</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($modal_type == 'success'): ?>
                    <script>
                    window.location.href = "confirmation_modal.php";
                    </script>
                    <p>Order placed successfully!</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($modal_type === 'error'): ?>
                    <p>Error placing order. Please try again.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Set order details dynamically into the modal
    function setOrderDetails(productId, productName, productPrice) {
        document.getElementById('product_id').value = productId;
        document.getElementById('product_name').textContent = productName;
        document.getElementById('product_price').textContent = productPrice;
    }

    // Show success or error modal based on the order result
    <?php if ($modal_type === 'success') : ?>
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    <?php elseif ($modal_type == 'error') : ?>
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    <?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php

include('includes/customer_footer.php');
include('linking.php');

?>