
<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

/* ================= ADD STUDENT LOGIC ================= */
if (isset($_POST['add_student'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $roll = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Insert into students table
    $insertStudent = "INSERT INTO students (name, roll_no, password)
                      VALUES ('$name', '$roll', '$pass')";

    if (mysqli_query($conn, $insertStudent)) {

        $student_id = mysqli_insert_id($conn);

        // Insert default submission records for all subjects
        $subjectQuery = "SELECT subject_id FROM subjects";
        $subjects = mysqli_query($conn, $subjectQuery);

        while ($subj = mysqli_fetch_assoc($subjects)) {
            $sid = $subj['subject_id'];

            mysqli_query($conn,
                "INSERT INTO submissions (student_id, subject_id, status)
                 VALUES ($student_id, $sid, 'Not Submitted')");
        }

        echo "<script>alert('Student added successfully'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error adding student');</script>";
    }
}

$query = "
SELECT 
    s.name,
    s.roll_no,
    subj.subject_name,
    sub.status,
    sub.student_id,
    sub.subject_id
FROM submissions sub
JOIN students s ON s.student_id = sub.student_id
JOIN subjects subj ON subj.subject_id = sub.subject_id
ORDER BY s.roll_no
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel | G.H. Raisoni College</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f4f6f9;
}

/* HEADER */
.header {
    background: linear-gradient(90deg, #002147, #004aad);
    color: white;
    padding: 20px;
    text-align: center;
}

.header h2 {
    margin: 0;
}

.header p {
    margin: 5px 0 0;
    font-size: 14px;
    opacity: 0.9;
}

/* CONTAINER */
.container {
    padding: 30px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-radius: 10px;
    overflow: hidden;
}

th {
    background: #004aad;
    color: white;
    padding: 14px;
    text-align: left;
}

td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f1f7ff;
}

/* STATUS BADGES */
.status-submitted {
    color: green;
    font-weight: bold;
}

.status-pending {
    color: red;
    font-weight: bold;
}

/* BUTTONS */
button {
    padding: 8px 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.btn-submit {
    background: #28a745;
    color: white;
}

.btn-submit:hover {
    background: #218838;
}

.done {
    color: green;
    font-weight: bold;
}

/* FOOTER */
.footer {
    margin-top: 30px;
    text-align: right;
}

.logout {
    text-decoration: none;
    color: white;
    background: #dc3545;
    padding: 10px 16px;
    border-radius: 6px;
}

.logout:hover {
    background: #b52a37;
}
</style>

</head>
<body>

<div class="header">
    <h2>Admin Panel – Submission Control</h2>
    <p>G.H. Raisoni College of Engineering & Management</p>
</div>

<div class="container">
<!-- ADD STUDENT BUTTON -->
<div style="margin-bottom:20px; text-align:right;">
    <button onclick="document.getElementById('addStudentBox').style.display='block'"
        style="background:#004aad;color:white;padding:10px 18px;border:none;border-radius:6px;">
        ➕ Add Student
    </button>
<!-- ADD STUDENT FORM -->
<div id="addStudentBox" style="display:none; background:#fff; padding:25px; border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2); max-width:500px; margin:20px auto;">

    <h3 style="margin-top:0;color:#004aad;">Add New Student</h3>

    <form method="POST">
        <input type="hidden" name="add_student" value="1">

        <input type="text" name="name" placeholder="Student Name" required
            style="width:100%;padding:10px;margin-bottom:10px">

        <input type="text" name="roll_no" placeholder="Roll Number" required
            style="width:100%;padding:10px;margin-bottom:10px">

        <input type="text" name="password" placeholder="Password" required
            style="width:100%;padding:10px;margin-bottom:15px">

        <button type="submit" class="btn-submit">Save Student</button>

        <button type="button"
            onclick="document.getElementById('addStudentBox').style.display='none'"
            style="margin-left:10px;background:#ccc;padding:8px 14px;border:none;border-radius:6px;">
            Cancel
        </button>
    </form>
</div>

</div>

<table>
<tr>
    <th>Student Name</th>
    <th>Roll No</th>
    <th>Subject</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
/* Organize data by student */
$students = [];

while ($row = mysqli_fetch_assoc($result)) {
    $key = $row['roll_no'];
    $students[$key]['name'] = $row['name'];
    $students[$key]['roll_no'] = $row['roll_no'];
    $students[$key]['records'][] = $row;
}

/* Display grouped table */
foreach ($students as $student) {
    $rowspan = count($student['records']);
    $first = true;

    foreach ($student['records'] as $record) {
        echo "<tr>";

        if ($first) {
            echo "<td rowspan='{$rowspan}'>{$student['name']}</td>";
            echo "<td rowspan='{$rowspan}'>{$student['roll_no']}</td>";
            $first = false;
        }

        echo "<td>{$record['subject_name']}</td>";

        if ($record['status'] == 'Submitted') {
            echo "<td class='status-submitted'>✔ Submitted</td>";
            echo "<td class='done'>✔ Done</td>";
        } else {
            echo "<td class='status-pending'>✖ Not Submitted</td>";
            echo "<td>
                <a href='update_status.php?sid={$record['student_id']}&subid={$record['subject_id']}'
                   onclick=\"return confirm('Mark this subject as Submitted?');\">
                    <button class='btn-submit'>Mark as Submitted</button>
                </a>
            </td>";
        }

        echo "</tr>";
    }
}
?>
</table>

<div class="footer">
    <a href="admin_logout.php" class="logout">Logout</a>
</div>

</div>

</body>
</html>
