<?php
require "db.php";
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $error = "Please enter the Email";
    } elseif (empty($email)) {
        $error = "Please enter the password";
    } else {
        $password = md5($password);
        $sql = "SELECT system_user.id,role_id,fname,lname,name AS role FROM system_user 
                INNER JOIN system_user_role ON system_user_role.id = system_user.role_id
                WHERE email = '{$email}' AND password ='{$password}' AND is_delete = 0";

        $res = $conn->query($sql);
        if ($res->num_rows) {
            $user = $res->fetch_array();
            session_start();
            $_SESSION['user'] = array(
                    'id'=> $user['id'],
                    'role_id'=> $user['role_id'],
                    'role'=> $user['role'],
                    'fname'=> $user['fname'],
                    'lname'=> $user['lname'],
            );
            header("location:index.php");
        } else {
            $error = "Invalid login details";
        }
    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | Online BookStore</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet"/>
    <link href="css/styles.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
            crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
<div class="container">
    <div class="row justify-content-center" style="padding-top: 5%">
        <div class="col-4 pt-5">
            <div class="card">

                <div class="text-center">
                    <i class="fas fa-user fa-4x"></i></span>
                </div>
                <h4 class="text-center mt-2">Login To Admin Panel</h4>
                <div class="card-body">
                    <form action="" method="post">
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
                        <label class="form-label">Email:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                            <input type="text" class="form-control" aria-label="Username"
                                   aria-describedby="basic-addon1" name="email">
                        </div>

                        <label class="form-label">Password:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" aria-label="Username"
                                   aria-describedby="basic-addon1" name="password">
                        </div>
                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-success" name="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
