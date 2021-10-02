<?php
require 'core/db.php';
require "core/user.php";
require "lib/email.php";

$fname = "";
$lname = "";
$email = "";

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $is_remember = isset($_POST['is_remember']);
    if (empty($fname)) {
        $error = "Please enter your First Name";
    } elseif (empty($lname)) {
        $error = "Please enter your Last Name";

    } elseif (empty($email)) {
        $error = "Please enter your Email";

    } elseif (empty($password)) {
        $error = "Please enter valid Password";

    } elseif ($password != $password_confirm) {
        $error = "The password and confirmation password does not match";
    } else {
        $sql = "SELECT * FROM site_user WHERE email= '{$email}'";
        $res = $conn->query($sql);
        if ($res->num_rows) {
            $error = "This account already exist";
        } else {
            $password = md5($password);
            $last_login = date("Y:m:d H:i:s");
            $sql = "INSERT INTO 
                    site_user(fname,lname,email,password,status,last_login) 
                    VALUES ('{$fname}','{$lname}','{$email}','{$password}',0,'{$last_login}')";
            $res = $conn->query($sql);
            $uid = $conn->insert_id;
            if ($res) {
                $code = get_verify_code($conn, $uid);
                send_verify_code_email($email, "{$fname} {$lname}", $code);
                set_user($fname, $lname, $email, 0, $uid, $is_remember);
                header("location:index.php");
            } else {
                $error = "Database Error";
            }

        }
    }
}
function get_verify_code($conn, $uid)
{
    $code = "";
    for ($i = 0; $i < 6; $i++) $code .= rand(0, 9);
    $code = (int)$code;
    $sql = "SELECT * FROM site_user_verify WHERE code = {$code}";

    if ($conn->query($sql)->num_rows) {
        return get_verify_code($conn, $uid);
    }
    $sql = "INSERT INTO site_user_verify VALUES({$uid},{$code})";
    $conn->query($sql);
    return $code;
}

function send_verify_code_email($email, $name, $code)
{
    $template = file_get_contents('email-templates/user-verify.html');
    $template = str_replace("{CUSTOMER_NAME}", $name, $template);
    $template = str_replace("{CODE}", $code, $template);
    send_mail($email, "Verify your Email Address", $template, "Your verify code {$code}");
}

?>
<?php require_once 'header_auth.php' ?>

    <div class="p-5">

        <div class="text-center">
            <h2 class="text-dark mb-4 theme-text-heading">Create Account</h2>
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
            <div class="row pt-4 gy-4">
                <div class="col-md-6">
                    <input class="form-control form-control-user" type="text"
                           placeholder="First Name"
                           value="<?= $fname ?>"
                           name="fname">
                </div>
                <div class="col-md-6">
                    <input class="form-control form-control-user" type="text"
                           placeholder="Last Name"
                           value="<?= $lname ?>"
                           name="lname">
                </div>
            </div>

            <div class="row pt-4">
                <div class="col">
                    <input class="form-control form-control-user" type="email"
                           placeholder="Email"
                           value="<?= $email ?>"
                           name="email">
                </div>

            </div>

            <div class="row pt-4">
                <div class="col">
                    <input class="form-control form-control-user" type="password"
                           placeholder="Password"
                           name="password">
                </div>

            </div>

            <div class="row pt-4">
                <div class="col">
                    <input class="form-control form-control-user" type="password"
                           placeholder="Confirm Password"
                           name="password_confirm">
                </div>

            </div>

            <div class="row pt-4">
                <div class="col">
                    <div class="custom-control custom-checkbox small">
                        <div class="form-check">
                            <input class="form-check-input custom-control-input" type="checkbox"
                                   name="is_remember"
                                   value=0>
                            <label class="form-check-label custom-control-label">Remember Me</label>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-dark d-block btn-user w-100 my-4" type="submit" name="submit">Register</button>

            <div class="text-center">
                <p>Already have an account ?&nbsp;<a href="login.php">Log In</a></p>
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