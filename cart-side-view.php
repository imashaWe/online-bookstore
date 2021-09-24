<div class="offcanvas offcanvas-end" tabindex="-1" id="cartSideView" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Your Cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="cart-item-list-view">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="theme-card shadow m-2">

                    <div class="row g-0">
                        <div class="col-4">
                            <img src="https://picsum.photos/200" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col pt-1 align-content-center">
                            <h6 class="theme-text-title">First Book</h6>
                            <small class="py-3 text-muted theme-text">1 X $19</small>
                            <div class="rating-bar" data-rate="1.2" data-max="5"></div>
                        </div>
                    </div>

                </div>
            <?php endfor; ?>
        </div>

        <h3 class="theme-text-heading">TOTAL:$75</h3>
        <br>
        <div class="row justify-content-evenly">
            <div class="col">
                <a href="" class="theme-btn theme-btn-light-animated theme-text-subtitle">VIEW CART</a>
            </div>
            <div class="col">
                <a href="" class="theme-btn theme-btn-dark-animated theme-text-subtitle">CHECKOUT</a>
            </div>

        </div>
    </div>
</div>