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

// Encryption/Decryption keys
define('ENCRYPTION_KEY', 'your_secret_key'); // Replace with the same key used in registration
define('ENCRYPTION_METHOD', 'AES-256-CBC');

// Decrypt function

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
        $stored_encrypted_password = $user['password']; // Encrypted and hashed password in DB

        // Step 1: Decrypt the stored password
        $decrypted_hashed_password = decryptData($stored_encrypted_password);

        // Step 2: Verify the password using `password_verify`
        if (password_verify($password, $decrypted_hashed_password)) {
      
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



        $reset_step = resetPass($reset_code);

      
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



// Encrypt function
function encryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = substr(hash('sha256', 'iv_key'), 0, 16); // Initialization vector
    return base64_encode(openssl_encrypt($data, ENCRYPTION_METHOD, $key, 0, $iv));
}

// Decrypt function
function decryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = substr(hash('sha256', 'iv_key'), 0, 16); // Initialization vector
    return openssl_decrypt(base64_decode($data), ENCRYPTION_METHOD, $key, 0, $iv);
}

// Update password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    //$new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

     // Step 1: Hash the password
 $hashed_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

 // Step 2: Encrypt the hashed password
 $new_password = encryptData($hashed_password);
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

    
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function resetPass($code){
require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'mohitvasudev15@gmail.com';               // SMTP username
    $mail->Password   = 'kxsqidwedjmordfl';                        // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    // Recipients
    $mail->setFrom('mohitvasudev15@gmail.com', 'Mailer');
    $mail->addAddress('ruturajrajeshvasudev@gmail.com', 'Joe User');     // Add a recipient

    // Content
    $mail->isHTML(true);                                        // Set email format to HTML
    $mail->Subject = 'Reset Password';
    $mail->Body    = 'Code to reset Password '.$code.'<br><h2> <b>Do not share with anyone!</b></h2>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo "<script>alert('Password reset code has been sent successfully!');</script>";

    echo '';
    return 2;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}




}

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
        <a href="user_registeration1.php">Register</a>

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
