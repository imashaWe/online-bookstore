<?php
require_once 'core/user.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Berries</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/images/favicon.png"/>
    <!-- bootstrap ccs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--custom design css-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/side-nav.css">
    <!--theme  css-->
    <link rel="stylesheet" href="css/theme.css">
    <!--fontawesome icon-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
            crossorigin="anonymous"></script>
    <!--material icon-->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">



</head>
<body>
<header>

    <nav class="navbar navbar-expand-lg py-1 navbar-dark fixed-top theme-primary-color-bg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/images/navlogo.png" alt="" width="200" height="50">
            </a>
<!--            <a class="navbar-brand" href="#">Online BookStore</a>-->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll theme-font-bold"
                    style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>

                <div class="icon-header-item"
                     id="cartCount"
                     style="padding-right: 11px;"
                     data-bs-toggle="offcanvas"
                     data-bs-target="#cartSideView"
                     aria-controls="offcanvasRight">
                    <i class="zmdi zmdi-shopping-cart" style="color: white"></i>
                </div>
                <div class="icon-header-item"
                     id="wishlistCountElm"
                     onclick="window.location.replace('wishlist.php')"
                     style="padding-right: 11px;padding-left: 22px">
                    <i class="zmdi zmdi-favorite-outline" style="color: white"></i>
                </div>


            </div>
        </div>
    </nav>
</header>
<br><br><br><br>
<?php if (IS_LOGGED_IN && !$USER['status']): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p>Verification email has been sent.<a href="verify.php" class="alert-link">verify your account.</a></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

