<?php
session_start();
include("../db.php");

if(!isset($_SESSION['admin']))
{
    header("Location: admin_login.php");
    exit();
}


if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $password = $_POST['password'];


    $sql = "INSERT INTO employees
    (name,email,department,password)

    VALUES

    ('$name','$email','$department','$password')";


    if(mysqli_query($conn,$sql))
    {
        echo "<script>
        alert('Employee Added Successfully');
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
<title>Add Employee</title>
<link rel="stylesheet" href="../css/style.css">
</head>


<body>

<div class="form">

<h2>Add Employee</h2>


<form method="POST">


<label>Employee Name</label>

<input type="text" name="name" required>


<label>Email</label>

<input type="email" name="email" required>


<label>Department</label>

<select name="department" required>

<option value="">Select Department</option>

<option value="IT">IT</option>

<option value="HR">HR</option>

<option value="Finance">Finance</option>

<option value="Maintenance">Maintenance</option>

</select>


<label>Password</label>

<input type="password" name="password" required>


<input type="submit" name="submit" value="Add Employee" class="btn">


</form>


<br>

<a href="admin_dashboard.php">Back to Dashboard</a>


</div>

</body>

</html>