<?php
session_start();

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

// Login handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];
   // $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "SELECT * FROM customer WHERE email = '$identifier' OR phone = '$identifier'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Hash the password before saving to the database

// Store $password in the database
echo $user['password']."    --------------        ".$password;
        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            echo $_SESSION['user_name'];
            echo $_SESSION['user_id'];
            
         header("Location: index.php");
            exit;
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "No account found with that email or phone.";
    }
}

// Forgot password handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $identifier = $_POST['reset_identifier'];
    $sql = "SELECT * FROM customer WHERE email = '$identifier' OR phone = '$identifier'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $reset_code = rand(100000, 999999);
        $_SESSION['reset_code'] = $reset_code;
        $_SESSION['reset_identifier'] = $identifier;

        // Simulate sending the reset code (you would send this via email in production)
        echo "<script>alert('Your reset code is: $reset_code');</script>";
        $reset_step = 2; // Move to code verification step
    } else {
        $error_message = "No account found with that email or phone.";
    }
}

// Verify reset code
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    $code = $_POST['code'];
    if ($code == $_SESSION['reset_code']) {
        $reset_step = 3; // Move to new password step
    } else {
        $error_message = "Invalid reset code.";
    }
}

// Update password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $identifier = $_SESSION['reset_identifier'];

    $sql = "UPDATE customer SET password = '$new_password' WHERE email = '$identifier' OR phone = '$identifier'";
    if ($conn->query($sql) === TRUE) {
        unset($_SESSION['reset_code'], $_SESSION['reset_identifier']);
        $success_message = "Password updated successfully. Please log in.";
    } else {
        $error_message = "Error updating password.";
    }
}

$conn->close();

include('customer_navbar1.php');

include('linking.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        .form-container {
            width: 600px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color:rgb(239, 205, 7);
            color: white;
        }
        .btn-custom:hover {
            background-color: #2980b9;
        }
        .text-small {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row"><br><br><br>
        <div class="col-md-12"><br><br><br><br><br><br>
        <center>
<div class="form-container">
    <?php if (!isset($reset_step)) : ?>
        <!-- Login Form -->
        <h1>Login</h1>
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger"><?= $error_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="identifier" class="form-label">Email or Phone</label>
                <input type="text" class="form-control" id="identifier" name="identifier" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-custom w-100">Login</button>
        </form>
        <p class="text-center mt-3 text-small">
        <a href="user_registeration.php">Register</a>

            <a href="#" onclick="showForgotPassword()">Forgot Password?</a>
        </p>
    <?php elseif ($reset_step === 2) : ?>
        <!-- Reset Code Verification -->
        <h1>Verify Code</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="code" class="form-label">Enter the 6-digit code sent to your email/phone</label>
                <input type="text" class="form-control" id="code" name="code" required>
            </div>
            <button type="submit" name="verify_code" class="btn btn-custom w-100">Verify</button>
        </form>
    <?php elseif ($reset_step === 3) : ?>
        <!-- New Password Form -->
        <h1>Reset Password</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <button type="submit" name="update_password" class="btn btn-custom w-100">Update Password</button>
        </form>
    <?php endif; ?>

    <?php if (isset($success_message)) : ?>
        <div class="alert alert-success mt-3"><?= $success_message; ?></div>
        <p class="text-center mt-3"><a href="login.php">Back to Login</a></p>
    <?php endif; ?>
</div>
    </center>
</div></div></div>
<script>
function showForgotPassword() {
    const form = `
        <h1>Forgot Password</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="reset_identifier" class="form-label">Email or Phone</label>
                <input type="text" class="form-control" id="reset_identifier" name="reset_identifier" required>
            </div>
            <button type="submit" name="reset_password" class="btn btn-custom w-100">Send Reset Code</button>
        </form>`;
    document.querySelector('.form-container').innerHTML = form;
}
</script>

</body>
</html>
