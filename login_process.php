
<?php
session_start();
include 'db.php';

if (!isset($_POST['roll']) || !isset($_POST['password'])) {
    header("Location: index.php");
    exit;
}

$roll = $_POST['roll'];
$password = $_POST['password'];

/* Check student credentials */
$query = "SELECT * FROM students WHERE roll_no='$roll'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {

    // ✅ LOGIN SUCCESS
    $_SESSION['roll'] = $roll;

    header("Location: dashboard.php");
    exit;

} else {
    echo "<h3 style='color:red'>❌ Invalid Roll Number or Password</h3>";
    echo "<a href='index.php'>Go Back</a>";
}
?>
