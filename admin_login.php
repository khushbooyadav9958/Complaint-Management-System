<?php

session_start();
include("../db.php");


// If admin is already logged in
if(isset($_SESSION['admin']))
{
    header("Location: admin_dashboard.php");
    exit();
}


if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Find admin by username
    $query = "SELECT * FROM admins
              WHERE username='$username'";

    $result = mysqli_query($conn, $query);


    if(mysqli_num_rows($result) > 0)
    {
        $admin = mysqli_fetch_assoc($result);


        // Verify hashed password
        if(password_verify($password, $admin['password']))
        {
            $_SESSION['admin'] = $admin['username'];

            header("Location: admin_dashboard.php");
            exit();
        }
        else
        {
            $error = "Invalid Username or Password";
        }
    }
    else
    {
        $error = "Invalid Username or Password";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Admin Login</title>

<link rel="stylesheet" href="../css/style.css">

</head>


<body>


<h2 align="center">

Admin Login

</h2>


<form method="post">


<table align="center">


<tr>

<td>Username:</td>

<td>

<input
type="text"
name="username"
required
>

</td>

</tr>


<tr>

<td>Password:</td>

<td>

<input
type="password"
name="password"
required
>

</td>

</tr>


<tr>

<td colspan="2" align="center">

<input
type="submit"
name="login"
value="Login"
>

</td>

</tr>


</table>

</form>


<?php

if(isset($error))
{
    echo "<p align='center'>$error</p>";
}

?>


</body>

</html>