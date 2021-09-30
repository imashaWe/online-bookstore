<?php
require_once "core/db.php";
$sql = "SELECT * FROM book_category WHERE is_delete = 0 LIMIT 5";
$categories = $conn->query($sql);
?>
<?php require_once 'cart-side-view.php'; ?>

<footer>
    <div class="container-fluid bg-dark position-absolute footer mt-2">
        <div class="d-none d-sm-block">
            <div class="row justify-content-center pt-5">

                <div class="col-2">
                    <h4>CATEGORY</h4>
                    <ul class="list-unstyled">
                        <?php while ($row = $categories->fetch_array()): ?>
                            <li>
                                <a href="<?= change_url_params_array(array(
                                    array('key' => 'cat', 'value' => $row['id']),
                                    array('key' => 'sub_cat'),
                                ));
                                ?>">
                                    <?= $row['category'] ?>
                                </a>
                            </li>
                        <?php endwhile; ?>

                    </ul>
                </div>

                <div class="col-2">
                    <h4>HELP</h4>
                    <ul class="list-unstyled">
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>

                <div class="col-2">
                    <h4>GET IN TOUCH</h4>
                    <p>N0 10,<br>Daluagama,<br>Kelaniya</p>
                    <p>call us on (+94) 76 716 6879</p>
                    <div class="d-flex gap-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div class="col-2">
                    <h4>NEWSLETTER</h4>
                    <input type="text" class="form-control" placeholder="email@exsapmle.com">
                    <button type="submit" class="theme-btn theme-btn-accent-animated theme-text-subtitle mt-2">Subscribe
                    </button>
                </div>

            </div>
        </div>

        <div class="row text-center pt-3">
            <p>Copyright ©<?= date("Y") ?> All rights reserved |Made with
                <i class="fas fa-heart" aria-hidden="true"></i>
                by Debuggers
            </p>
        </div>

    </div>
</footer>


<!-- bootstrap js-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

<script src="js/main.js"></script>
<script src="js/fetch.js"></script>
<script src="js/cart.js"></script>
<script src="js/wishlist.js"></script>

<!-- sweetalert js-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--Toast js-->
<script src="js/vanilla-toast.min.js"></script>


</body>
</html>
