<?php
session_start();
include 'db.php';

if (!isset($_SESSION['roll'])) {
    header("Location: index.php");
    exit;
}
$noticeQuery = "SELECT * FROM notices ORDER BY post_date DESC";
$noticeResult = mysqli_query($conn, $noticeQuery);

if (!$noticeResult) {
    die("Notice Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <h1>G.H. Raisoni College of Engineering & Management</h1>
    <p>Student Portal</p>
</div>
<div class="breadcrumb">
    Home / Student Portal / Dashboard
</div>

<!-- DASHBOARD CARDS -->
<div class="dashboard">
    <div class="card">
        <h3>📊 Attendance</h3>
        <p>View attendance details</p>
        <button disabled>Coming Soon</button>
    </div>

    <div class="card">
        <h3>💰 Finance</h3>
        <p>Fee & payment information</p>
        <button disabled>Coming Soon</button>
    </div>

    <div class="card">
        <h3>📝 Score Card</h3>
        <p>Check subject submissions</p>
        <a href="scorecard.php"><button>Open</button></a>
    </div>

    <div class="card">
        <h3>🎟 Hall Ticket</h3>
        <p>Check eligibility & download hall ticket</p>
        <a href="hallticket.php">
            <button>Check Status</button>
        </a>
    </div>
</div>

<!-- NOTICE BOARD (NOW BELOW ALL 4 CARDS) -->
  <div class="notice-section">
    <h2>📢 Notice Board</h2>

    <?php
    if (mysqli_num_rows($noticeResult) > 0) {

        while ($notice = mysqli_fetch_assoc($noticeResult)) {
    ?>

        <div class="notice-card">

            <!-- LEFT CIRCLE (PM / AP) -->
            <div class="notice-avatar">
                <?php
                echo strtoupper(substr($notice['posted_by'], 0, 2));
                ?>
            </div>

            <!-- NOTICE BODY -->
            <div class="notice-content">

                <h4><?php echo $notice['title']; ?></h4>

                <span class="date">
                    <?php echo date("d M Y", strtotime($notice['post_date'])); ?>
                </span>

                <p><?php echo $notice['message']; ?></p>

                <!-- ATTACHMENTS -->
                <?php if (!empty($notice['attachments'])) { ?>
                    <div class="attachments">
                        <?php
                        $files = explode(",", $notice['attachments']);

                        foreach ($files as $file) {
                            echo "<a class='pdf' href='uploads/$file' target='_blank'>📄 PDF</a>";
                        }
                        ?>
                    </div>
                <?php } ?>

                <div class="posted-by">
                    Posted by: <b><?php echo $notice['posted_by']; ?></b>
                </div>

            </div>
        </div>

    <?php
        }
    } else {
        echo "<p>No notices available.</p>";
    }
    ?>
</div>

</body>
</html>
