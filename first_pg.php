<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop - Your Online Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(45deg, #ff7eb3, #ff758c);
        }
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff !important;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 1rem;
            margin: 0 10px;
        }
        .hero {
            background: url('https://via.placeholder.com/1920x800') no-repeat center center/cover;
            height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
        }
        .hero h1 {
            font-size: 4rem;
            text-transform: uppercase;
            animation: fadeInDown 1.5s ease;
        }
        .hero p {
            font-size: 1.5rem;
            margin-top: 10px;
            animation: fadeInUp 1.5s ease;
        }
        .hero .btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1.2rem;
            animation: fadeInUp 2s ease;
        }
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .categories {
            padding: 50px 0;
            background: #ffeff7;
        }
        .categories h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            color: #ff758c;
        }
        .categories .card {
            border: none;
            transition: all 0.3s ease;
        }
        .categories .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .categories img {
            border-radius: 15px;
        }
        .products {
            padding: 50px 0;
        }
        .products h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ff758c;
            font-weight: bold;
        }
        .products .card {
            border: none;
            transition: transform 0.3s ease;
        }
        .products .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .footer {
            background: #343a40;
            color: #fff;
            padding: 20px 0;
        }
        .footer a {
            color: #ff758c;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">MyShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to MyShop</h1>
        <p>Discover Amazing Deals Every Day!</p>
        <a href="#" class="btn btn-primary">Shop Now</a>
    </div>

    <!-- Categories Section -->
    <div class="categories">
        <div class="container">
            <h2>Shop by Categories</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Electronics">
                        <div class="card-body text-center">
                            <h5>Electronics</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Fashion">
                        <div class="card-body text-center">
                            <h5>Fashion</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Home & Living">
                        <div class="card-body text-center">
                            <h5>Home & Living</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Beauty">
                        <div class="card-body text-center">
                            <h5>Beauty</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="products">
        <div class="container">
            <h2>Featured Products</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product 1">
                        <div class="card-body text-center">
                            <h5>Product 1</h5>
                            <p>₹500</p>
                            <a href="#" class="btn btn-primary btn-sm">Buy Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product 2">
                        <div class="card-body text-center">
                            <h5>Product 2</h5>
                            <p>₹750</p>
                            <a href="#" class="btn btn-primary btn-sm">Buy Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product 3">
                        <div class="card-body text-center">
                            <h5>Product 3</h5>
                            <p>₹1,200</p>
                            <a href="#" class="btn btn-primary btn-sm">Buy Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product 4">
                        <div class="card-body text-center">
                            <h5>Product 4</h5>
                            <p>₹999</p>
                            <a href="#" class="btn btn-primary btn-sm">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div
