<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

if(isset($_POST['update']))
{
    $status = $_POST['status'];
$admin_remarks = $_POST['admin_remarks'];

  $sql = "UPDATE complaints
        SET status='$status',
            admin_remarks='$admin_remarks'
        WHERE id='$id'";
    if(mysqli_query($conn, $sql))
    {
        header("Location: view_all_complaints.php");
        exit();
    }
    else
    {
        echo "Status not updated.";
    }
}

$sql = "SELECT * FROM complaints WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Complaint Status</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 align="center">Update Complaint Status</h2>

<form method="post">

<table align="center" border="1" cellpadding="10">

<tr>
    <td>Complaint ID</td>
    <td><?php echo $row['id']; ?></td>
</tr>

<tr>
    <td>Subject</td>
    <td><?php echo $row['subject']; ?></td>
</tr>

<tr>
    <td>Status</td>
    <td>
        <select name="status">
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Resolved">Resolved</option>
        </select>
    </td>
</tr>
<tr>
    <td>Admin Remarks</td>
    <td>
        <textarea name="admin_remarks" rows="4" cols="40"><?php echo $row['admin_remarks']; ?></textarea>
    </td>
</tr>

<tr>
    <td colspan="2" align="center">
        <input type="submit" name="update" value="Update Status">
    </td>
</tr>

</table>

</form>

<br>

<center>
<a href="view_all_complaints.php">Back</a>
</center>

</body>

</html>