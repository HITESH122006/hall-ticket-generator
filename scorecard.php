<?php
session_start();

if (!isset($_SESSION['roll'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Portal | Score Card</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #64748b;
        --success-color: #10b981;
        --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg-gradient);
        color: #1e293b;
        margin: 0;
        padding: 40px 20px;
        min-height: 100vh;
    }

    .container {
        max-width: 850px;
        margin: auto;
    }

    /* Header Section */
    .header-section {
        margin-bottom: 40px;
        text-align: center;
    }

    h2 {
        font-weight: 700;
        letter-spacing: -0.025em;
        color: #0f172a;
        font-size: 2rem;
        margin-bottom: 8px;
    }

    .subtitle {
        color: var(--secondary-color);
        font-size: 1.1rem;
    }

    /* Selection Box */
    .selector-wrapper {
        background: white;
        padding: 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        box-shadow: var(--card-shadow);
        margin-bottom: 30px;
    }

    select {
        padding: 12px 16px;
        width: 300px;
        font-size: 15px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #fff;
        outline: none;
        transition: border-color 0.2s ease;
        cursor: pointer;
    }

    select:focus {
        border-color: var(--primary-color);
        ring: 2px solid rgba(37, 99, 235, 0.2);
    }

    /* Result Card Styling */
    .card {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        display: none;
        animation: fadeIn 0.5s ease-out;
        border: 1px solid rgba(255, 255, 255, 0.7);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h3 {
        font-size: 1.25rem;
        margin-top: 0;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f5f9;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .info-group {
        display: flex;
        flex-direction: column;
    }

    .label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--secondary-color);
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .value {
        font-size: 1.1rem;
        font-weight: 500;
        color: #334155;
    }

    .cgpa-container {
        background: #eff6ff;
        padding: 15px;
        border-radius: 12px;
        border-left: 5px solid var(--primary-color);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .cgpa {
        font-size: 32px;
        color: var(--primary-color);
        font-weight: 800;
    }

    /* Button Styling */
    .download {
        margin-top: 40px;
        text-align: center;
    }

    button {
        padding: 14px 32px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        background: var(--primary-color);
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
    }

    button:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }

    button:active {
        transform: translateY(0);
    }

    /* Mobile responsiveness */
    @media (max-width: 600px) {
        .grid { grid-template-columns: 1fr; }
        select { width: 100%; }
        .card { padding: 25px; }
    }
</style>

<script>
function showScorecard() {
    const session = document.getElementById("session").value;
    const box = document.getElementById("scorecardBox");
    if (session) {
        box.style.display = "block";
    } else {
        box.style.display = "none";
    }
}
</script>

</head>
<body>

<div class="container">

    <div class="header-section">
        <h2>Academic Score Card</h2>
        <p class="subtitle">View and download your official performance reports</p>
    </div>
    
    <div class="selector-wrapper">
        <label for="session" class="label" style="margin:0">Session:</label>
        <select id="session" onchange="showScorecard()">
            <option value="">-- Choose Academic Session --</option>
            <option>Winter 2025</option>
            <option>Summer 2025</option>
            <option>Winter 2024</option>
        </select>
    </div>

    <div class="card" id="scorecardBox">
        <h3>Student Information</h3>

        <div class="grid">
            <div class="info-group">
                <span class="label">Full Name</span>
                <span class="value">HITESH BORASE</span>
            </div>
            <div class="info-group">
                <span class="label">Roll Number</span>
                <span class="value">A-50</span>
            </div>

            <div class="info-group">
                <span class="label">Branch</span>
                <span class="value">Information Technology</span>
            </div>
            <div class="info-group">
                <span class="label">Section</span>
                <span class="value">D</span>
            </div>

            <div class="info-group">
                <span class="label">Academic Year</span>
                <span class="value">2025–26</span>
            </div>
            
            <div class="cgpa-container">
                <span class="label">Cumulative GPA</span>
                <span class="cgpa">8.77</span>
            </div>
        </div>

        <div class="download">
            <a href="assets/marksheet_sample.pdf" target="_blank" style="text-decoration: none;">
                <button>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="浸4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Marksheet (PDF)
                </button>
            </a>
        </div>
    </div>

</div>

</body>
</html>
