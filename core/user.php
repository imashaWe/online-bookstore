<?php
session_start();
$USER = null;
if (isset($_COOKIE['site_user'])) {
    $user = json_decode($_COOKIE['site_user']);
    $_SESSION['site_user'] = array(
        'uid' => $user->uid,
        'fname' => $user->fname,
        'lname' => $user->lname,
        'email' =>$user->email,
        'status' => $user->status
    );
}
if (isset($_SESSION['site_user'])) $USER = $_SESSION['site_user'];
$IS_LOGGED_IN = $USER != null;

function set_user($fanme, $lname, $email, $status, $uid, $is_remember)
{
    $user = array(
        'uid' => $uid,
        'fname' => $fanme,
        'lname' => $lname,
        'email' => $email,
        'status' => $status
    );
    if ($is_remember) {
        setcookie('site_user', json_encode($user), time() + (86400 * 30), "/");
    } else {
        $_SESSION['site_user'] = $user;
    }

}

function set_verify_user()
{
    if (isset($_SESSION['site_user'])) {
        $user = $_SESSION['site_user'];
        $user['status'] = 1;
        $_SESSION['site_user'] = $user;
    }
    if (isset($_COOKIE['site_user'])) {
        $user = json_decode($_COOKIE['site_user']);
        $user->status = 1;
        setcookie('site_user', json_encode($user), time() + (86400 * 30), "/");
    }

}



