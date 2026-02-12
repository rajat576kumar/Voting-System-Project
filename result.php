<?php
include "db.php";

// Candidates data (Sorted by votes DESC)
$query = "SELECT * FROM candidates ORDER BY votes DESC";
$result = mysqli_query($conn, $query);

// Total votes for percentage calculation
$total_votes_res = mysqli_query($conn, "SELECT SUM(votes) as total FROM candidates");
$total_data = mysqli_fetch_assoc($total_votes_res);
$total_votes = ($total_data['total'] > 0) ? $total_data['total'] : 1; 

$count = 0; // Winner identify karne ke liye
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Results | VOTE-IT Stats</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg: #0b0f19;
            --primary: #00f2ff;
            --winner: #ffd700;
            --glass: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }

        body {
            background: var(--bg);
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow-x: hidden;
        }

        /* Animated Mesh Background */
        .bg-glow {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(0, 242, 255, 0.05) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(112, 0, 255, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        /* Top Header */
        header {
            width: 100%;
            padding: 40px 20px;
            text-align: center;
            animation: fadeInDown 0.8s ease;
        }

        .live-tag {
            background: rgba(255, 0, 0, 0.2);
            color: #ff4747;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            border: 1px solid #ff4747;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .pulse {
            width: 8px; height: 8px;
            background: #ff4747;
            border-radius: 50%;
            animation: pulse-animation 1.5s infinite;
        }

        @keyframes pulse-animation {
            0% { box-shadow: 0 0 0 0px rgba(255, 71, 71, 0.7); }
            100% { box-shadow: 0 0 0 10px rgba(255, 71, 71, 0); }
        }

        /* Main Container */
        .result-box {
            width: 90%;
            max-width: 700px;
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 35px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            margin-bottom: 50px;
        }

        .candidate-card {
            margin-bottom: 30px;
            position: relative;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 10px;
        }

        .candidate-name { font-size: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        
        /* Winner Style */
        .winner-text { color: var(--winner); text-shadow: 0 0 10px rgba(255, 215, 0, 0.3); }
        .crown { font-size: 24px; animation: bounce 2s infinite; }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .vote-stats { text-align: right; }
        .vote-count { font-size: 18px; font-weight: 800; color: var(--primary); }
        .percent-text { font-size: 12px; color: #888; display: block; }

        /* Modern Progress Bars */
        .progress-wrapper {
            width: 100%;
            height: 14px;
            background: rgba(255,255,255,0.05);
            border-radius: 50px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #7000ff, #00f2ff);
            border-radius: 50px;
            transition: width 1.5s cubic-bezier(0.1, 0.42, 0.41, 1);
            width: 0; /* Start at 0 for animation */
        }

        .winner-fill {
            background: linear-gradient(90deg, #f59e0b, #ffd700);
        }

        /* Back Navigation */
        .nav-footer {
            margin-top: 20px;
            display: flex;
            gap: 15px;
        }

        .btn {
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-home { background: white; color: black; }
        .btn-home:hover { background: var(--primary); color: black; transform: scale(1.05); }

        .back-link {
            position: absolute;
            top: 30px; left: 30px;
            color: #888; text-decoration: none;
            font-size: 14px;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="bg-glow"></div>
    
    <a href="javascript:history.back()" class="back-link"><i class="fas fa-arrow-left"></i> BACK</a>

    <header>
        <div class="live-tag">
            <div class="pulse"></div> Live Result Monitoring
        </div>
        <h1 style="font-size: 40px; font-weight: 800; letter-spacing: -1px;">Election <span style="color: var(--primary);">Leaderboard</span></h1>
    </header>

    <div class="result-box">
        <?php 
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) { 
                $percent = ($row['votes'] / $total_votes) * 100;
                $is_winner = ($count == 0 && $row['votes'] > 0); // Pehla candidate (Highest votes)
                $count++;
        ?>
            <div class="candidate-card">
                <div class="card-header">
                    <div class="candidate-name <?php echo $is_winner ? 'winner-text' : ''; ?>">
                        <?php if($is_winner): ?>
                            <i class="fas fa-crown crown"></i>
                        <?php endif; ?>
                        <?php echo $row['name']; ?>
                    </div>
                    <div class="vote-stats">
                        <span class="vote-count"><?php echo $row['votes']; ?></span>
                        <span class="percent-text"><?php echo number_format($percent, 1); ?>% of total</span>
                    </div>
                </div>
                <div class="progress-wrapper">
                    <div class="progress-fill <?php echo $is_winner ? 'winner-fill' : ''; ?>" 
                         style="width: <?php echo $percent; ?>%;"></div>
                </div>
            </div>
        <?php 
            } 
        } else {
            echo "<div style='text-align:center; color:#666; padding: 40px;'>
                    <i class='fas fa-database' style='font-size:40px; margin-bottom:15px;'></i>
                    <p>Waiting for the first vote to be cast...</p>
                  </div>";
        }
        ?>

        <div style="display: flex; justify-content: center; margin-top: 20px;">
            <a href="index.php" class="btn btn-home">
                <i class="fas fa-house"></i> RETURN TO HOME
            </a>
        </div>
    </div>

    <p style="color: #444; font-size: 12px; margin-bottom: 30px;">
        Data Refreshed On: <?php echo date('h:i:s A'); ?>
    </p>

</body>
</html>