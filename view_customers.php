<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "myshop";
$port = 3306;

$conn = new mysqli($host, $user, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch customer data
$sql = "SELECT id, first_name, last_name, phone, email, address, profile_image FROM customer";
$result = $conn->query($sql);


include('includes/admin_navbar.php');
include('includes/admin_leftbar.php');
include('linking.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Customer Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .table thead {
            
            color: #fff;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .card {
            border: none;
        }
        .card-header {
            text-align: center;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row"><br><br>
            <div class="col-md-2"></div>
            <div class="col-md-10">
        <div class="card"><br><br><br><br>
            <div class="card-header">
                <h4><i class="fas fa-users"></i> Customer Details</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="bg-warning text-dark">
                        <tr>
                            <th>#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td>
                                        <img src="<?= $row['profile_image'] ? $row['profile_image'] : 'default-profile.png' ?>" 
                                             alt="Profile Image" class="profile-img">
                                    </td>
                                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['address'] ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#customerDetailsModal" 
                                                onclick="viewCustomerDetails(<?= htmlspecialchars(json_encode($row)) ?>)">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No customer data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            </div>
            </div>

    <!-- Customer Details Modal -->
    <div class="modal fade" id="customerDetailsModal" tabindex="-1" aria-labelledby="customerDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerDetailsModalLabel">Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="text-center">
                        <img id="modalCustomerImage" src="" alt="Profile Image" class="profile-img" style="height:150px;width:150px;">
                    </div>
                    <p><strong>ID:</strong> <span id="modalCustomerId"></span></p>
                    <p><strong>Name:</strong> <span id="modalCustomerName"></span></p>
                    <p><strong>Phone:</strong> <span id="modalCustomerPhone"></span></p>
                    <p><strong>Email:</strong> <span id="modalCustomerEmail"></span></p>
                    <p><strong>Address:</strong> <span id="modalCustomerAddress"></span></p>
                   
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewCustomerDetails(customer) {
            document.getElementById('modalCustomerId').textContent = customer.id;
            document.getElementById('modalCustomerName').textContent = customer.first_name + ' ' + customer.last_name;
            document.getElementById('modalCustomerPhone').textContent = customer.phone;
            document.getElementById('modalCustomerEmail').textContent = customer.email;
            document.getElementById('modalCustomerAddress').textContent = customer.address;
            document.getElementById('modalCustomerImage').src = customer.profile_image || 'default-profile.png';
        }
    </script>
</body>
</html>
