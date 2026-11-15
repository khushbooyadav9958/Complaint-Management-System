<?php

session_start();
include("db.php");

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Find employee by email
    $query = "SELECT * FROM employees
              WHERE email='$email'";

    $result = mysqli_query($conn, $query);


    if(mysqli_num_rows($result) > 0)
    {
        $employee = mysqli_fetch_assoc($result);


        // Verify hashed password
        if(password_verify($password, $employee['password']))
        {
            $_SESSION['employee_id'] = $employee['id'];
            $_SESSION['employee_name'] = $employee['name'];

            header("Location: employee_dashboard.php");
            exit();
        }
        else
        {
            echo "<script>
            alert('Invalid Email or Password');
            </script>";
        }
    }
    else
    {
        echo "<script>
        alert('Invalid Email or Password');
        </script>";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Employee Login</title>

<link rel="stylesheet" href="css/style.css">

</head>


<body>


<div class="form">


<h2>Employee Login</h2>


<form method="POST">


<label>Email</label>

<input
type="email"
name="email"
required
>


<label>Password</label>

<input
type="password"
name="password"
required
>


<input
type="submit"
name="login"
value="Login"
class="btn"
>


</form>


</div>


</body>

</html>