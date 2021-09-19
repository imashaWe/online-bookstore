<?php
session_start();
unset($_SESSION['sys_user']);
header("location:login.php");