<?php
include('../db.php');

// Delete Logic
if(isset($_GET['del'])){
    $id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    header('location:manage_voters.php');
}

// Fetch Voters
$query = mysqli_query($conn, "SELECT * FROM users WHERE role=1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Voter Management | Advanced</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f1f5f9; padding: 40px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1e293b; color: white; padding: 15px; text-align: left; border-radius: 5px; }
        td { padding: 15px; border-bottom: 1px solid #e2e8f0; }
        .voter-img { width: 45px; height: 45px; border-radius: 50%; background: #ddd; display: inline-block; margin-right: 10px; vertical-align: middle; }
        .status { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .voted { background: #dcfce7; color: #16a34a; }
        .pending { background: #fee2e2; color: #ef4444; }
        .btn-del { color: #ef4444; text-decoration: none; border: 1px solid #ef4444; padding: 5px 10px; border-radius: 8px; transition: 0.3s; }
        .btn-del:hover { background: #ef4444; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><i class="fas fa-users"></i> Registered Voters</h2>
            <a href="dashboard.php" style="text-decoration:none; color:#3b82f6; font-weight:600;">← Back</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Voter Details</th>
                    <th>Mobile Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($query)){ ?>
                <tr>
                    <td>
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row['name']); ?>&background=random" class="voter-img">
                        <b><?php echo $row['name']; ?></b>
                    </td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td>
                        <span class="status <?php echo ($row['status']==1) ? 'voted' : 'pending'; ?>">
                            <?php echo ($row['status']==1) ? 'Voted' : 'Not Voted'; ?>
                        </span>
                    </td>
                    <td>
                        <a href="manage_voters.php?del=<?php echo $row['id']; ?>" class="btn-del" onclick="return confirm('Delete this voter?')">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>