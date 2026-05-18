<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost","root","","admin");
if(!$conn) die("DB Error");

$email = $_POST['email'];

// user check
$result = mysqli_query($conn,"SELECT * FROM patient_db  WHERE Email='$email'");

if(mysqli_num_rows($result)>0){

    //  token generate karo
    $token = bin2hex(random_bytes(16));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    mysqli_query($conn,"UPDATE patient_db 
    SET reset_token='$token', reset_expiry='$expiry'
    WHERE Email='$email'");

    // require_once 'mailer.php';
    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=$token";
    
    // Display link on screen since mailer is removed
    echo "<h3>Mailer Removed</h3>";
    echo "<p>Your reset link is: <a href='$resetLink'>$resetLink</a></p>";
    echo "<p>Please copy this link to reset your password.</p>";
    exit();

}else{
    echo "<script>alert('Email not found'); window.location='forget_password.html';</script>";
}
?>
