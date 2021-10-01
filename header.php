<?php
require_once 'core/user.php';
require_once 'core/route.php';
if (!IS_LOGGED_IN) {
    array_push($routes,
        array('path' => 'register.php', 'name' => 'Register'),
        array('path' => 'login.php', 'name' => 'Log In')
    );
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#4173be" />
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
                    <?php foreach ($routes as $r): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if (check_route_active($r['path'])) echo "active" ?>"
                               aria-current="page" href=" <?= $r['path'] ?>">
                                <?= $r['name'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <li class="nav-item d-block d-sm-none">
                        <a class="nav-link <?php if (check_route_active($r['path'])) echo "active" ?>"
                           aria-current="page" href="checkout.php">
                            Cart
                        </a>
                    </li>

                    <li class="nav-item d-block d-sm-none">
                        <a class="nav-link <?php if (check_route_active($r['path'])) echo "active" ?>"
                           aria-current="page" href="wishlist.php">
                            Wishlist
                        </a>
                    </li>
                    <li class="nav-item d-block d-sm-none">
                        <a class="nav-link <?php if (check_route_active($r['path'])) echo "active" ?>"
                           aria-current="page" href="user-profile.php">
                            Account Settings
                        </a>
                    </li>

                </ul>

                <div class="icon-header-item d-none d-sm-block"
                     id="cartCount"
                     style="padding-right: 11px;"
                     data-bs-toggle="offcanvas"
                     data-bs-target="#cartSideView"
                     aria-controls="offcanvasRight">
                    <i class="zmdi zmdi-shopping-cart" style="color: white"></i>
                </div>

                <div class="icon-header-item mx-4 d-none d-sm-block"
                     id="wishlistCountElm"
                     onclick="window.location.replace('wishlist.php')"
                     style="padding-right: 11px;padding-left: 22px">
                    <i class="zmdi zmdi-favorite-outline" style="color: white"></i>
                </div>

                <?php if (IS_LOGGED_IN && $USER['status']): ?>
                    <!-- user settings-->
                    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 d-none d-sm-block">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               id="navbarDropdown" href="#"
                               role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fas fa-user fa-fw text-light fa-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="user-profile.php">My Account</a></li>
<!--                                <li><a class="dropdown-item" href="#!">My Orders</a></li>-->
                                <li>
                                    <hr class="dropdown-divider"/>
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif ?>

            </div>
        </div>
    </nav>
</header>
<div class="py-4"></div>
<?php if (IS_LOGGED_IN && !$USER['status']): ?>
    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
        <p>Verification email has been sent.<a href="verify.php" class="alert-link">verify your account.</a></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

