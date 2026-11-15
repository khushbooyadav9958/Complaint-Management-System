<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include("db.php");

$user_id = $_SESSION['user_id'];

// Total Complaints
$total = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM complaints WHERE user_id='$user_id'"))['total'];

// Pending Complaints
$pending = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM complaints WHERE user_id='$user_id' AND status='Pending'"))['total'];

// In Progress Complaints
$progress = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM complaints WHERE user_id='$user_id' AND status='In Progress'"))['total'];

// Resolved Complaints
$resolved = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM complaints WHERE user_id='$user_id' AND status='Resolved'"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
   <link rel="stylesheet" href="css/style.css">
</head>

<body>

<h1>Complaint Management System</h1>

<h2>Welcome <?php echo $_SESSION['name']; ?></h2>
<div class="dashboard">

    <div class="card">
        <h3>Total Complaints</h3>
        <p><?php echo $total; ?></p>
    </div>

    <div class="card">
        <h3>Pending</h3>
        <p><?php echo $pending; ?></p>
    </div>

    <div class="card">
        <h3>In Progress</h3>
        <p><?php echo $progress; ?></p>
    </div>

    <div class="card">
        <h3>Resolved</h3>
        <p><?php echo $resolved; ?></p>
    </div>

</div>

<br><br>

<div class="menu">
    <a href="complaint.php">➕ Submit Complaint</a>
    <a href="view_complaints.php">📋 My Complaints</a>
    <a href="logout.php">🚪 Logout</a>
</div>

</body>
</html>