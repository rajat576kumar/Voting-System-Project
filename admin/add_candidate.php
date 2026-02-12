<?php
include("../db.php"); // Database connect karne ke liye

if(isset($_POST['add_btn'])){
    $name = mysqli_real_escape_string($conn, $_POST['c_name']);
    
    // Naya candidate database mein insert karne ki query
    $query = "INSERT INTO candidates (name, votes) VALUES ('$name', 0)";
    $run = mysqli_query($conn, $query);

    if($run){
        echo "<script>alert('Candidate Safalta purvak add ho gaya!'); window.location='dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Candidate | Admin Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            /* Futuristic Dark Background */
            background: radial-gradient(circle at top left, #1a2a6c, #b21f1f, #fdbb2d);
            background-size: 400% 400%;
            animation: moveBG 20s infinite alternate;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        @keyframes moveBG {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* Glassmorphism Card */
        .add-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 50px 40px;
            border-radius: 30px;
            box-shadow: 0 25px 45px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 450px;
            text-align: center;
            color: white;
            transition: 0.3s;
        }

        .add-card:hover {
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
            transform: translateY(-5px);
        }

        .icon-box {
            font-size: 60px;
            margin-bottom: 20px;
            color: #fdbb2d;
            filter: drop-shadow(0 0 10px rgba(253, 187, 45, 0.5));
        }

        h2 {
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        p {
            font-size: 13px;
            opacity: 0.7;
            margin-bottom: 30px;
        }

        /* Modern Form Elements */
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.7);
        }

        input {
            width: 100%;
            padding: 15px 15px 15px 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            outline: none;
            color: white;
            font-size: 16px;
            transition: 0.4s;
        }

        input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #fdbb2d;
            box-shadow: 0 0 20px rgba(253, 187, 45, 0.2);
        }

        /* 3D Gradient Button */
        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 15px;
            background: linear-gradient(45deg, #fdbb2d, #b21f1f);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.4s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(178, 31, 31, 0.3);
        }

        .btn:hover {
            background: linear-gradient(45deg, #b21f1f, #fdbb2d);
            transform: scale(1.02);
            box-shadow: 0 15px 30px rgba(178, 31, 31, 0.5);
        }

        /* Navigation Link */
        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .back-link:hover {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="add-card">
    <div class="icon-box">
        <i class="fas fa-user-tie"></i>
    </div>
    <h2>New Candidate</h2>
    <p>Election ke liye naya umeedwar shamil karein</p>

    <form action="" method="POST">
        <div class="input-group">
            <i class="fas fa-id-card"></i>
            <input type="text" name="c_name" placeholder="Full Name Enter Karein" required>
        </div>
        
        <button type="submit" name="add_btn" class="btn">
            <i class="fas fa-plus-circle"></i> &nbsp; ADD TO ELECTION
        </button>
    </form>

    <a href="dashboard.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

</body>
</html>