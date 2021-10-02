<?php
require 'core/db.php';
require 'core/user.php';

if (isset($_POST['submit'])) {
    $code = $_POST['code'];
    $uid = $USER['uid'];
    $sql = "SELECT * FROM site_user_verify WHERE uid = {$uid} AND code = {$code}";
    $res = $conn->query($sql);
    if ($res->num_rows) {
        $sql = "UPDATE site_user SET status = 1 WHERE id = {$uid}";
        $res = $conn->query($sql);
        if ($res) {
            set_verify_user();
            header("location:index.php");
        } else {
            $error = "Database Error";
        }
    } else {
        $error = "Invalid code";
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
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="css/theme.css">
</head>
<body class="theme-bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <h5 class="text-center theme-text-heading py-2">Account Verification</h5>

                <form action="" method="post">
                    <div class="row justify-content-center">
                        <div class="col-8">
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
                            <input type="text"
                                   class="form-control"
                                   placeholder="Enter 6 Digit Verify Code"
                                   maxlength="6"
                                   name="code">
                            <button class="btn btn-dark d-block btn-user w-100 my-4" name="submit" type="submit">
                                VERIFY
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
