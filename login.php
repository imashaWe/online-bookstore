<?php
if (isset($_POST['submit'])) {
    // to implement login
}
?>
<?php require_once 'header_auth.php' ?>

    <div class="p-5">

        <div class="text-center">
            <h2 class="text-dark mb-4 theme-text-heading">Log into Account</h2>
        </div>

        <form class="user" method="post" action="">

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