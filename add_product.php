
<?php
include('includes/admin_navbar.php');
include('includes/admin_leftbar.php');
include('linking.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Entry Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Product Entry Form</h2>
    <form action="insert_product.php" method="POST" enctype="multipart/form-data">
        <!-- Product Category -->
        <div class="mb-3">
            <label for="category" class="form-label">Product Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="Male Adult">Male Adult</option>
                <option value="Female Adult">Female Adult</option>
                <option value="Boys Child">Boys Child</option>
                <option value="Girls Child">Girls Child</option>
                <option value="Furniture">Furniture</option>
                <option value="Electronics">Electronics</option>
            </select>
        </div>

        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price (₹)</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <!-- Material -->
        <div class="mb-3">
            <label for="material" class="form-label">Material</label>
            <input type="text" class="form-control" id="material" name="material" required>
        </div>

        <!-- Product Image 1 -->
        <div class="mb-3">
            <label for="image1" class="form-label">Product Image 1</label>
            <input type="file" class="form-control" id="image1" name="image1" accept="image/*" required>
        </div>

        <!-- Product Image 2 -->
        <div class="mb-3">
            <label for="image2" class="form-label">Product Image 2</label>
            <input type="file" class="form-control" id="image2" name="image2" accept="image/*">
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-warning">Submit</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
