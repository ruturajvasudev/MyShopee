<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myshop";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt password
    $profile_image = null;

    // Handle profile image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "uploads/";
        $profile_image = $target_dir . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $profile_image);
    }

    // Check for existing email or phone
    $check_query = "SELECT * FROM customer WHERE email = '$email' OR phone = '$phone'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Phone or Email already exists']);
        exit;
    }

    // Insert new customer with password
    $sql = "INSERT INTO customer (first_name, last_name, phone, email, address, profile_image, password) 
            VALUES ('$first_name', '$last_name', '$phone', '$email', '$address', '$profile_image', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
        exit;
    }
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #5a5a5a;
        }
        .btn-custom {
            background-color: #e74c3c;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #c0392b;
        }
        .password-strength {
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h1>Customer Registration</h1>
        <form id="registration-form" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image (Optional)</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Set Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div id="password-strength" class="password-strength"></div>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Register</button>
        </form>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="success-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Success</h5>
            </div>
            <div class="modal-body">
                <p>Registration successful! Click OK to login.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="redirect-login">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="error-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Error</h5>
            </div>
            <div class="modal-body">
                <p id="error-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Password strength check
    $('#password').on('input', function() {
        const password = $(this).val();
        const strength = getPasswordStrength(password);
        $('#password-strength').text(strength).css('color', strength === 'Strong' ? 'green' : 'red');
    });

    // Form submission
    $('#registration-form').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        if ($('#password').val() !== $('#confirm_password').val()) {
            $('#error-message').text('Passwords do not match!');
            $('#error-modal').modal('show');
            return;
        }

        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#success-modal').modal('show');
                } else {
                    $('#error-message').text(res.message);
                    $('#error-modal').modal('show');
                }
            }
        });
    });

    // Redirect to login on success
    $('#redirect-login').click(function() {
        window.location.href = 'login.php';
    });

    function getPasswordStrength(password) {
        const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return strongRegex.test(password) ? 'Strong' : 'Weak';
    }
});
</script>

</body>
</html>
