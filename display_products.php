<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "myshop";
$port = 3306;
// Create a connection
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
$action = $_POST['action'] ?? null;
$message = "";
$isError = false;

if ($action === 'edit') {
    // Edit product
    $id = $_POST['id'];
    $category = $_POST['category'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $material = $_POST['material'];

    $sql = "UPDATE products SET 
                category='$category', 
                name='$name', 
                price=$price, 
                description='$description', 
                material='$material' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "Product updated successfully!";
    } else {
        $isError = true;
        $message = "Error updating product: " . $conn->error;
    }
} elseif ($action === 'delete') {
    // Delete product
    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "Product deleted successfully!";
    } else {
        $isError = true;
        $message = "Error deleting product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #007bff;
            color: #ffffff;
        }
        .product-image {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }
        .actions i {
            cursor: pointer;
            margin-right: 10px;
        }
        .actions i:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="table-container">
        <h2 class="text-center mb-4">Product List</h2>
        <!-- Success/Error Message -->
        <?php if ($message): ?>
            <div class="alert <?php echo $isError ? 'alert-danger' : 'alert-success'; ?> text-center" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Product Table -->
        <table class="table table-bordered table-hover">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Product Name</th>
                    <th>Price (₹)</th>
                    <th>Description</th>
                    <th>Material</th>
                    <th>Image 1</th>
                    <th>Image 2</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch product data
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='text-center'>";
                        echo "<td>" . $count++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . number_format($row['price'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['material']) . "</td>";
                        echo "<td><img src='" . htmlspecialchars($row['image1']) . "' class='product-image' alt='Image 1'></td>";
                        echo "<td>";
                        if ($row['image2']) {
                            echo "<img src='" . htmlspecialchars($row['image2']) . "' class='product-image' alt='Image 2'>";
                        } else {
                            echo "No Image";
                        }
                        echo "</td>";
                        echo "<td class='actions'>
                                <i class='fas fa-edit' title='Edit' data-bs-toggle='modal' data-bs-target='#editModal' 
                                onclick='populateEditModal(" . json_encode($row) . ")'></i>
                                <i class='fas fa-trash' title='Delete' data-bs-toggle='modal' data-bs-target='#deleteModal' 
                                onclick='setDeleteId(" . $row['id'] . ")'></i>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No Products Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST">
                <input type="hidden" name="action" value="edit">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <!-- Form fields -->
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="editCategory" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="editName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editMaterial" class="form-label">Material</label>
                        <input type="text" class="form-control" id="editMaterial" name="material" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <input type="hidden" name="action" value="delete">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                    <input type="hidden" id="deleteId" name="id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function populateEditModal(row) {
        document.getElementById('editId').value = row.id;
        document.getElementById('editCategory').value = row.category;
        document.getElementById('editName').value = row.name;
        document.getElementById('editPrice').value = row.price;
        document.getElementById('editDescription').value = row.description;
        document.getElementById('editMaterial').value = row.material;
    }

    function setDeleteId(id) {
        document.getElementById('deleteId').value = id;
    }
</script>
</body>
</html>
