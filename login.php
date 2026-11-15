<?php

session_start();
include("db.php");

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Find user by email
    $query = "SELECT * FROM users WHERE email='$email'";

    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        // Verify the entered password with the hashed password
        if(password_verify($password, $row['password']))
        {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard.php");
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

<title>User Login</title>

<link rel="stylesheet" href="./css/style.css">

</head>


<body>


<h2 align="center">

User Login

</h2>


<form method="POST" align="center">


<input
type="email"
name="email"
placeholder="Enter Email"
required
>

<br><br>


<input
type="password"
name="password"
placeholder="Enter Password"
required
>

<br><br>


<input
type="submit"
name="login"
value="Login"
>


</form>


</body>

</html>