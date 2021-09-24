<?php
require 'config.php';
$db = $_CONFIG['database'];

// create database connection
$conn = new mysqli($db['servername'], $db['username'], $db['password'], $db['database']);
if ($conn->connect_errno) die("Database connection error:" . $conn->connect_error);