<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "online-bookstore";

// create database connection
$conn = new mysqli($servername, $username, $password, $database);

// check database connection's errors
if ($conn->connect_errno) die("Database connection error:" . $conn->connect_error);