<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "your_database_name";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed");
}
?>