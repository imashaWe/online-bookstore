<style>
    .checked {
        color: orange;
    }
</style>
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartSideView" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Your Cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="cart-item-list-view">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://picsum.photos/200" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">First Book</h5>
                                <small>1 X $19</small>
                                <div>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <div>
            <h3>TOTAL:$75</h3>
            <br>
            <div class="row justify-content-start">
                <div class="col-4">
                    <a href="" class="btn btn-outline-dark">VIEW CART</a>
                </div>
                <div class="col-3">
                    <a href="" class="btn btn-dark rounded-3">CHECKOUT</a>
                </div>

            </div>
        </div>
    </div>
</div>