<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";
$port = 3306;
// Create a connection
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$category = $_POST['category'];
$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$material = $_POST['material'];

// Handle image uploads
$image1 = $_FILES['image1'];
$image2 = $_FILES['image2'];

$image1_name = $image1['name'];
$image2_name = $image2['name'];

$upload_dir = "uploads/";
$image1_path = $upload_dir . basename($image1_name);
$image2_path = $image2_name ? $upload_dir . basename($image2_name) : null;

// Move uploaded files to the uploads directory
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}
move_uploaded_file($image1['tmp_name'], $image1_path);

if ($image2_name) {
    move_uploaded_file($image2['tmp_name'], $image2_path);
}

// Insert data into the database
$sql = "INSERT INTO products (category, name, price, description, material, image1, image2) 
        VALUES ('$category', '$name', $price, '$description', '$material', '$image1_path', '$image2_path')";

if ($conn->query($sql) === TRUE) {
    echo "New product added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
