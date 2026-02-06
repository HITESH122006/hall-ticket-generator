<?php
include 'db.php';

/* ================== INPUT VALIDATION ================== */
if (!isset($_POST['roll']) || empty($_POST['roll'])) {
    echo "<h3 style='color:red;'>❗ Please enter Roll Number first.</h3>";
    exit;
}

$roll = mysqli_real_escape_string($conn, $_POST['roll']);

/* ================== FETCH SUBJECT + STATUS ================== */
$query = "
SELECT 
    subj.subject_name,
    sub.status
FROM students s
JOIN submissions sub ON s.student_id = sub.student_id
JOIN subjects subj ON sub.subject_id = subj.subject_id
WHERE s.roll_no = '$roll'
";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<h3 style='color:red;'>❌ Invalid Roll Number</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hall Ticket Status</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            padding: 30px;
        }
        .card {
            background: #fff;
            padding: 25px;
            width: 450px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background: #333;
            color: white;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        button {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

<div class="card">
    <h2 style="text-align:center;">📄 Subject Submission Status</h2>

    <table border="1">
        <tr>
            <th>Subject</th>
            <th>Status</th>
        </tr>

        <?php
        $blocked = false;

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['subject_name']}</td>";

            if ($row['status'] === 'Submitted') {
                echo "<td class='success'>Submitted ✔</td>";
            } else {
                echo "<td class='error'>Not Submitted ❌</td>";
                $blocked = true;
            }

            echo "</tr>";
        }
        ?>
    </table>

    <br>

    <?php if ($blocked): ?>
        <h3 class="error">❌ Submission Pending</h3>
        <p><b>Hall Ticket Status:</b> Blocked</p>
    <?php else: ?>
        <h3 class="success">✅ All Subjects Submitted</h3>
        <a href="hallticket.php?roll=<?php echo $roll; ?>">
            <button>Download Hall Ticket</button>
        </a>
    <?php endif; ?>

</div>

</body>
</html>
