<?php
session_start();

if (!isset($_SESSION['sys_user'])) {
    header("location:login.php");
    die();
}
