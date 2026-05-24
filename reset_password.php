<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

// token get
$token = mysqli_real_escape_string($conn, $_GET['token'] ?? '');

if (empty($token)) {
    die("<h2 style='color:red;text-align:center;'>Invalid Link</h2>");
}

// Token check query - check patient
$sql_patient = "SELECT Email FROM patient_db 
                WHERE reset_token='$token' 
                AND reset_expiry > NOW()";
$result_patient = mysqli_query($conn, $sql_patient);

// Token check query - check doctor
$sql_doctor = "SELECT Email FROM doctor 
               WHERE reset_token='$token' 
               AND reset_expiry > NOW()";
$result_doctor = mysqli_query($conn, $sql_doctor);

$role = '';
if (mysqli_num_rows($result_patient) > 0) {
    $role = 'patient';
} elseif (mysqli_num_rows($result_doctor) > 0) {
    $role = 'doctor';
} else {
    die("<h2 style='color:red;text-align:center;'>Invalid or Expired Link</h2>");
}

// password update
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass != $confirm) {
        echo "<script>alert('Passwords match nahi kar rahe');</script>";
    } else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        if ($role === 'patient') {
            $update = "UPDATE patient_db SET 
                       password='$hash',
                       reset_token=NULL,
                       reset_expiry=NULL
                       WHERE reset_token='$token'";
            $redirect = 'patient_login.html';
        } else {
            $update = "UPDATE doctor SET 
                       Password='$pass',
                       reset_token=NULL,
                       reset_expiry=NULL
                       WHERE reset_token='$token'";
            $redirect = 'doctor_login.html';
        }

        $run = mysqli_query($conn, $update);

        if (!$run) {
            die("Update Error: " . mysqli_error($conn));
        }

        echo "<script>
        alert('Password Reset Successful');
        window.location='$redirect';
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
