<?php
require "db.php";
if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    if (empty($fname)) {
        $error = "Please enter a valid first name";
    } elseif (empty($lname)) {
        $error = "Please enter  a valid last name";
    }  elseif (empty($email)) {
        $error = "Please enter  a valid email address";
    } elseif (empty($phone)) {
        $error = "Please enter  a valid phone number";
    } else {

        $sql = "INSERT INTO book_author(fname,lname,email,phone) VALUES ('{$fname}','{$lname}','{$email}','{$phone}')";
        $res = $conn->query($sql);
        echo $sql;
        if ($res) {
            echo "Success";
        } else {
            echo "Database Error";
        }

    }
}
?>
<?php require_once('header.php'); ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Add New Author</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">System Users</li>
            <li class="breadcrumb-item active">Add New Author</li>
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
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="fname">
                                </div>
                                <div class="col">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lname">
                                </div>
                                <div class="col">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="col">
                                    <label class="form-label">Telephone Number</label>
                                    <input type="number" class="form-control" name="phone">
                                </div>

                            </div>
                            <br>
                            <button type="submit" class="btn btn-success float-end" name="submit">Save Author</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
<?php require_once('footer.php'); ?>
