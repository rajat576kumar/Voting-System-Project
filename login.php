<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
    // SQL Injection protection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$pass'");
    
    if(mysqli_num_rows($q) > 0){
        $user_data = mysqli_fetch_assoc($q);
        $_SESSION['user'] = $user_data['email'];
        $_SESSION['id'] = $user_data['id'];
        echo "<script>alert('Login Successful! Redirecting to Vote area...'); window.location='vote.php';</script>";
    } else {
        echo "<script>alert('Galat Email ya Password!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Login | Secure Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            /* Advanced Moving Background */
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0ea5e9, #0369a1);
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

        /* Fixed Back Button */
        .top-nav {
            position: absolute;
            top: 25px;
            left: 25px;
            z-index: 10;
        }

        .back-btn {
            text-decoration: none;
            color: white;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 22px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #fff;
            color: #0f172a;
            transform: translateX(-5px);
        }

        /* Glassmorphism Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 45px;
            border-radius: 30px;
            box-shadow: 0 25px 45px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 420px;
            text-align: center;
            color: white;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card h2 {
            font-size: 30px;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .login-card p {
            font-size: 14px;
            color: #cbd5e1;
            margin-bottom: 35px;
        }

        /* Input Group Design */
        .form-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #38bdf8;
            font-size: 18px;
        }

        input {
            width: 100%;
            padding: 14px 14px 14px 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            outline: none;
            color: white;
            font-size: 15px;
            transition: 0.4s;
        }

        input::placeholder { color: rgba(255,255,255,0.4); }

        input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #38bdf8;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.2);
        }

        /* Neon Login Button */
        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 15px;
            background: linear-gradient(45deg, #0ea5e9, #2563eb);
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.4s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
        }

        .btn-login:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 25px rgba(14, 165, 233, 0.5);
        }

        .footer-link {
            margin-top: 25px;
            font-size: 14px;
            color: #94a3b8;
        }

        .footer-link a {
            color: #38bdf8;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="top-nav">
        <a href="index.php" class="back-btn">
            <i class="fas fa-chevron-left"></i> BACK TO HOME
        </a>
    </div>

    <div class="login-card">
        <div style="font-size: 50px; margin-bottom: 20px; color: #38bdf8;">
            <i class="fas fa-user-check"></i>
        </div>
        <h2>Voter Login</h2>
        <p>Please enter your credentials to vote.</p>
        
        <form action="" method="POST">
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" name="login" class="btn-login">
                SIGN IN &nbsp; <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="footer-link">
            New voter? <a href="register.php">Create Account</a>
        </div>
    </div>

</body>
</html>