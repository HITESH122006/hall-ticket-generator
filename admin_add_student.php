<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student | Admin</title>
    <style>
        body {
            font-family: Segoe UI, Arial;
            background: #f4f6f9;
            padding: 40px;
        }
        .box {
            width: 420px;
            background: white;
            padding: 30px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        input {
            width: 95%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #003973;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>Add New Student</h2>

    <form method="POST">
        <input type="text" name="name" placeholder="Student Name" required>
        <input type="text" name="roll_no" placeholder="Roll Number" required>
        <input type="text" name="password" placeholder="Password" required>
        <button type="submit">Add Student</button>
    </form>
</div>

</body>
</html>
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $roll = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $check = mysqli_query($conn, "SELECT * FROM students WHERE roll_no='$roll'");

    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Roll Number already exists');</script>";
    } else {
        mysqli_query($conn,
            "INSERT INTO students (name, roll_no, password)
             VALUES ('$name', '$roll', '$pass')"
        );

        echo "<script>alert('Student Added Successfully');</script>";
    }
}
