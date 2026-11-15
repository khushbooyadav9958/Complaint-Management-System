<?php
session_start();

if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<h1>Welcome Admin</h1>

<h3>Complaint Management System - Admin Panel</h3>

<br>

<a href="view_all_complaints.php">View All Complaints</a>

<br><br>

<a href="admin_logout.php">Logout</a>

</body>

</html>