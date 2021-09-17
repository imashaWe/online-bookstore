<?php

$servername = "online-bookstore-db.mysql.database.azure.com";
$username = "dev@online-bookstore-db";
$password = "Debuggers@18";
$database = "online-bookstore";

// create database connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_errno) die("Database connection error:" . $conn->connect_error);