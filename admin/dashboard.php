<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location:admin_login.php");
    exit();
}
include('../db.php');

// 1. Stats Data
$voters_query = mysqli_query($conn, "SELECT * FROM users");
$candidates_query = mysqli_query($conn, "SELECT * FROM candidates");
$voted_count_query = mysqli_query($conn, "SELECT * FROM users WHERE status = 1");

$total_voters = mysqli_num_rows($voters_query);
$total_candidates = mysqli_num_rows($candidates_query);
$total_voted = mysqli_num_rows($voted_count_query);

// 2. Voting Activity (Name aur Email nikalne ke liye)
$recent_votes = mysqli_query($conn, "SELECT name, email FROM users WHERE status = 1 ORDER BY id DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* (Aapka purana CSS yahan rahega, maine naya CSS niche add kiya hai) */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f0f2f5; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: #1e293b; color: white; position: fixed; height: 100%; }
        .sidebar-header { padding: 30px 20px; text-align: center; background: #0f172a; color: #38bdf8; font-weight: 600; }
        .sidebar-menu { padding: 20px 10px; }
        .sidebar-menu a { display: flex; align-items: center; padding: 12px 15px; color: #94a3b8; text-decoration: none; margin-bottom: 10px; border-radius: 8px; transition: 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #334155; color: white; }
        .sidebar-menu i { margin-right: 15px; width: 20px; text-align: center; }

        .main-content { margin-left: 260px; flex: 1; padding: 30px; }
        .top-nav { background: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 30px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 15px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-bottom: 5px solid #38bdf8; }
        .stat-info h3 { color: #64748b; font-size: 13px; text-transform: uppercase; }
        .stat-info p { font-size: 24px; font-weight: 700; color: #1e293b; }

        /* --- New Activity Table Style --- */
        .activity-section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .activity-section h2 {
            font-size: 18px;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th {
            text-align: left;
            background: #f8fafc;
            padding: 12px;
            color: #64748b;
            font-size: 14px;
            border-bottom: 2px solid #f1f5f9;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 14px;
        }
        .status-voted {
            background: #dcfce7;
            color: #16a34a;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .btn-logout { background: #ef4444; color: white; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-shield-alt"></i> <span>VOTE ADMIN</span>
        </div>
        <div class="sidebar-menu">
            <a href="dashboard.php" class="active"><i class="fas fa-th-large"></i> <span>Dashboard</span></a>
            <a href="add_candidate.php"><i class="fas fa-user-plus"></i> <span>Add Candidate</span></a>
            <a href="view_results.php"><i class="fas fa-chart-bar"></i> <span>View Results</span></a>
            <a href="manage_voters.php"><i class="fas fa-users-cog"></i> <span>Manage Voters</span></a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-nav">
            <div class="user-info" style="font-weight: 600;">
                <i class="fas fa-user-circle" style="color:#38bdf8"></i> Welcome, <?php echo $_SESSION['admin']; ?>
            </div>
            <a href="../logout.php" class="btn-logout">Logout</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Voters</h3>
                    <p><?php echo $total_voters; ?></p>
                </div>
                <div style="font-size: 30px; color: #38bdf8;"><i class="fas fa-users"></i></div>
            </div>

            <div class="stat-card" style="border-color: #10b981;">
                <div class="stat-info">
                    <h3>Total Voted</h3>
                    <p><?php echo $total_voted; ?></p>
                </div>
                <div style="font-size: 30px; color: #10b981;"><i class="fas fa-vote-yea"></i></div>
            </div>

            <div class="stat-card" style="border-color: #f59e0b;">
                <div class="stat-info">
                    <h3>Total Candidates</h3>
                    <p><?php echo $total_candidates; ?></p>
                </div>
                <div style="font-size: 30px; color: #f59e0b;"><i class="fas fa-user-tie"></i></div>
            </div>
        </div>

        <div class="activity-section">
            <h2><i class="fas fa-history" style="color: #38bdf8;"></i> Recent Voting Activity</h2>
            
            <?php if(mysqli_num_rows($recent_votes) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Voter Name</th>
                        <th>Email Address</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($recent_votes)): ?>
                    <tr>
                        <td><strong><?php echo $row['name']; ?></strong></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><span class="status-voted">Success</span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p style="text-align: center; color: #64748b; padding: 20px;">Abhi tak kisi ne vote nahi kiya hai.</p>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>