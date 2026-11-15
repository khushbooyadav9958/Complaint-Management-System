<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM complaints WHERE user_id='$user_id'";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View My Complaints</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2 align="center">My Complaints</h2>

<table border="1" align="center" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Subject</th>
    <th>Description</th>
    <th>Status</th>
</tr>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['subject']; ?></td>

<td><?php echo $row['description']; ?></td>

<td><?php echo $row['status']; ?></td>

</tr>

<?php

}

?>

</table>

<br>

<center>

<a href="dashboard.php">Back to Dashboard</a>

</center>

</body>

</html>