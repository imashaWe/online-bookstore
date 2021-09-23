<?php
require "core/db.php";

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $sql = "SELECT 
        book.id,book.name AS name,price,isbn,img_url,description,
        CONCAT(book_author.fname,' ',book_author.fname) AS author,
        book_publisher.name AS publisher,book_publisher.id AS publisher_id,
        book_language.language
        FROM `online-bookstore`.book
        INNER JOIN book_author ON book_author.id = book.author_id
        INNER JOIN book_publisher ON book_publisher.id = book.publisher_id
        INNER JOIN book_language ON book_language.id = book.language_id
        WHERE book.is_delete = '0'AND slug ='{$slug}' ";
    $book = $conn->query($sql)->fetch_array();
}

?>
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
                    <img src="<?=$book['img_url']?>"
                         alt="">
                </div>
                <div class="col-6 text-start">
                    <h5 class="theme-text-heading"><?=$book['name']?></h5>
                    <hr>
                    <div class="row my-3">
                        <div class="col">
                            <h5 class="theme-text-title text-start theme-primary-color">LKR <?=$book['price']?></h5>
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
                            <h6>Language : <?=$book['language']?></h6>
                            <h6>Author : <a href=""><?=$book['author']?></a></h6>
                            <h6>Publisher : <a href=""><?=$book['publisher']?></a></h6>
                            <h6>ISBN : <?=$book['isbn']?></h6>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <p class="theme-text"><?=$book['description']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php require_once "footer.php" ?>