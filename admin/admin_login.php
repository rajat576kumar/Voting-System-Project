<?php
include('../db.php'); // Database connection
session_start();

if(isset($_POST['login'])) {
    // SQL Injection se bachne ke liye real_escape_string use karein
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Login Check - Prepared Statement use karna better hota hai, lekin abhi simple fix kiya hai
    $query = "SELECT * FROM admin WHERE username='$user' AND password='$pass'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $_SESSION['admin'] = $user;
        echo "<script>alert('Welcome Back, Admin!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Galat Username ya Password!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Premium Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            /* Moving Gradient Background */
            background: linear-gradient(-45deg, #0f2027, #203a43, #2c5364);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Back Button - Floating Style */
        .back-nav {
            position: absolute;
            top: 30px;
            left: 30px;
        }
        .back-btn {
            color: white;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            transition: 0.3s;
            font-size: 14px;
        }
        .back-btn:hover { background: #fff; color: #0f2027; transform: translateX(-5px); }

        /* Login Card - Glassmorphism Effect */
        .login-box {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px 40px;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
            color: white;
        }

        .login-box h2 {
            font-weight: 600;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Modern Input Styling */
        .input-group {
            position: relative;
            margin-bottom: 30px;
        }
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #00d2ff;
        }
        .input-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            outline: none;
            color: white;
            transition: 0.4s;
        }
        .input-group input:focus {
            border-color: #00d2ff;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.3);
        }

        /* Neon Glow Button */
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(to right, #00d2ff, #3a7bd5);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.4s;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(0, 210, 255, 0.4);
        }
        button:hover {
            letter-spacing: 1px;
            box-shadow: 0 6px 25px rgba(0, 210, 255, 0.6);
            transform: translateY(-3px);
        }

        .footer-text {
            margin-top: 25px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>

    <div class="back-nav">
        <a href="javascript:history.back()" class="back-btn"><i class="fas fa-arrow-left"></i> &nbsp; BACK</a>
    </div>

    <div class="login-box">
        <i class="fas fa-user-shield" style="font-size: 50px; color: #00d2ff; margin-bottom: 15px;"></i>
        <h2>Admin Login</h2>
        <form action="" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login">LOGIN NOW</button>
        </form>
        <div class="footer-text">Protected by SecureShield Encryption</div>
    </div>

</body>
</html>