<?php
require_once '../core/db.php';

$sql = "SELECT COUNT(id) AS book_count FROM book WHERE is_delete = 0";
$book_count = $conn->query($sql)->fetch_array()['book_count'];

$sql = "SELECT COUNT(id) AS category_count FROM book_category WHERE is_delete = 0";
$category_count = $conn->query($sql)->fetch_array()['category_count'];

$sql = "SELECT COUNT(id) AS user_count FROM site_user";
$user_count = $conn->query($sql)->fetch_array()['user_count'];

$sql = "SELECT COUNT(id) AS order_count FROM `order` ";
$order_count = $conn->query($sql)->fetch_array()['order_count'];

$sql = "SELECT `order`.* ,
        (SELECT SUM(out_amount) FROM `payment` WHERE trans_code='PURCHASE' AND trans_id = `order`.id) AS price 
        FROM `order`
        ORDER BY `created_at` DESC
        LIMIT 10";
$last_orders = $conn->query($sql);


?>
<?php
require_once('header.php');
?>
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-header"><h5>TOTAL BOOKS</h5></div>
                        <div class="card-body">
                            <i class="fas fa-book-open fa-3x"></i>
                            <h2 class="float-end"><?= $book_count ?></h2>
                        </div>

                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-header"><h5>TOTAL CATEGORIES</h5></div>
                        <div class="card-body">
                            <i class="fas fa-list-alt fa-3x"></i>
                            <h2 class="float-end"><?= $category_count ?></h2>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-header"><h5>TOTAL USERS</h5></div>
                        <div class="card-body">
                            <i class="fas fa-user fa-3x"></i>
                            <h2 class="float-end"><?= $user_count ?></h2>
                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-header"><h5>TOTAL ORDERS</h5></div>
                        <div class="card-body">
                            <i class="fas fa-shopping-cart fa-3x"></i>
                            <h2 class="float-end"><?= $order_count ?></h2>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Daily Orders
                        </div>
                        <div class="card-body">
                            <canvas id="myAreaChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Monthly Orders
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Recent Orders
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>City</th>
                            <th>DATE/TIME</th>
                            <th class="text-end">AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $last_orders->fetch_array()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['city'] ?></td>
                                <td><?= $row['created_at'] ?></td>
                                <td class="text-end"><?= $row['price'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </main>
<?php
require_once('footer.php');
?>