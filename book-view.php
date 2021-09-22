<?php require_once "header.php" ?>
<main>
    <div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Book Overview</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col-4">
                <img src="https://online-bookstore.azurewebsites.net/admin/uploads/book-img-c4ca4238a0b923820dcc509a6f75849b.jpg" alt="">
            </div>
            <div class="col-6 text-start">
                <h5 class="theme-text-heading">MY FIRST BOOK</h5>
                <hr>
                <div class="row my-3">
                    <div class="col">
                        <h5 class="theme-text-title text-start theme-primary-color">LKR 300</h5>
                        <h6>Quantity:</h6>
                        <div class="btn-group" role="group" aria-label="amount">
                            <button type="button" class="btn btn-outline-secondary">-</button>
                            <button type="button" class="btn btn-secondary">1</button>
                            <button type="button" class="btn btn-outline-secondary">+</button>
                        </div>

                    </div>
                </div>
                <div class="row justify-content-start my-3">
                    <div class="col-4">
                        <button class="theme-btn theme-btn-dark-animated theme-font-bold">
                            <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="theme-btn theme-btn-light-animated theme-font-bold">
                            <i class="far fa-heart" aria-hidden="true"></i>&nbsp;Add to wishlist
                        </button>
                    </div>
                </div>
                <hr>
                <div class="row my-3">
                    <div class="col">
                        <h6>Author : <a href="">V.D.S.Gunawardhana</a></h6>
                        <h6>Publisher : <a href="">Samayawardhana Book Publishers</a></h6>
                        <h6>ISBN : GLH0122</h6>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <p class="theme-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once "footer.php" ?>