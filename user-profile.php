<?php
require_once 'core/db.php';
require_once 'core/user.php';

login_access_protect();

$has_error = 1;

$uid = $USER['uid'];

$fname = "";
$lname = "";
$email = "";

$sql = "SELECT * FROM site_user WHERE id ={$uid}";
$res = $conn->query($sql);

if ($res->num_rows) {
    $row = $res->fetch_array();
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
}
if (isset($_POST['submit_user_details'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];


    if (empty($fname)) {
        $msg = "The First Name can't be empty.";
    } elseif (empty($lname)) {
        $msg = "The Last Name can't be empty.";
    } elseif (empty($email)) {
        $msg = "The email can't be empty.";
    } else {
        $sql = "UPDATE site_user SET 
                     fname = '{$fname}',
                     lname = '{$lname}',
                     email = '{$email}'
                WHERE id = {$uid}";
        $res = $conn->query($sql);

        if ($res) {
            $msg = "Your details has been updated";
            $has_error = 0;
        } else {
            $msg = "Database error";
        }
    }
}


$city = "";
$address_line1 = "";
$address_line2 = "";
$post_code = "";
$has_address_details = 0;

$sql = "SELECT * FROM site_user_address WHERE uid ={$uid}";
$res = $conn->query($sql);
if ($res->num_rows) {
    $has_address_details = 1;
    $row = $res->fetch_array();
    $city = $row['city'];
    $address_line1 = $row['address_line1'];
    $address_line2 = $row['address_line2'];
    $post_code = $row['post_code'];
}
if (isset($_POST['submit_address_details'])) {
    $city = $_POST['city'];
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $post_code = $_POST['post_code'];


    if (empty($city)) {
        $msg = "The City can't be empty.";
    } elseif (empty($address_line1)) {
        $msg = "The Address Line 1 Name can't be empty.";
    } elseif (empty($address_line2)) {
        $msg = "The Address Line 2 be empty.";
    } elseif (empty($post_code)) {
        $msg = "The Post Code can't be empty.";
    } else {

        if ($has_address_details) {
            $sql = "UPDATE site_user_address SET 
                     city = '{$city}',
                     address_line1 = '{$address_line1}',
                     address_line1 = '{$address_line2}',
                     post_code = '{$post_code}'
                WHERE uid = {$uid}";
        } else {
            $sql = "INSERT INTO site_user_address VALUES ({$uid},'{$city}','{$address_line1}','{$address_line2}',{$post_code});";
        }

        $res = $conn->query($sql);

        if ($res) {
            $msg = "Your address details has been updated";
            $has_error = 0;
        } else {
            $msg = "Database error";
        }

    }
}
?>
<?php require_once('header.php'); ?>
    <div class="container-fluid" style="background-image: url('assets/images/auth-cover.jpg')">
        <h1 class="theme-text-heading text-light text-center pt-5">PROFILE</h1>
        <div class="col-lg-4">
            <div class="card-body text-center shadow" style="text-align: center">
                <img class="rounded-circle mb-3 mt-4" style="text-align: center" src="assets/images/profile.png"
                     width="160" height="160">
                <div class="mb-3">
                    <button class="btn btn-info btn-sm" type="button">Change Photo</button>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="container">
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 ">User Details</p>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_POST['submit_user_details']) && isset($msg)): ?>

                            <?php if ($has_error): ?>
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                         aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    <div>
                                        <?= $msg ?>
                                    </div>
                                </div>
                            <?php else: ?>

                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                         aria-label="Success:">
                                        <use xlink:href="#check-circle-fill"/>
                                    </svg>
                                    <div>
                                        <?= $msg ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="first_name">
                                            <strong>First Name</strong>
                                        </label>
                                        <input class="form-control"
                                               type="text"
                                               placeholder="name 1"
                                               value="<?= $fname ?>"
                                               name="fname">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="last_name">
                                            <strong>Last Name</strong>
                                        </label>
                                        <input class="form-control" type="text"
                                               placeholder="name 2"
                                               value="<?= $lname ?>"
                                               name="lname">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="email">
                                            <strong>Email Address</strong>
                                        </label>
                                        <input class="form-control"
                                               type="email" id="email"
                                               placeholder="user@gmail.com"
                                               value="<?= $email ?>"
                                               name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2" style="text-align: center">
                                <button class="theme-btn theme-btn-primary-animated theme-text-title"
                                        type="submit"
                                        name="submit_user_details">
                                    Save&nbsp;Settings
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">

            <div class="col-10">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 fw-bold">Address Details</p>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_POST['submit_address_details']) && isset($msg)): ?>

                            <?php if ($has_error): ?>
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                         aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill"/>
                                    </svg>
                                    <div>
                                        <?= $msg ?>
                                    </div>
                                </div>
                            <?php else: ?>

                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                         aria-label="Success:">
                                        <use xlink:href="#check-circle-fill"/>
                                    </svg>
                                    <div>
                                        <?= $msg ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="city">
                                            <strong>Address Line 1</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Address Line 1"
                                               placeholder="Lane 1"
                                               value="<?= $address_line1 ?>"
                                               name="address_line1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="country">
                                            <strong>Address Line 2</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Address Line 2"
                                               placeholder="Lane 2"
                                               value="<?= $address_line2 ?>"
                                               name="address_line2">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="city">
                                            <strong>Town/City</strong>
                                        </label>
                                        <input class="form-control" type="text" id="town/city"
                                               placeholder="Colombo"
                                               value="<?= $city ?>"
                                               name="city">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="country">
                                            <strong>Postcode/Zip</strong>
                                        </label>
                                        <input class="form-control" type="text" id="Postcode/Zip"
                                               placeholder="00001"
                                               value="<?= $post_code ?>"
                                               name="post_code">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-2" style="text-align: center">
                                <button class="theme-btn theme-btn-primary-animated theme-text-title"
                                        type="submit"
                                        name="submit_address_details">
                                    Save&nbsp;Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>


<?php require_once('footer.php'); ?>