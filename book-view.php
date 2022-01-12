<?php
require "core/db.php";

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $sql = "SELECT 
        book.id,book.name AS name,price,isbn,img_url,description,
        CONCAT(book_author.fname,' ',book_author.lname) AS author,book_author.id AS author_id,
        book_publisher.name AS publisher,book_publisher.id AS publisher_id,
        book_language.language,
        IFNULL((SELECT (SUM(in_qty) -SUM(out_qty)) FROM book_stock WHERE book_id = book.id),0) AS qty
        FROM book
        INNER JOIN book_author ON book_author.id = book.author_id
        INNER JOIN book_publisher ON book_publisher.id = book.publisher_id
        INNER JOIN book_language ON book_language.id = book.language_id
        WHERE book.is_delete = '0'AND slug ='{$slug}' ";
    $res = $conn->query($sql);
    if (!$res->num_rows) {
        header("location:page-404.php");
        die();
    }
    $book = $res->fetch_array();
} else {
    header("location:page-404.php");
}

?>
<?php require_once "header.php" ?>
    <main>
        <div class="container my-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Book Overview</li>
                </ol>
            </nav>
            <div class="row justify-content-center">
                <div class="col-md-4 text-center">
                    <img src="<?= $book['img_url'] ?>"
                         class="img-thumbnail">
                </div>
                <div class="col-md-6 text-start">
                    <h5 class="theme-text-heading">
                        <?= $book['name'] ?>
                        <?php if ($book['qty'] > 0): ?>
                            <span class="badge bg-success">IN STOCK</span>
                        <?php else: ?>
                            <span class="badge bg-danger">OUT OF STOCK</span>
                        <?php endif; ?>
                    </h5>
                    <hr>
                    <div class="row my-3">
                        <div class="col">
                            <h5 class="theme-text-title text-start theme-primary-color">LKR <?= $book['price'] ?></h5>
                            <h6>Quantity:</h6>
                            <div class="btn-group" role="group" aria-label="amount">
                                <button type="button" class="btn btn-outline-secondary" onclick="decrease()">-</button>
                                <button type="button" class="btn btn-secondary" id="qtyView">1</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="increase();">+</button>
                            </div>

                        </div>
                    </div>
                    <div class="row justify-content-start my-3 gy-2">
                        <?php if (IS_LOGGED_IN && $USER['status']): ?>

                            <div class="col-md-4">
                                <button class="theme-btn theme-btn-dark-animated theme-font-bold"
                                    <?php if ($book['qty'] <= 0) echo "disabled"; ?>
                                        onclick="addToCartNow(<?= $book['id'] ?>);">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="theme-btn theme-btn-light-animated theme-font-bold"
                                        onclick="addToWishlist(<?= $book['id'] ?>)">
                                    <i class="far fa-heart" aria-hidden="true"></i>&nbsp;Add to wishlist
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="col-md-4">
                                <a class="theme-btn theme-btn-dark-animated theme-font-bold"
                                   href="<?= IS_LOGGED_IN ? 'verify.php' : 'login.php' ?>">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a class="theme-btn theme-btn-light-animated theme-font-bold"
                                   href="<?= IS_LOGGED_IN ? 'verify.php' : 'login.php' ?>">
                                    <i class="far fa-heart" aria-hidden="true"></i>&nbsp;Add to wishlist
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                    <hr>
                    <div class="row my-3">
                        <div class="col">
                            <h6>Language : <?= $book['language'] ?></h6>
                            <h6>
                                Author :<a href="index.php?author=<?= $book['author_id'] ?>"><?= $book['author'] ?></a>
                            </h6>
                            <h6>
                                Publisher : <a
                                        href="index.php?publisher=<?= $book['publisher_id'] ?>"><?= $book['publisher'] ?></a>
                            </h6>
                            <h6>ISBN : <?= $book['isbn'] ?></h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p class="theme-text"><?= $book['description'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function increase() {
            const qtyView = document.getElementById('qtyView');
            let qty = parseInt(qtyView.innerHTML);
            qty++;
            qtyView.innerHTML = qty.toString();
        }

        function decrease() {
            const qtyView = document.getElementById('qtyView');
            let qty = parseInt(qtyView.innerHTML);
            if (qty == 1) return;
            qty--;
            qtyView.innerHTML = qty.toString();
        }

        function addToCartNow(bookID) {
            const qty = document.getElementById('qtyView').innerHTML;

            postData('api/cart.php?func=add_to_cart', {'book_id': bookID, 'qty': qty}).then((r) => {

                if (r.status) {
                    successAlert(r.message);
                } else {
                    errorAlert(r.message);
                }

                setCartCount();
            });
        }
    </script>
<?php require_once "footer.php" ?>