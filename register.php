<?php
include "db.php";

if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // Check karein ki email pehle se toh nahi hai
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email pehle se registered hai!');</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')");
        if($insert){
            echo "<script>alert('Registration Successful!'); window.location='login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Registration | Join VOTE-IT</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            /* Moving Green-Emerald Gradient Background */
            background: linear-gradient(-45deg, #064e3b, #065f46, #10b981, #34d399);
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

        /* Floating Back Button */
        .top-nav {
            position: absolute;
            top: 30px;
            left: 30px;
            z-index: 100;
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
            color: #064e3b;
            transform: translateX(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Glassmorphism Registration Card */
        .reg-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 420px;
            text-align: center;
            color: white;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .reg-card h2 {
            font-size: 28px;
            margin-bottom: 5px;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .reg-card p.subtitle {
            font-size: 13px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 30px;
        }

        /* Input Styles */
        .input-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #34d399;
            font-size: 17px;
        }

        input {
            width: 100%;
            padding: 13px 15px 13px 50px;
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
            border-color: #34d399;
            box-shadow: 0 0 15px rgba(52, 211, 153, 0.2);
        }

        /* Create Account Button */
        .btn-reg {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 15px;
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.4s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            margin-top: 10px;
        }

        .btn-reg:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(16, 185, 129, 0.5);
        }

        .login-link {
            margin-top: 25px;
            font-size: 14px;
            color: rgba(255,255,255,0.6);
        }

        .login-link a {
            color: #34d399;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover { text-decoration: underline; }

    </style>
</head>
<body>

    <div class="top-nav">
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> BACK TO HOME
        </a>
    </div>

    <div class="reg-card">
        <div style="font-size: 50px; color: #34d399; margin-bottom: 15px;">
            <i class="fas fa-user-plus"></i>
        </div>
        <h2>Voter Register</h2>
        <p class="subtitle">Desh ke nirnay mein apni bhagidari shuru karein.</p>

        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="Full Name" required>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Create Password" required>
            </div>

            <button type="submit" name="register" class="btn-reg">
                CREATE ACCOUNT &nbsp; <i class="fas fa-check-circle"></i>
            </button>
        </form>

        <p class="login-link">Pehle se account hai? <a href="login.php">Login Karein</a></p>
    </div>

</body>
</html>