<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>online bookstore</title>
    <!-- bootstrap ccs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--custom design css-->
    <link rel="stylesheet" href="css/style.css">
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
    <!-- As a link -->
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg py-4 navbar-dark fixed-top theme-primary-color-bg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Online BookStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                    aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll theme-font-bold"
                    style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Register</a>
                    </li>
                </ul>

                <div class="icon-header-item icon-header-noti"
                     data-notify="2" style="padding-right: 11px;"
                     data-bs-toggle="offcanvas"
                     data-bs-target="#cartSideView"
                     aria-controls="offcanvasRight">
                    <i class="zmdi zmdi-shopping-cart" style="color: white"></i>
                </div>
                <div class="icon-header-item icon-header-noti" data-notify="2"
                     style="padding-right: 11px;padding-left: 22px">
                    <i class="zmdi zmdi-favorite-outline" style="color: white"></i>
                </div>


            </div>
        </div>
    </nav>
</header>

