<?php
require_once 'core/user.php';
require_once 'core/db.php';
$uid = $USER['uid'];

$sql = "SELECT book.*,user_cart.qty FROM user_cart 
            INNER JOIN book ON book.id = user_cart.book_id
            WHERE user_cart.uid = {$uid}";
$cart = $conn->query($sql);
?>
<?php require_once "header.php" ?>
<main>
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="cart-side-view.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">PRODUCT</th>
                                <th scope="col">PRICE</th>
                                <th scope="col">QUANTITY</th>
                                <th scope="col">TOTAL</th>
                            </tr>
                            </thead>
                            <tbody id="cardTableBody">
                            <?php while ($row = $cart->fetch_array()): ?>
                                <tr>
                                    <td>
                                        <img src="<?= $row['img_url'] ?>"
                                             class="img-fluid"
                                             alt="Book Image"
                                             style="height: 10vh;"
                                        >
                                        <?= $row['name'] ?>
                                    </td>
                                    <td class="card-item-price"><?= $row['price'] ?></td>
                                    <td>
                                        <div class="btn-group btn-qty-group" role="group" aria-label="amount">
                                            <button type="button" class="btn btn-outline-secondary"
                                                    onclick="decreaseQty(this,<?= $row['id'] ?>);">-
                                            </button>
                                            <button type="button"
                                                    class="btn btn-secondary card-item-qty"><?= $row['qty'] ?></button>
                                            <button type="button" class="btn btn-outline-secondary"
                                                    onclick="increaseQty(this,<?= $row['id'] ?>);">+
                                            </button>
                                        </div>
                                    </td>
                                    <td class="card-item-subtotal">0.00</td>
                                </tr>
                            <?php endwhile; ?>

                            </tbody
                        </table>
                        <form action="" method="post">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="coupen_code"
                                               placeholder="Coupen Code">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-secondary">APPLY COUPON</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-secondary">UPDATE CART</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <h4>CART TOTALS</h4>
                                <td>
                                    Subtotal:
                                </td>
                                <td id="cardSubtotal">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Shipping:
                                </td>
                                <td>
                                    <p>Flat rate: $2.00</p>
                                    <p>CALCULATE SHIPPING</p>
                                    <form action="" method="post">
                                        <div class="mb-3">
                                            <select class="form-select" aria-label="country">
                                                <option selected>Select a country</option>
                                                <option value="1">USA</option>
                                                <option value="2">UK</option>
                                                <option value="3">Sri Lanka</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="town" placeholder="Town/City">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="postcode"
                                                   placeholder="Postcode/Zip">
                                        </div>
                                        <button type="button" class="btn btn-secondary">UPDATE TOTALS</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Total:</h5>
                                </td>
                                <td id="cardTotal">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <form action="" method="">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-dark">PROCEED TO CHECKOUT</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
</main>

<?php require_once "footer.php" ?>
