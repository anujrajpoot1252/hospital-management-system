<?php
session_start();
$conn = mysqli_connect("localhost","root","","patient_db");

if(!$conn){
    die("Database connection failed");
}

// direct page open hone se bachane ke liye
if(!isset($_POST['email'])){
    echo "Access Denied";
    exit();
}

// form data lena safely
$email = $_POST['email'];
$password = $_POST['password'];
$realCaptcha = $_POST['realCaptcha'] ?? "";
$userCaptcha = $_POST['userCaptcha'] ?? "";   // NEW

//  CAPTCHA VERIFY
if($realCaptcha != $userCaptcha){
    echo "❌ Wrong Captcha";
    exit();
}

// email se patient find karo
$sql = "SELECT * FROM patient WHERE Email='$email'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 1)
{
    $row = mysqli_fetch_assoc($result);

    //  PASSWORD VERIFY
    if(password_verify($password, $row['password']))
    {
        $_SESSION['patient_email'] = $email;
        header("Location: patient_dashboard.php");
        exit();
    }
    else
    {
        echo " Wrong Password";
    }
}
else
{
    echo " Email not found";
}

mysqli_close($conn);
?>