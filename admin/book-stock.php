<?php
require "../core/db.php";
/* To pagination */
$sql = "SELECT count(id) AS count  FROM book WHERE is_delete = 0";
$num_rows = $conn->query($sql)->fetch_array()['count'];
$limit = 5;
$num_pages = ceil($num_rows / $limit);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT book.isbn,book.name,
        IFNULL((SELECT (SUM(in_qty) -SUM(out_qty)) FROM book_stock WHERE book_id = book.id),0) AS qty
        FROM book 
        WHERE is_delete = 0
        LIMIT {$start},{$limit}";
$books = $conn->query($sql);


?>
<?php require_once('header.php'); ?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Book Stock</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Book Stock</li>
            </ol>
            <div class="d-grid  justify-content-end pb-2">
                <a href="book-stock-add.php" class="btn btn-dark">Add Stock</a>
            </div>
            <div class="card">

                <div class="card-body table-wrap">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>ISBN</th>
                            <th>Status</th>
                            <th class="text-end">Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                               <?php while ($row = $books->fetch_array()):?>
                                <tr>
                                    <td><?=$row['name']?></td>
                                    <td><?=$row['isbn']?></td>
                                    <td>
                                        <?=$row['qty'] > 0?
                                            '<h5><span class="badge bg-success">IN STOCK</span></h5>':
                                            '<h5><span class="badge bg-danger">OUT OF STOCK</span></h5>'
                                        ?>
                                    </td>
                                    <td class="text-end"><?=$row['qty']?></td>
                                </tr>
                                <?php endwhile;?>
                        </tbody>
                    </table>

                </div>
                <div class="card-footer">
                    <nav>
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

<?php require_once('footer.php'); ?>