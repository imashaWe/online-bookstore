<?php
require("db.php");

$error;

$sql = "SELECT * FROM system_user_role";
$user_roles = $conn->query($sql);

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];
    $password = $_POST['password'];

    if (empty($fname)) {
        $error = "Please enter First Name";
    } elseif (empty($lname)) {
        $error = "Please enter Last Name";

    } elseif (empty($email)) {
        $error = "Please enter email";

    } elseif (empty($password)) {
        $error = "Please enter password";

    } else {
        $password = md5($password);
        $sql = "INSERT INTO system_user(fname,lname,email,password,role_id) 
                VALUES('{$fname}','{$lname}','{$email}','{$password}',{$role_id})";
        $res = $conn->query($sql);
        if ($res) {
            header("location:system-users.php");
            die();
        } else {
            $error = "Database error";
        }

    }
}


?>
<?php require_once('header.php'); ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Users</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">System Users</li>
            <li class="breadcrumb-item active">Add New User</li>
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
                                    <label class="form-label">Password</label>
                                    <input type="text" class="form-control" name="password">
                                </div>
                                <div class="col">
                                    <label class="form-label">User Role</label>
                                    <select class="form-select" name="role_id">
                                        <?php while ($role = $user_roles->fetch_array()): ?>
                                            <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success float-end" name="submit">Save User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
<?php require_once('footer.php'); ?>
