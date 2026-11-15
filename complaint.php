<?php
session_start();
include("db.php");


if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
    exit();
}


if(isset($_POST['submit']))
{
    $user_id = $_SESSION['user_id'];


    // Get form data
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];


    // Get user details
    $user = mysqli_query($conn, "SELECT name, email FROM users WHERE id='$user_id'");
    $userdata = mysqli_fetch_assoc($user);


    $name = $userdata['name'];
    $email = $userdata['email'];


    // Generate Complaint Number
    $result = mysqli_query($conn, "SELECT MAX(id) AS last_id FROM complaints");
    $row = mysqli_fetch_assoc($result);


    if($row['last_id'])
    {
        $next_id = $row['last_id'] + 1;
    }
    else
    {
        $next_id = 1;
    }


    $complaint_no = "CMP" . date("Y") . str_pad($next_id,4,"0",STR_PAD_LEFT);



    // Insert Complaint

    $sql = "INSERT INTO complaints
    (
    complaint_no,
    user_id,
    name,
    email,
    subject,
    description,
    category,
    priority,
    assigned_to,
    admin_remarks,
    status
    )

    VALUES

    (
    '$complaint_no',
    '$user_id',
    '$name',
    '$email',
    '$subject',
    '$description',
    '$category',
    '$priority',
    'Not Assigned',
    '',
    'Pending'
    )";


    if(mysqli_query($conn,$sql))
    {
        echo "<script>
        alert('Complaint Submitted Successfully. Complaint No: $complaint_no');
        window.location='dashboard.php';
        </script>";
    }
    else
    {
        echo "<script>
        alert('Error: ".mysqli_error($conn)."');
        </script>";
    }

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Submit Complaint</title>

<link rel="stylesheet" href="css/style.css">

</head>


<body>


<div class="form">


<h2>Register Complaint</h2>


<form method="POST">


<label>Complaint Subject</label>

<select name="subject" required>

<option value="">Select Complaint Subject</option>

<option value="Computer Not Working">Computer Not Working</option>

<option value="WiFi / Internet Issue">WiFi / Internet Issue</option>

<option value="Printer Issue">Printer Issue</option>

<option value="Software Installation">Software Installation</option>

<option value="Email Problem">Email Problem</option>

<option value="Network Issue">Network Issue</option>

<option value="Electricity Issue">Electricity Issue</option>

<option value="Air Conditioner Issue">Air Conditioner Issue</option>

<option value="Furniture Issue">Furniture Issue</option>

<option value="Other">Other</option>

</select>



<label>Description</label>

<textarea 
name="description"
placeholder="Write your complaint"
required></textarea>



<label>Category</label>

<select name="category" required>

<option value="">Select Category</option>

<option value="Technical">Technical</option>

<option value="HR">HR</option>

<option value="Finance">Finance</option>

<option value="Maintenance">Maintenance</option>

<option value="Other">Other</option>

</select>



<label>Priority</label>

<select name="priority" required>

<option value="Low">Low</option>

<option value="Medium" selected>Medium</option>

<option value="High">High</option>

</select>



<input 
type="submit"
name="submit"
value="Submit Complaint"
class="btn">


</form>


<br>

<a href="dashboard.php">Back to Dashboard</a>


</div>


</body>

</html>