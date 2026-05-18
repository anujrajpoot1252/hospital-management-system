<?php
session_start();
require_once 'mailer.php';

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $otp = rand(100000, 999999);
    
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_email'] = $email;

    $subject = "HMS Registration OTP";
    $message = "<h2>Email Verification</h2>
                <p>Hello,</p>
                <p>Your One-Time Password (OTP) for registration is:</p>
                <h1 style='color: #0e9e8e; letter-spacing: 5px; font-size: 40px;'>$otp</h1>
                <p>Please enter this code on the registration page to verify your email.</p>
                <p>Thank you!</p>";

    if (sendHMSMail($email, $subject, $message)) {
        echo "success";
    } else {
        echo "failed";
    }
}
?>
