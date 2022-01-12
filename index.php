<?php
require "core/db.php";
require "core/user.php";
require "core/route.php";

/* To pagination */
$sql = "SELECT COUNT(id) AS count FROM book WHERE is_delete = '0' ";
$count = $conn->query($sql)->fetch_array()['count'];
$limit = 9;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$num_pages = ceil($count / $limit);
$start = ($page - 1) * $limit;

/* To apply filtering */
$filters = array(
    array('key' => 'cat', 'field' => 'category_id'),
    array('key' => 'sub_cat', 'field' => 'sub_category_id'),
    array('key' => 'author', 'field' => 'author_id'),
    array('key' => 'publisher', 'field' => 'publisher_id'),
);
$where = "WHERE book.is_delete = 0";
foreach ($filters as $filter) {
    if (isset($_GET[$filter['key']])) {
        $field = $filter['field'];
        $value = $_GET[$filter['key']];
        $where .= " AND {$field} = {$value}";
    }
}
/* To apply search */
$joins = "";
if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $joins = "INNER JOIN book_author ON book_author.id = book.author_id
              INNER JOIN book_publisher ON book_publisher.id = book.publisher_id
              INNER JOIN book_category ON book_category.id = book.category_id
              LEFT JOIN book_sub_category ON book_sub_category.id = book.sub_category_id";
    $where .= " AND (
                book.name LIKE '%{$q}%'
                OR
                book.isbn LIKE '%{$q}%'
                OR
                (book_author.is_delete = 0 AND
                (UPPER(book_author.fname) LIKE '%{$q}%' OR UPPER(book_author.lname) LIKE '%{$q}%' 
                  OR UPPER(CONCAT(book_author.fname,' ',book_author.fname)) LIKE '%{$q}%'
                ))
                OR
                (book_publisher.is_delete = 0 AND UPPER(book_publisher.name) LIKE '%{$q}%')
                OR
                (book_category.is_delete = 0 AND UPPER(book_category.category) LIKE '%{$q}%')
                OR
                (book_sub_category.is_delete = 0 AND UPPER(book_sub_category.sub_category) LIKE '%{$q}%')
    )";
}

$sql = "SELECT book.id,book.name,book.img_url,slug,book.price,SUBSTRING(description,1,100) AS description,
        IFNULL((SELECT (SUM(in_qty) -SUM(out_qty)) FROM book_stock WHERE book_id = book.id),0) AS qty
        FROM book 
            " . $joins . "
            " . $where . "
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
    <div class="container mt-5">

        <div class="row justify-content-center pb-4">
            <div class="col-sm-8">
                <div class="wrapper">
                    <div class="search-input">
                        <a href="" target="_blank" hidden></a>
                        <input type="text" placeholder="Type to search..">
                        <div class="autocom-box shadow">
                            <!-- here list are inserted from javascript -->
                        </div>
                        <div class="icon"><i class="fas fa-search"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-3 d-none d-sm-block">
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
                                                       array('key' => 'page'),
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
                                           array('key' => 'page'),
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

            <div class="col-sm-9">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php while ($book = $books->fetch_array()): ?>
                        <div class="col">
                            <div class="card h-100">

                                <div class="card-body">
                                    <?php if ($book['qty'] <= 0): ?>
                                        <div class="ribbon ribbon-top-left"><span>OUT OF STOCK</span></div>
                                    <?php endif; ?>
                                    <div class="item-pic item-img-hov">
                                        <div class="btn-set-wishlist icon-circle" data-id="<?= $book['id'] ?>">
                                            <!--                                            <i class="far fa-heart fa-lg"></i>-->
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
                                            <div class="rating-bar" data-rate="<?= rand(0 * 10, 5 * 10) / 10 ?>"
                                                 data-max="5"></div>
                                        </div>
                                        <div class="col">
                                            <h5 class="theme-text-title text-end theme-primary-color">
                                                LKR <?= $book['price'] ?></h5>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <?php if (IS_LOGGED_IN && $USER['status']): ?>
                                            <button class="theme-btn theme-btn-dark-animated theme-font-bold"
                                                <?php if ($book['qty'] <= 0) echo "disabled"; ?>
                                                    onclick="addToCart(<?= $book['id'] ?>)">
                                                <i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;Add to Cart
                                            </button>
                                        <?php else: ?>
                                            <a class="theme-btn theme-btn-dark-animated theme-font-bold"
                                                <?php if ($book['qty'] <= 0) echo "disabled"; ?>
                                               href="<?= IS_LOGGED_IN ? 'verify.php' : 'login.php' ?>">
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
        <div class="row mt-2">
            <div class="col-sm-9 offset-sm-3">
                <hr>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if ($page == 1) echo 'disabled'; ?>">
                            <a class="page-link" href="<?= change_url_params('page', $page - 1) ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $num_pages; $i++): ?>
                            <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                                <a class="page-link" href="<?= change_url_params('page', $i) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php if ($page == $num_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="<?= change_url_params('page', $page + 1) ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
</main>
<script src="js/search.js"></script>

<?php require_once "footer.php" ?>

