<?php
$servername = "online-bookstore.cruc6jn2s3ym.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "admin123";
$database = "online-bookstore";
// create database connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_errno) die("Database connection error:" . $conn->connect_error);