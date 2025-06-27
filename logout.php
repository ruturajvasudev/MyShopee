<?php
session_start();
session_destroy(); // Destroy the session

// Redirect to admin login page
header("Location: admin_login.php");
exit();
?>
