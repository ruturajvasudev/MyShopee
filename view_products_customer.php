<?php


$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";
$port = 3306;
// Check if the user is logged in


// Create a connection
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products based on filters
$categoryFilter = $_POST['categories'] ?? [];
$minPrice = $_POST['minPrice'] ?? 0;
$maxPrice = $_POST['maxPrice'] ?? 1000000;

$categoryCondition = count($categoryFilter) > 0 ? "category IN ('" . implode("','", $categoryFilter) . "')" : "1";
$priceCondition = "price BETWEEN $minPrice AND $maxPrice";

$sql = "SELECT * FROM products WHERE $categoryCondition AND $priceCondition and DISABLED=false";
$result = $conn->query($sql);
include('includes/customer_navbar.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Product Display</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
     
<head>
    <meta charset="utf-8">
    <title>mm - Bakery Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        
        .container {
            margin-top: 30px;
        }
        .filter-section {
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-card {
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        .product-card img {
            width: 100%;
            height: 200px;
           
            object-fit: contain;
            border-radius: 8px;
        }
        .product-details {
            text-align: center;
        }
        .price-range {
            margin-top: 20px;
        }
    </style>
</head>
<body>
  
<div class="container"><br><br><br>
    <div class="row"><br><br><br>
        <!-- Filters Section -->
        <div class="col-md-3">
            <div class="filter-section">
                <h4>Filters</h4>
                <hr>
                <!-- Category Filter -->
                <h6>Category</h6>
                <div>
                    <label><input type="checkbox" class="filter-checkbox" value="Male Adult"> Male Adult</label><br>
                    <label><input type="checkbox" class="filter-checkbox" value="Female Adult"> Female Adult</label><br>
                    <label><input type="checkbox" class="filter-checkbox" value="Boys Child"> Boys Child</label><br>
                    <label><input type="checkbox" class="filter-checkbox" value="Girls Child"> Girls Child</label><br>
                    <label><input type="checkbox" class="filter-checkbox" value="Furniture"> Furniture</label><br>
                    <label><input type="checkbox" class="filter-checkbox" value="Electronics"> Electronics</label>
                </div>

                <!-- Price Range Filter -->
                <div class="price-range">
                    <h6>Price Range</h6>
                    <input type="range" class="form-range" id="priceRange" min="0" max="100000" step="1000">
                    <p>Price: ₹<span id="priceValue">100000</span></p>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="col-md-9">
            <div class="row" id="productContainer">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-4">
                            <a href="product.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                                <div class="product-card">
                                    <!-- Product Image Slideshow -->
                                <div id="carousel-i<?php echo $row['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo $row['image1']; ?>" alt="Image 1">
                                        </div>
                                        <?php if ($row['image2']): ?>
                                            <div class="carousel-item">
                                                <img src="<?php echo $row['image2']; ?>" alt="Image 2">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carousel-i<?php echo $row['id']; ?>" role="button" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel-i<?php echo $row['id']; ?>" role="button" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </a>
                                </div>

                                <!-- Product Details -->
                                    
                                    <div class="product-details">
                                        <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                                        <p>Category: <?php echo htmlspecialchars($row['category']); ?></p>
                                        <h6>Price: ₹<?php echo number_format($row['price'], 2); ?></h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php


                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Update price range value
        $('#priceRange').on('input', function () {
            $('#priceValue').text($(this).val());
        });

        // Filter products dynamically
        $('.filter-checkbox, #priceRange').on('change input', function () {
            const selectedCategories = $('.filter-checkbox:checked').map(function () {
                return $(this).val();
            }).get();
            const maxPrice = $('#priceRange').val();

            $.ajax({
                url: '', // Same file
                method: 'POST',
                data: {categories: selectedCategories, minPrice: 0, maxPrice: maxPrice},
                success: function (response) {
                    const productContent = $(response).find('#productContainer').html();
                    $('#productContainer').html(productContent);
                }
            });
        });
    });
</script>
    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>

<?php

?>
