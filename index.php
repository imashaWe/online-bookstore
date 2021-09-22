<?php require_once "header.php" ?>

<main>
    <div class="container my-5">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php for ($i = 0;
                       $i < 20;
                       $i++): ?>
                <div class="col">
                    <div class="card">

                        <div class="card-body">

                            <!--                    <div class="ribbon ribbon-top-left"><span>OUT OF STOCK</span></div>-->
                            <div class="item-pic item-img-hov">
                                <div class="btn-set-wishlist icon-circle"><i class="far fa-heart fa-lg"></i></div>
                                <img src="https://online-bookstore.azurewebsites.net/admin/uploads/book-img-c4ca4238a0b923820dcc509a6f75849b.jpg"
                                     alt="IMG-PRODUCT">
                                <a href="book-view.php?slug=my-book" class="item-btn flex-c-m item-btn-font item-btn-hov item-trans">
                                    Quick View
                                </a>
                            </div>
                            <h5 class="card-title theme-text-title mt-1">Book title</h5>
                            <small class="theme-text text-muted">This is a longer card with supporting text below as a
                                natural
                                lead-in
                                to additional content. This content is a little bit longer.</small>
                            <div class="row justify-content-between">
                                <div class="col">
                                    <div class="rating-bar" data-rate="4.2" data-max="5"></div>
                                </div>
                                <div class="col">
                                    <h5 class="theme-text-title text-end theme-primary-color">LKR 300</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="theme-btn theme-btn-dark-animated theme-font-bold">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

</main>

<?php require_once "footer.php" ?>

