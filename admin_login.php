
<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login | GHRCE&M</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            background:
                linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                url("assets/images/bg.jpg") center/cover no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .admin-wrapper {
            width: 420px;
            background: rgba(255,255,255,0.95);
            border-radius: 16px;
            padding: 35px 40px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.45);
            animation: slideUp 0.9s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* HEADER */
        .admin-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .admin-header img {
            height: 70px;
            margin-bottom: 12px;
        }

        .admin-header h2 {
            margin: 0;
            font-size: 24px;
            color: #003973;
            letter-spacing: 0.5px;
        }

        .admin-header span {
            font-size: 13px;
            color: #666;
            letter-spacing: 1px;
            font-weight: bold;
        }

        .divider {
            height: 2px;
            background: #eee;
            margin: 22px 0;
        }

        /* INPUT FIELDS */
        .field {
            margin-bottom: 22px;
        }

        .field input {
            width: 92%;
            padding: 13px;
            border-radius: 6px;
            border: none;
            background: #f4f6f9;
            font-size: 15px;
            outline: none;
            border-bottom: 2px solid #ccc;
        }

        .field input:focus {
            background: #ffffff;
            border-bottom: 2px solid #003973;
        }

        /* BUTTON */
        .login-btn {
            width: 97%;
            padding: 14px;
            border: none;
            border-radius: 30px;
            background: linear-gradient(to right, #003973, #005bb5);
            font-size: 17px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: linear-gradient(to right, #00264d, #004a99);
        }

        /* FOOTER */
        .footer-text {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 25px;
        }
    </style>
</head>

<body>

<div class="admin-wrapper">

    <div class="admin-header">
        <img src="assets/images/logo.png" alt="College Logo">
        <h2>ADMIN PORTAL</h2>
        <span>G.H. Raisoni College of Engineering & Management</span>
    </div>

    <div class="divider"></div>

    <form action="admin_login_process.php" method="POST">

        <div class="field">
            <input type="text" name="username" placeholder="Admin Username" required>
        </div>

        <div class="field">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button class="login-btn">Secure Login</button>
    </form>

    <div class="footer-text">
        Authorized Personnel Only
    </div>

</div>

</body>
</html>
