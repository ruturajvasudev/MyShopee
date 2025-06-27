<?php

include('includes/admin_navbar.php');
include('includes/admin_leftbar.php');
include('linking.php');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact Us</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      
        .container {
            margin-top: 50px;
        }

        .table-container {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
        }

        .table {
            border-radius: 15px;
        }

        .table thead th {
            color: #000;
            font-size: 16px;
             text-align: center;
            letter-spacing: 1px;
        }

        .table tbody td {
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
        }

        .table tbody tr:hover {
            transform: scale(1.01);
            transition: all 0.2s ease-in-out;
        }

        .icon-circle {
            background-color: #ffd633;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #000;
            margin-right: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #ffcc00;
        }

        .btn-primary {
            background-color: #ffcc00;
            border-color: #ffcc00;
            color: #000;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
    <div class="header"><br><br><br>
        <h1><i class="fas fa-envelope icon-circle"></i> Contact Us Submissions</h1>
    </div>
    <div class="table-container">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name <i class="fas fa-user"></i></th>
                <th>Email <i class="fas fa-envelope"></i></th>
                <th>Subject <i class="fas fa-book"></i></th>
                <th>Message <i class="fas fa-comment-dots"></i></th>
                <th>Received On <i class="fas fa-calendar-alt"></i></th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Connection details
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

            // Fetch contact_us data
            $sql = "SELECT * FROM contact_us ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$count}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['subject']}</td>
                            <td>{$row['message']}</td>
                            <td>{$row['created_at']}</td>
                          </tr>";
                    $count++;
                }
            } else {
                echo "<tr>
                        <td colspan='6'>No submissions found.</td>
                      </tr>";
            }

            // Close connection
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
    
</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
