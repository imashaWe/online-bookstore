<?php
require "core/db.php";
require "core/user.php";
require "core/route.php";
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

$sql = "SELECT * FROM book_category WHERE is_delete = 0";
$categories = $conn->query($sql);

function get_sub_categories($category_id, $conn)
{
    $sql = "SELECT * FROM book_sub_category WHERE category_id = {$category_id} AND is_delete = 0";
    return $conn->query($sql);
}

?>

<?php require_once "header.php" ?>

<main>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Recipient's username"
                           aria-describedby="button-addon2">
                    <button class="btn btn-dark" type="button" id="button-addon2">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">All Categories</div>
                            <?php while ($row = $categories->fetch_array()): ?>
                                <?php
                                $sub_categories = get_sub_categories($row['id'], $conn);
                                $collapse_class = "collapse";
                                $no_collapse_class = "nav-link";
                                if (isset($_GET['cat']) && $_GET['cat'] == $row['id']) {
                                    $collapse_class = "collapse show";
                                    $no_collapse_class = "nav-link active";
                                }
                                ?>

                                <?php if ($sub_categories->num_rows): ?>

                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                       data-bs-target="#collapseLayouts-<?= $row['id'] ?>"
                                       aria-expanded="false"
                                       aria-controls="collapseLayouts">
                                        <?= $row['category'] ?>
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>

                                    <div class="<?= $collapse_class ?>" id="collapseLayouts-<?= $row['id'] ?>"
                                         aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">

                                            <?php while ($sub_row = $sub_categories->fetch_array()): ?>
                                                <?php
                                                $link_class = "nav-link";
                                                if (isset($_GET['sub_cat']) && $_GET['sub_cat'] == $sub_row['id']) {
                                                    $link_class =
                                                        "nav-link active";
                                                }
                                                ?>
                                                <a class="<?= $link_class ?>"
                                                   href="<?= change_url_params_array(array(
                                                       array('key' => 'cat', 'value' => $row['id']),
                                                       array('key' => 'sub_cat', 'value' => $sub_row['id']),
                                                   ));
                                                   ?>">
                                                    <?= $sub_row['sub_category'] ?>
                                                </a>
                                            <?php endwhile; ?>

                                        </nav>
                                    </div>

                                <?php else: ?>
                                    <a class="<?= $no_collapse_class ?>"
                                       href="<?= change_url_params_array(array(
                                           array('key' => 'cat', 'value' => $row['id']),
                                           array('key' => 'sub_cat'),
                                       ));
                                       ?>">
                                        <?= $row['category'] ?>
                                    </a>
                                <?php endif; ?>

                            <?php endwhile; ?>

                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-9">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php while ($book = $books->fetch_array()): ?>
                        <div class="col">
                            <div class="card h-100">

                                <div class="card-body">

                                    <!--<div class="ribbon ribbon-top-left"><span>OUT OF STOCK</span></div>-->
                                    <div class="item-pic item-img-hov">
                                        <div class="btn-set-wishlist icon-circle"><i class="far fa-heart fa-lg"></i>
                                        </div>
                                        <img src="<?= $book['img_url'] ?>"
                                             alt="<?= $book['slug'] ?>">
                                        <a href="book-view.php?slug=<?= $book['slug'] ?>"
                                           class="item-btn flex-c-m item-btn-font item-btn-hov item-trans">
                                            Quick View
                                        </a>
                                    </div>
                                    <div style="height: 10%"><h5
                                                class="card-title theme-text-title mt-1"><?= $book['name'] ?></h5></div>
                                    <div style="height: 20%"><small
                                                class="theme-text text-muted"><?= $book['description'] ?></small></div>
                                    <div class="row justify-content-between">
                                        <div class="col">
                                            <div class="rating-bar" data-rate="4.2" data-max="5"></div>
                                        </div>
                                        <div class="col">
                                            <h5 class="theme-text-title text-end theme-primary-color">
                                                LKR <?= $book['price'] ?></h5>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <?php if ($IS_LOGGED_IN && $USER['status']): ?>
                                            <button class="theme-btn theme-btn-dark-animated theme-font-bold"
                                                    onclick="addToCart(<?= $book['id'] ?>)">
                                                <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                                            </button>
                                        <?php else: ?>
                                            <a class="theme-btn theme-btn-dark-animated theme-font-bold"
                                               href="<?= $IS_LOGGED_IN ? 'verify.php' : 'login.php' ?>">
                                                <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>


</main>
<?php require_once "footer.php" ?>

