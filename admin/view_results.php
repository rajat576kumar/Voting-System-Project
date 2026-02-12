<?php
include('../db.php');

// Database se candidates (role=2) uthao
$query = mysqli_query($conn, "SELECT * FROM users WHERE role=2");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Election Results</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f7f6; padding: 40px; }
        .container { max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .candidate-card { margin-bottom: 25px; }
        .info { display: flex; justify-content: space-between; font-weight: 600; margin-bottom: 8px; }
        .progress-bg { background: #e9ecef; border-radius: 50px; height: 12px; overflow: hidden; }
        .progress-fill { background: linear-gradient(90deg, #1abc9c, #16a085); height: 100%; border-radius: 50px; transition: 1s ease-in-out; }
        .back-btn { text-decoration: none; color: #1abc9c; font-weight: 600; display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        <div class="header">
            <h2><i class="fas fa-poll"></i> Live Election Results</h2>
        </div>

        <?php 
        if(mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_array($query)) { 
                $votes = $row['votes']; 
                $percent = ($votes > 0) ? ($votes * 10) : 0; // Adjust logic based on total voters
        ?>
            <div class="candidate-card">
                <div class="info">
                    <span><?php echo $row['name']; ?></span>
                    <span><?php echo $votes; ?> Votes</span>
                </div>
                <div class="progress-bg">
                    <div class="progress-fill" style="width: <?php echo $percent; ?>%;"></div>
                </div>
            </div>
        <?php 
            }
        } else {
            echo "<p style='text-align:center;'>No candidates found.</p>";
        }
        ?>
    </div>
</body>
</html>