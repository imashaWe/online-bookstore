<?php
require "core/db.php";
/* pagination */
$sql = "SELECT COUNT(id) AS count FROM book WHERE is_delete = '0' ";
$count = $conn->query($sql)->fetch_array()['count'];
$limit = 20;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$num_pages = ceil($count / $limit);
$start = ($page - 1) * $limit;

$sql = "SELECT id,name,img_url,slug,price,SUBSTRING(description,1,100) AS description
        FROM `online-bookstore`.book
        WHERE is_delete = '0'  
        LIMIT {$start},{$limit}";
$books = $conn->query($sql);
?>

<?php require_once "header.php" ?>
<?php
    echo $_SERVER['REQUEST_URI'];
?>
<main>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php while ($book = $books->fetch_array()):?>
                <div class="col">
                    <div class="card h-100">

                        <div class="card-body">

                            <!--<div class="ribbon ribbon-top-left"><span>OUT OF STOCK</span></div>-->
                            <div class="item-pic item-img-hov">
                                <div class="btn-set-wishlist icon-circle"><i class="far fa-heart fa-lg"></i></div>
                                <img src="<?=$book['img_url']?>"
                                     alt="<?=$book['slug']?>">
                                <a href="book-view.php?slug=<?=$book['slug']?>" class="item-btn flex-c-m item-btn-font item-btn-hov item-trans">
                                    Quick View
                                </a>
                            </div>
                            <div style="height: 10%"><h5 class="card-title theme-text-title mt-1"><?=$book['name']?></h5></div>
                            <div style="height: 20%"><small class="theme-text text-muted"><?=$book['description']?></small></div>
                            <div class="row justify-content-between">
                                <div class="col">
                                    <div class="rating-bar" data-rate="4.2" data-max="5"></div>
                                </div>
                                <div class="col">
                                    <h5 class="theme-text-title text-end theme-primary-color">LKR <?=$book['price']?></h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="theme-btn theme-btn-dark-animated theme-font-bold">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                                </button>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</main>

<?php require_once "footer.php" ?>

