<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions for edit and delete actions
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

    $sql = "UPDATE products SET disabled=TRUE WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "Product disabled successfully!";
    } else {
        $isError = true;
        $message = "Error deleting product: " . $conn->error;
    }
}

// Fetch products based on selected categories (AJAX)
if (isset($_POST['categories'])) {
    $categories = $_POST['categories'];
    $categoryFilter = implode("','", $categories);
    $sql = "SELECT * FROM products WHERE category IN ('$categoryFilter')";
} else {
    $sql = "SELECT * FROM products"; // Default query
}

$result = $conn->query($sql);
include('includes/admin_navbar.php');
include('includes/admin_leftbar.php');
include('linking.php');
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
            color: #ffffff;
        }
        .product-image {
            width: 100px;
            height: auto;
            border-radius: 8px;
        }
        .filter-section {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-10">
    <!-- Filter Section -->
    <div class="filter-section">
        <h4><br><br><br><h2 class="text-center mb-4">Product List</h2>
        Filter Products by Category</h4>
        <div>
            <label><input type="checkbox" class="filter-checkbox" value="Male Adult"> Male Adult</label>
            <label><input type="checkbox" class="filter-checkbox" value="Female Adult"> Female Adult</label>
            <label><input type="checkbox" class="filter-checkbox" value="Boys Child"> Boys Child</label>
            <label><input type="checkbox" class="filter-checkbox" value="Girls Child"> Girls Child</label>
            <label><input type="checkbox" class="filter-checkbox" value="Furniture"> Furniture</label>
            <label><input type="checkbox" class="filter-checkbox" value="Electronics"> Electronics</label>
        </div>
        </div>
    

    <!-- Success/Error Messages -->
    <?php if ($message): ?>
        <div class="alert <?php echo $isError ? 'alert-danger' : 'alert-success'; ?> text-center" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Product Table -->
    <div class="table-container">
         <table class="table table-bordered table-hover">
            <thead class="text-center bg-warning">
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
            <tbody id="productTable">
                <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='text-center'>";
                        echo "<td>" . $count++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['category']) . "</td>";

                        if($row['disabled']==0){
        echo "<td>" . htmlspecialchars($row['name']) ."</td>";

                        }else{
        echo "<td>" . htmlspecialchars($row['name']) . "  <span class='bg-danger'> DISABLED</span>" ."</td>";

                        }
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
                        echo "<td>
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
        </div>   </div>
        </div>

<!-- Modals for Edit and Delete -->
<!-- Edit Product Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST">
                <input type="hidden" name="action" value="edit">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editCategory">Category</label>
                        <input type="text" class="form-control" id="editCategory" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="editName">Product Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice">Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editMaterial">Material</label>
                        <input type="text" class="form-control" id="editMaterial" name="material" required>
                    </div>
                    <div class="mb-3">
                    Do you wants to Disable this product?

                        <div class="form-check">
            <input class="form-check-input" type="radio" name="disabledStatus" id="enable" value="false" checked>
            <label class="form-check-label" for="enable">
                NO
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="disabledStatus" id="disable" value="true">
            <label class="form-check-label" for="disable">
                YES
            </label>
        </div>                    </div>

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
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Filter Products
        $('.filter-checkbox').change(function () {
            const selectedCategories = $('.filter-checkbox:checked').map(function () {
                return $(this).val();
            }).get();

            $.ajax({
                url: '',
                method: 'POST',
                data: {categories: selectedCategories},
                success: function (response) {
                    const tbodyContent = $(response).find('#productTable').html();
                    $('#productTable').html(tbodyContent);
                }
            });
        });

        // Populate Edit Modal
        window.populateEditModal = function (row) {
            document.getElementById('editId').value = row.id;
            document.getElementById('editCategory').value = row.category;
            document.getElementById('editName').value = row.name;
            document.getElementById('editPrice').value = row.price;
            document.getElementById('editDescription').value = row.description;
            document.getElementById('editMaterial').value = row.material;
            document.getElementById('editMaterial').value = row.material;
        };

        // Set Delete ID
        window.setDeleteId = function (id) {
            document.getElementById('deleteId').value = id;
        };
    });
</script>
</body>
</html>
