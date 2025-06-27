
<?php
// Initialize variables for username and password
$username = "admin";
$password = "admin";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];
    
    // Validate input against predefined credentials
    if ($inputUsername == $username && $inputPassword == $password) {
        echo '<script>    location.replace("admin_dashboard.php");
        </script>';
    } else {
        echo "Invalid username or password!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
             min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 30px;
        }

        .login-container .brand-logo {
            display: block;
            margin: 0 auto 20px;
            text-align: center;
            color:rgb(242, 203, 5);
            font-size: 3rem;
        }

        .login-container .form-control {
            border-radius: 10px;
            box-shadow: none;
        }

        .login-container button {
            background:rgb(243, 208, 9);
            border: none;
            border-radius: 10px;
        }

        .login-container button:hover {
            background: #0056b3;
        }

        .login-container .forgot-link {
            text-align: right;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .login-container .forgot-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-container .forgot-link a:hover {
            text-decoration: underline;
        }

        .login-container .social-icons a {
            font-size: 1.5rem;
            margin: 0 10px;
            color: #6c757d;
        }

        .login-container .social-icons a:hover {
            color: #007bff;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <i class="fas fa-user-shield brand-logo"></i>
        <h3 class="text-center">Admin Login</h3>
        <form  method="POST">
            <div class="mb-3">
                <label for="username" class="form-label"><i class="fas fa-user"></i> Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username"
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter your password" required>
            </div>
            <div class="forgot-link">
                <a href="forgot_password.php"></a>
            </div>
            <div class="mt-4 d-grid">
                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Login</button>
            </div>
        </form>
        <div class="social-icons text-center mt-4">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
