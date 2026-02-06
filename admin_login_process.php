<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

/* Hardcoded admin (micro-project safe) */
if ($username === "admin" && $password === "admin123") {
    $_SESSION['admin'] = true;
    header("Location: admin_dashboard.php");
    exit;
} else {
    echo "<h3 style='color:red'>Invalid Admin Credentials</h3>";
    echo "<a href='admin_login.php'>Go Back</a>";
}
?>
