<?php
require_once 'core/user.php';
require_once 'core/db.php';

login_access_protect();

$uid = $USER['uid'];
$city = "";
$address_line1 = "";
$address_line2 = "";
$post_code = "";

$sql = "SELECT book.*,user_cart.qty FROM user_cart 
            INNER JOIN book ON book.id = user_cart.book_id
            WHERE user_cart.uid = {$uid}";
$cart = $conn->query($sql);

$sql = "SELECT coupon_code.* FROM coupon_code_apply 
        INNER JOIN coupon_code ON coupon_code.id = coupon_code_apply.coupon_id AND uid = {$uid} AND order_id = 0";
$coupons = $conn->query($sql);

$sql = "SELECT * FROM site_user_address WHERE uid = {$uid}";
$res = $conn->query($sql);
if ($res->num_rows) {
    $row = $res->fetch_array();
    $city = $row['city'];
    $address_line1 = $row['address_line1'];
    $address_line2 = $row['address_line2'];
    $post_code = $row['post_code'];
}
?>
<?php require_once "header.php" ?>
<main>
    <div class="container py-4">

        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div class="row gy-2">

            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="theme-text-title">
                                <tr>
                                    <th scope="col">PRODUCT</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">QUANTITY</th>
                                    <th scope="col" class="text-end">TOTAL</th>
                                </tr>
                                </thead>
                                <tbody class="theme-text" id="cartTableBody">
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
                                        <td class="cart-item-price"><?= $row['price'] ?></td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="amount">
                                                <button type="button" class="btn btn-outline-secondary"
                                                        onclick="decreaseQty(this,<?= $row['id'] ?>);">-
                                                </button>
                                                <button type="button"
                                                        class="btn btn-secondary cart-item-qty"><?= $row['qty'] ?></button>
                                                <button type="button" class="btn btn-outline-secondary"
                                                        onclick="increaseQty(this,<?= $row['id'] ?>);">+
                                                </button>
                                            </div>
                                        </td>
                                        <td class="cart-item-subtotal text-end">0.00</td>
                                    </tr>
                                <?php endwhile; ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" placeholder="Coupon Code" id="couponCode">
                            </div>
                            <div class="col-sm-3">
                                <button type="button"
                                        class="theme-btn theme-btn-light-animated theme-text-title"
                                        onclick="applyCoupon();"
                                >
                                    APPLY COUPON
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <tr class="theme-text">
                                <h4 class="theme-text-heading">CART TOTALS</h4>
                                <td>
                                    Subtotal:
                                </td>
                                <td id="cartSubtotal">
                                </td>
                            </tr>
                            </tbody>
                            <tbody class="theme-text" id="couponCodeTbody">
                            <?php while ($row = $coupons->fetch_array()): ?>
                                <tr>
                                    <td>Coupon (<?= $row['code'] ?>)</td>
                                    <td class="coupon-code-discount" data-discount="<?= $row['discount'] ?>">
                                        <?= $row['discount'] ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            </tbody>
                            <tbody>
                            <tr class="theme-text">
                                <td>
                                    Shipping:
                                </td>
                                <td>
                                    <form id="frmPayHere" method="post"
                                          action="https://sandbox.payhere.lk/pay/checkout">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="city"
                                                   value="<?= $city ?>"
                                                   placeholder="Town/City">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="addressLine1"
                                                   value="<?= $address_line1 ?>"
                                                   placeholder="Address Line 1">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="addressLine2"
                                                   value="<?= $address_line2 ?>"
                                                   placeholder="Address Line 2">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="postcode"
                                                   value="<?= $post_code ?>"
                                                   placeholder="Postcode/Zip">
                                        </div>
                                        <!--PayHere inputs-->
                                        <input type="hidden" name="merchant_id">
                                        <input type="hidden" name="return_url">
                                        <input type="hidden" name="cancel_url">
                                        <input type="hidden" name="notify_url">
                                        <!--Item Details-->
                                        <input type="hidden" name="order_id">
                                        <input type="hidden" name="items">
                                        <input type="hidden" name="currency">
                                        <input type="hidden" name="amount">
                                        <!--Customer Details-->
                                        <input type="hidden" name="first_name">
                                        <input type="hidden" name="last_name">
                                        <input type="hidden" name="email">
                                        <input type="hidden" name="phone">
                                        <input type="hidden" name="address">
                                        <input type="hidden" name="city">
                                        <input type="hidden" name="country">
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>TOTAL:</h5>
                                </td>
                                <td>
                                    <h5 id="cartTotal"></h5>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="col-md-12 text-center">
                            <button type="button"
                                    class="theme-btn theme-btn-dark-animated theme-text-title"
                                    onclick="setCheckout()">
                                CHECKOUT
                            </button>
                        </div>


                    </div>
                </div>
            </div>

        </div>

    </div>


</main>
<script>
    function applyCoupon() {
        const couponCode = document.getElementById('couponCode').value;

        if (!couponCode.length) return;

        postData('api/checkout.php?func=apply_coupon_code', {'coupon_code': couponCode}).then((r) => {
            if (parseInt(r.status)) {
                const html = '<tr>' +
                    '<td>Coupon (' + r.data.coupon + ')</td>' +
                    '<td class="coupon-code-discount text-right" data-discount="' + r.data.discount + '"></td>' +
                    '</tr>';
                document.getElementById('couponCodeTbody').insertAdjacentHTML('beforeend', html);
                calcCartAmount();
                successAlert(r.message);
            } else {
                errorAlert(r.message);
            }
        })

    }

    function setCheckout() {
        const city = document.getElementById('city').value;
        const addressLine1 = document.getElementById('addressLine1').value;
        const addressLine2 = document.getElementById('addressLine2').value;
        const postCode = document.getElementById('postcode').value;
        if (!(city && addressLine1 && addressLine2 && postCode)) {
            return;
        }
        postData('api/checkout.php?func=set_order',
            {'city': city, 'address_line1': addressLine1, 'address_line2': addressLine2, 'post_code': postCode}
        ).then((r) => {
            if (parseInt(r.status)) {
                const data = r.data;
                for (const [key, value] of Object.entries(data)) {
                    document.getElementsByName(key)[0].value = value;
                }
                document.getElementById('frmPayHere').submit();
            }
        });
    }
</script>
<?php require_once "footer.php" ?>
