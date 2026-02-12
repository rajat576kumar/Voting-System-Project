<?php
session_start();
include "db.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user'];

// 1. Fetch Candidates
$query = "SELECT * FROM candidates";
$candidates_res = mysqli_query($conn, $query);

// 2. Fetch User Details for Personalization
$user_check = mysqli_query($conn, "SELECT * FROM users WHERE email='$user_email'");
$user_data = mysqli_fetch_assoc($user_check);
$has_voted = ($user_data['status'] == 1);
$user_name = $user_data['name'] ?? 'Voter';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | VOTE-IT Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg: #050505;
            --primary: #00f2ff;
            --secondary: #7000ff;
            --glass: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }

        body {
            background: var(--bg);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated Background Particles Effect */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 50% 50%, #1a1a2e 0%, #050505 100%);
            z-index: -1;
        }

        /* Glowing Navbar */
        .nav-glass {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(15px);
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0; z-index: 1000;
        }

        .logo { font-weight: 800; font-size: 24px; letter-spacing: 2px; color: var(--primary); }
        
        .back-btn {
            text-decoration: none;
            color: white;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 50px;
            background: var(--glass);
            border: 1px solid var(--border);
            transition: 0.3s;
        }
        .back-btn:hover { background: white; color: black; }

        /* Main Layout */
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        /* Hero Welcome Section */
        .welcome-card {
            background: linear-gradient(135deg, rgba(112, 0, 255, 0.2), rgba(0, 242, 255, 0.2));
            border: 1px solid var(--border);
            padding: 40px;
            border-radius: 30px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-text h2 { font-size: 35px; margin-bottom: 5px; }
        .welcome-text p { color: #aaa; }

        .status-pill {
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: <?php echo $has_voted ? 'rgba(255, 71, 71, 0.2)' : 'rgba(0, 255, 133, 0.2)'; ?>;
            color: <?php echo $has_voted ? '#ff4747' : '#00ff85'; ?>;
            border: 1px solid currentColor;
        }

        /* Candidates Grid */
        .candidates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .candidate-card {
            background: var(--glass);
            border: 1px solid var(--border);
            padding: 30px;
            border-radius: 25px;
            text-align: center;
            transition: 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .candidate-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            background: rgba(255,255,255,0.06);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .avatar-circle {
            width: 80px; height: 80px;
            background: linear-gradient(45deg, var(--secondary), var(--primary));
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px;
            box-shadow: 0 0 20px rgba(0, 242, 255, 0.3);
        }

        .candidate-name { font-size: 22px; font-weight: 600; margin-bottom: 20px; }

        .vote-btn {
            width: 100%;
            padding: 12px;
            border-radius: 15px;
            border: none;
            background: white;
            color: black;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .vote-btn:hover:not(.disabled) {
            background: var(--primary);
            box-shadow: 0 0 25px var(--primary);
            transform: scale(1.05);
        }

        .vote-btn.disabled {
            background: #222;
            color: #555;
            cursor: not-allowed;
        }

        .logout-section {
            text-align: center;
            margin-top: 60px;
        }

        .logout-btn {
            color: #ff4747;
            text-decoration: none;
            font-weight: 600;
            opacity: 0.7;
            transition: 0.3s;
        }
        .logout-btn:hover { opacity: 1; }
    </style>
</head>
<body>

    <nav class="nav-glass">
        <div class="logo">VOTE-IT <span style="font-size: 10px; vertical-align: middle; opacity: 0.5;">v2.0</span></div>
        <a href="index.php" class="back-btn"><i class="fa-solid fa-house"></i> Home</a>
    </nav>

    <div class="dashboard-container">
        <div class="welcome-card">
            <div class="welcome-text">
                <h2>Hello, <span><?php echo $user_name; ?></span>!</h2>
                <p>Welcome to the Decentralized Voting Dashboard.</p>
            </div>
            <div class="status-pill">
                <i class="fa-solid <?php echo $has_voted ? 'fa-circle-check' : 'fa-fingerprint'; ?>"></i>
                <?php echo $has_voted ? 'Verification: VOTED' : 'Verification: ELIGIBLE'; ?>
            </div>
        </div>

        <h3 style="margin-bottom: 30px; font-weight: 400; color: #666;">
            <i class="fa-solid fa-list-ul"></i> Select your preferred candidate
        </h3>

        <div class="candidates-grid">
            <?php 
            if(mysqli_num_rows($candidates_res) > 0){
                while($row = mysqli_fetch_assoc($candidates_res)){ ?>
                    <div class="candidate-card">
                        <div class="avatar-circle">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div class="candidate-name"><?php echo $row['name']; ?></div>
                        
                        <?php if(!$has_voted): ?>
                            <a href="vote.php?vote_id=<?php echo $row['id']; ?>" 
                               onclick="return confirm('Do you want to cast your digital signature for <?php echo $row['name']; ?>?')" 
                               class="vote-btn">Cast Vote</a>
                        <?php else: ?>
                            <div class="vote-btn disabled">Already Voted</div>
                        <?php endif; ?>
                    </div>
                <?php } 
            } else {
                echo "<div style='grid-column: 1/-1; text-align:center; padding: 60px; border: 1px dashed var(--border); border-radius: 30px;'>
                        <p style='color:#666'>No Active Elections Found.</p>
                      </div>";
            }
            ?>
        </div>

        <div class="logout-section">
            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-power-off"></i> Secure Terminate Session
            </a>
        </div>
    </div>

</body>
</html>