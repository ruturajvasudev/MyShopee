
<?php
$username="";
// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
   
            $username="Welcome ".$_SESSION['user_name'];
           
}

?>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-warning" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid top-bar bg-dark text-light px-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="row gx-0 align-items-center d-none d-lg-flex">
        <div class="col-lg-6 px-5 text-start">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item position-relative">
                    <!-- Dropdown for user actions -->
                    <div class="nav-item dropdown">
                        <a href="#" class="small text-light dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, <?php echo $username; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown" style="z-index: 1050;">
                            <li><a class="dropdown-item" href="view_profile.php">View Profile</a></li>
                            <li><a class="dropdown-item" href="view_orders_by_customer.php">View Orders</a></li>
                            <li><a class="dropdown-item" href="logout_customer.php">Logout</a></li>
                        </ul>
                    </div>
                </li>
                <li class="breadcrumb-item"><a class="small text-light" href="#">Career</a></li>
                <li class="breadcrumb-item"><a class="small text-light" href="#">Terms</a></li>
                <li class="breadcrumb-item"><a class="small text-light" href="#">Privacy</a></li>
            </ol>
        </div>
        <div class="col-lg-6 px-5 text-end">
            <small>Follow us:</small>
            <div class="h-100 d-inline-flex align-items-center">
                <a class="btn-lg-square text-warning border-end rounded-0" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn-lg-square text-warning border-end rounded-0" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn-lg-square text-warning border-end rounded-0" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="btn-lg-square text-warning pe-0" href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>

    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav style="background-color:black;" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="text-warning m-0">DSTS.com.!</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="view_products_customer.php" class="nav-item nav-link">Shop</a>
                <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                <a href="login2.php" class="nav-item nav-link">Register/Login</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="view_orders_by_customer.php" class="dropdown-item">View Orders</a>
                       
                    </div>
                </div>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>
            <div class=" d-none d-lg-flex">
                <div class="flex-shrink-0 btn-lg-square border border-light rounded-circle">
                    <i class="fa fa-phone text-warning"></i>
                </div>
                <div class="ps-3">
                    <small class="text-warning mb-0">Call Us</small>
                    <p class="text-light fs-5 mb-0">7038529092</p>
                </div>
            </div>
        </div>
    </nav>