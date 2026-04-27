<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost","root","","admin");
if(!$conn) die("Database Connection Failed");

// token get
$token = mysqli_real_escape_string($conn,$_GET['token'] ?? '');

if(empty($token)){
    die("<h2 style='color:red;text-align:center;'>Invalid Link</h2>");
}

// Token check query
$sql = "SELECT Email FROM patient_db 
        WHERE reset_token='$token' 
        AND reset_expiry > NOW()";

$result = mysqli_query($conn,$sql);

// password update
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if($pass != $confirm){
        echo "<script>alert('Passwords match nahi kar rahe');</script>";
    }
    else{
        $hash = password_hash($pass,PASSWORD_DEFAULT);

        $update = "UPDATE patient_db SET 
                   password='$hash',
                   reset_token=NULL,
                   reset_expiry=NULL
                     WHERE reset_token='$token'";


        $run = mysqli_query($conn,$update);

        if(!$run){
            die("Update Error: ".mysqli_error($conn));
        }

        echo "<script>
        alert('Password Reset Successful');
        window.location='patient_login.html';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
</head>
<link rel="stylesheet" href="style.css">
<body>
<div class="container">

<h2>Set New Password</h2>

<form method="post">
<input type="password" name="password" placeholder="New Password" required><br><br>
<input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
<button type="submit">Update Password</button>
</form>
</div>
</body>
</html>
