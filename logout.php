<?php
session_start();
unset($_SESSION['site_user']);
header("location:index.php");