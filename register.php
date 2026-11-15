<?php

include("db.php");

if(isset($_POST['register']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Securely hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name, email, password)
            VALUES('$name', '$email', '$hashed_password')";

    if(mysqli_query($conn, $sql))
    {
        echo "<script>
        alert('Registration Successful');
        window.location='login.php';
        </script>";
    }
    else
    {
        echo "<script>
        alert('Registration Failed');
        </script>";
    }
}

?>

<!DOCTYPE html>

<html>

<head>

<title>User Registration</title>

<link rel="stylesheet" href="css/style.css">

</head>


<body>

<center>

<h2>User Registration</h2>


<form method="POST">


<input
type="text"
name="name"
placeholder="Enter Name"
required
>

<br><br>


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
name="register"
value="Register"
>


</form>


<br>


<a href="index.php">

Home

</a>


</center>

</body>

</html>