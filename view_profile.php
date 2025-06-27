<?php
include('includes/customer_navbar.php');

include('linking.php');
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<script>    location.replace("login.php");
</script>';
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'myshop', 3306);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$customer_id = $_SESSION['user_id'];

// Fetch customer details
$result = $conn->query("SELECT * FROM customer WHERE id = $customer_id");
$customer = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $conn->query("UPDATE customer SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        phone = '$phone', 
        email = '$email', 
        address = '$address'
        WHERE id = $customer_id");

    // Handle profile image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $image_name = 'uploads/' . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_name);
        $conn->query("UPDATE customer SET profile_image = '$image_name' WHERE id = $customer_id");
    }

    // Reload updated data
    $result = $conn->query("SELECT * FROM customer WHERE id = $customer_id");
    $customer = $result->fetch_assoc();

    $message = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .profile-container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .form-hidden {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="profile-container">
        <h1 class="text-center"><br>My Profile</h1>
        
        <!-- Success Message -->
        <?php if (isset($message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="text-center">
            <img src="<?php echo $customer['profile_image'] ?: 'default-avatar.png'; ?>" alt="Profile Image" class="profile-image">
        </div>

        <!-- Profile Details -->
        <div id="view-profile">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($customer['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($customer['last_name']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($customer['phone']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($customer['address']); ?></p>
            <button class="btn btn-warning w-100 mt-3" id="edit-button">Edit Profile</button>
        </div>

        <!-- Edit Profile Form -->
        <form method="POST" enctype="multipart/form-data" id="edit-profile" class="form-hidden">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $customer['first_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $customer['last_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $customer['phone']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $customer['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $customer['address']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image">
            </div>
            <button type="submit" class="btn btn-warning w-100">Save Changes</button>
            <button type="button" class="btn btn-secondary w-100 mt-2" id="cancel-button">Cancel</button>
        </form>
    </div>
</div>

<script>
    // Toggle between view and edit modes
    document.getElementById('edit-button').addEventListener('click', function() {
        document.getElementById('view-profile').classList.add('form-hidden');
        document.getElementById('edit-profile').classList.remove('form-hidden');
    });

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('edit-profile').classList.add('form-hidden');
        document.getElementById('view-profile').classList.remove('form-hidden');
    });
</script>
</body>
</html>
<?php $conn->close(); ?>
