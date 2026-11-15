<?php

session_start();
include("db.php");


// Check employee login
if(!isset($_SESSION['employee_id']))
{
    header("Location: employee_login.php");
    exit();
}


$employee_name = $_SESSION['employee_name'];


// Get complaint ID
if(!isset($_GET['id']))
{
    header("Location: employee_dashboard.php");
    exit();
}

$complaint_id = $_GET['id'];


// Update status
if(isset($_POST['update']))
{
    $status = $_POST['status'];

    $sql = "UPDATE complaints
            SET status='$status'
            WHERE id='$complaint_id'
            AND assigned_to='$employee_name'";

    if(mysqli_query($conn, $sql))
    {
        echo "<script>
                alert('Complaint status updated successfully');
                window.location='employee_dashboard.php';
              </script>";

        exit();
    }
}


// Get complaint
$query = mysqli_query(
    $conn,
    "SELECT * FROM complaints
     WHERE id='$complaint_id'
     AND assigned_to='$employee_name'"
);


if(mysqli_num_rows($query) == 0)
{
    echo "Complaint not found or not assigned to you.";
    exit();
}


$complaint = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>

<html>

<head>

<title>Update Complaint Status</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<h2>Update Complaint Status</h2>


<p>
<strong>Complaint No:</strong>

<?php echo htmlspecialchars($complaint['complaint_no']); ?>

</p>


<p>
<strong>Subject:</strong>

<?php echo htmlspecialchars($complaint['subject']); ?>

</p>


<p>
<strong>Current Status:</strong>

<?php echo htmlspecialchars($complaint['status']); ?>

</p>


<form method="POST">

<label>Select New Status</label>

<br><br>


<select name="status" required>

<option value="">Select Status</option>

<option value="Pending">
Pending
</option>

<option value="In Progress">
In Progress
</option>

<option value="Resolved">
Resolved
</option>

</select>


<br><br>


<button type="submit" name="update">
Update Status
</button>


</form>


<br>


<a href="employee_dashboard.php">
Back to Employee Dashboard
</a>


</body>

</html>