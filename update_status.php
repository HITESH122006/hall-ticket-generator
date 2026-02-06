<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$student_id = $_GET['sid'];
$subject_id = $_GET['subid'];

$query = "
UPDATE submissions 
SET status = 'Submitted' 
WHERE student_id = '$student_id' 
AND subject_id = '$subject_id'
";

mysqli_query($conn, $query);

header("Location: admin_dashboard.php");
exit;
?>
