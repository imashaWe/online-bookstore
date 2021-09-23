<?php
require 'core/db.php';
require 'core/user.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_remember = isset($_POST['is_remember']);

    if (empty($email)) {
        $error = "Please enter the Email";
    } elseif (empty($email)) {
        $error = "Please enter the password";
    } else {
        $password = md5($password);
        $sql = "SELECT * FROM site_user
                WHERE email = '{$email}' AND password ='{$password}'";
        $res = $conn->query($sql);
        if ($res->num_rows) {
            $user = $res->fetch_array();
            set_user($user['fname'], $user['lname'], $user['email'], $user['status'], $user['id'], $is_remember);
            header("location:index.php");
        } else {
            $error = "Invalid login details";
        }
    }

}
?>
<?php require_once 'header_auth.php' ?>

    <div class="p-5">

        <div class="text-center">
            <h2 class="text-dark mb-4 theme-text-heading">Log into Account</h2>
        </div>

        <form class="user" method="post" action="">
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
            <div class="row pt-4">
                <div class="col">
                    <input class="form-control form-control-user" type="email"
                           placeholder="Email"
                           name="email">
                </div>
            </div>

            <div class="row pt-4">
                <div class="col">
                    <input class="form-control form-control-user" type="password"
                           placeholder="Password"
                           name="password">
                    <!--                   <div class="text-end"><a href="register.php">Forgot Password</a></p></div>-->
                </div>
            </div>

            <div class="row pt-4">
                <div class="col">
                    <div class="custom-control custom-checkbox small">
                        <div class="form-check">
                            <input class="form-check-input custom-control-input" type="checkbox"
                                   name="is_remember">
                            <label class="form-check-label custom-control-label">Remember Me</label>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-dark d-block btn-user w-100 my-4" type="submit" name="submit">
                Log In
            </button>

            <div class="text-center">
                <p>Didn't have an account ?&nbsp;<a href="register.php">Register</a></p>
            </div>

        </form>
        <hr>
        <div class="text-center">
            <small>
                <a href="" class="link-secondary">Privacy Policy</a>
                &nbsp;and&nbsp;
                <a href="" class="link-secondary">Terms and Services</a>
            </small>
        </div>
    </div>

<?php require_once 'footer_auth.php' ?>