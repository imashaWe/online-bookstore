<?php
require "../core/db.php";
$code = "";
$discount = "";
$from = "";
$to = "";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM coupon_code WHERE id = {$id}";
    $row = $conn->query($sql)->fetch_array();
    $code = $row['code'];
    $discount = $row['discount'];
    $from = $row['from'];
    $to = $row['to'];
}
if (isset($_POST['submit'])) {
    $code = $_POST['code'];
    $discount = $_POST['discount'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    if (empty($code)) {
        $error = "Please enter a coupon code";
    } elseif (empty($discount)) {
        $error = "Please enter  a valid discount";
    } elseif (empty($from)) {
        $error = "Please enter  a starting date";
    } elseif (empty($to)) {
        $error = "Please enter  a ending date";
    } else {
        if (isset($_POST['id'])) {
            $sql = "UPDATE coupon_code 
                    SET code = '{$code}', discount = '{$discount}', from = '{$from}', to = '{$to}' 
                    WHERE id = {$id}";
        } else {
            $sql = "INSERT INTO coupon_code(code, discount, from, to) 
                    VALUES ('{$code}','{$discount}','{$from}','{$to}')";
        }
        $res = $conn->query($sql);
        if ($res) {
            header("location:coupon-code.php");
        } else {
            $error = "Database Error";
        }

    }
}
?>
<?php require_once('header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= isset($_GET['id']) ? 'Edit' : 'Add New' ?> Coupon Code</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">Basic Data</li>
        <li class="breadcrumb-item">Coupon Code</li>
        <li class="breadcrumb-item active"><?= isset($_GET['id']) ? 'Edit' : 'Add New' ?> Code</li>
    </ol>
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                 class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"
                                 role="img" aria-label="Warning:">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            <div>
                                <?= $error ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="row row-cols-2 g-3">
                            <div class="col">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" name="code" value="<?= $code ?>">
                            </div>
                            <div class="col">
                                <label class="form-label">Discount</label>
                                <input type="text" class="form-control" name="discount" value="<?= $discount ?>">
                            </div>
                            <div class="col">
                                <label class="form-label">From</label>
                                <input type="text" class="form-control" name="from" value="<?= $from ?>">
                            </div>
                            <div class="col">
                                <label class="form-label">To</label>
                                <input type="text" class="form-control" name="to" value="<?= $to ?>">
                            </div>

                        </div>
                        <br>
                        <?php if (isset($_GET['id'])): ?>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        <?php endif; ?>
                        <div class="row justify-content-end pb-2">
                            <div class="col-1">
                                <a href="coupon_code.php" class="btn btn-outline-secondary btn-lg float-end"
                                   name="submit">Cancel</a>
                            </div>
                            <div class="col-1">
                                <button type="submit" class="btn btn-success btn-lg" name="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
</main>
<?php require_once('footer.php'); ?>
