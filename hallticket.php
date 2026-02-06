<?php
session_start();
include 'db.php';

/* 🔐 Session protection */
if (!isset($_SESSION['roll'])) {
    header("Location: index.php");
    exit;
}

$roll = $_SESSION['roll'];

/* Fetch student details */
$studentQuery = "SELECT * FROM students WHERE roll_no='$roll'";
$studentResult = mysqli_query($conn, $studentQuery);
$student = mysqli_fetch_assoc($studentResult);

/* Fetch subject submission status (READ ONLY) */
$subQuery = "
SELECT subj.subject_name, sub.status
FROM submissions sub
JOIN subjects subj ON sub.subject_id = subj.subject_id
WHERE sub.student_id = '{$student['student_id']}'
";

$subResult = mysqli_query($conn, $subQuery);

$blocked = false;
$subjects = [];

while ($row = mysqli_fetch_assoc($subResult)) {
    $subjects[] = $row;
    if ($row['status'] != 'Submitted') {
        $blocked = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Hall Ticket</title>

<style>
body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f2f2f2;
    padding: 30px;
}

.ticket {
    background: white;
    max-width: 750px;
    margin: auto;
    padding: 30px;
    border: 2px solid #000;
}

.header {
    text-align: center;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
}

.header h2 {
    margin: 0;
}

.details {
    margin-top: 20px;
}

.details p {
    font-size: 16px;
    margin: 8px 0;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px;
}

th {
    background: #f0f0f0;
}

.submitted {
    color: green;
    font-weight: bold;
}

.pending {
    color: red;
    font-weight: bold;
}

.footer {
    margin-top: 40px;
    display: flex;
    justify-content: space-between;
}

.print-btn {
    text-align: center;
    margin-top: 30px;
}

button {
    padding: 10px 20px;
    font-size: 15px;
    cursor: pointer;
}

.blocked-msg {
    background: #ffe6e6;
    color: #b30000;
    padding: 15px;
    margin-top: 20px;
    border: 1px solid #b30000;
    text-align: center;
    font-weight: bold;
}

@media print {
    .print-btn { display: none; }
    body { background: white; }
}
</style>
</head>

<body>

<div class="ticket">

    <div class="header">
        <h2>G.H. Raisoni College of Engineering & Management</h2>
        <p><b>Hall Ticket – Semester Examination</b></p>
    </div>

    <div class="details">
        <p><b>Name:</b> <?= $student['name']; ?></p>
        <p><b>Roll Number:</b> <?= $student['roll_no']; ?></p>
        <p><b>Examination:</b> Semester Examination</p>
    </div>

    <!-- READ-ONLY SUBJECT STATUS -->
    <h3>Submission Status (Read Only)</h3>
    <table>
        <tr>
            <th>Subject</th>
            <th>Status</th>
        </tr>

        <?php foreach ($subjects as $s) { ?>
        <tr>
            <td><?= $s['subject_name']; ?></td>
            <td class="<?= $s['status']=='Submitted' ? 'submitted' : 'pending'; ?>">
                <?= $s['status']; ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <?php if ($blocked) { ?>
        <div class="blocked-msg">
            ❌ Hall Ticket Blocked – Submission Pending
        </div>
    <?php } else { ?>
        <p style="margin-top:20px">
            <b>Status:</b> <span style="color:green"><b>Eligible</b></span>
        </p>

        <div class="footer">
            <p>Student Signature</p>
            <p>Controller of Examination</p>
        </div>
    <?php } ?>

</div>

<?php if (!$blocked) { ?>
<div class="print-btn">
    <button onclick="window.print()">🖨️ Print / Save as PDF</button>
</div>
<?php } ?>

</body>
</html>

