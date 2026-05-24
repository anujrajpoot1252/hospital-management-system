<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'mailer.php';

if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
    echo "<script>alert('Please enter an email address'); window.location='forget_password.html';</script>";
    exit();
}

$email = mysqli_real_escape_string($conn, trim($_POST['email']));

// Check if email belongs to patient
$result_patient = mysqli_query($conn, "SELECT * FROM patient_db WHERE Email='$email'");

// Check if email belongs to doctor
$result_doctor = mysqli_query($conn, "SELECT * FROM doctor WHERE Email='$email'");

if (mysqli_num_rows($result_patient) > 0) {
    // Patient flow
    $token = bin2hex(random_bytes(16));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    mysqli_query($conn, "UPDATE patient_db 
                         SET reset_token='$token', reset_expiry='$expiry'
                         WHERE Email='$email'");

    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=$token";
    
    $subject = "HMS Patient Password Reset Request";
    $message = "<h3>Password Reset Request</h3>
                <p>We received a request to reset the password for your HMS Patient account.</p>
                <p>Please click the link below to set a new password of your choice:</p>
                <p><a href='$resetLink' style='padding: 10px 20px; background-color: #0d6efd; color: white; text-decoration: none; border-radius: 5px; display: inline-block;'>Reset Password</a></p>
                <p>If you did not request this, please ignore this email. This link is valid for 1 hour.</p>";
    
    $mail_sent = sendHMSMail($email, $subject, $message);

    echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;'>";
    if ($mail_sent) {
        echo "<h3 style='color: green;'>Reset Link Sent!</h3>";
        echo "<p>A password reset link has been successfully sent to <b>$email</b>. Please check your inbox.</p>";
    } else {
        echo "<h3 style='color: orange;'>Mail Delivery Failed</h3>";
        echo "<p>We were unable to send the email, but you can use the link below to reset your password for testing:</p>";
    }
    echo "<p><strong>Reset Link:</strong> <a href='$resetLink'>$resetLink</a></p>";
    echo "<p><a href='patient_login.html'>Back to Login</a></p>";
    echo "</div>";
    exit();

} elseif (mysqli_num_rows($result_doctor) > 0) {
    // Doctor flow
    $token = bin2hex(random_bytes(16));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    mysqli_query($conn, "UPDATE doctor 
                         SET reset_token='$token', reset_expiry='$expiry'
                         WHERE Email='$email'");

    $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=$token";
    
    $subject = "HMS Doctor Password Reset Request";
    $message = "<h3>Password Reset Request</h3>
                <p>We received a request to reset the password for your HMS Doctor account.</p>
                <p>Please click the link below to set a new password of your choice:</p>
                <p><a href='$resetLink' style='padding: 10px 20px; background-color: #00bfff; color: white; text-decoration: none; border-radius: 5px; display: inline-block;'>Reset Password</a></p>
                <p>If you did not request this, please ignore this email. This link is valid for 1 hour.</p>";
    
    $mail_sent = sendHMSMail($email, $subject, $message);

    echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;'>";
    if ($mail_sent) {
        echo "<h3 style='color: green;'>Reset Link Sent!</h3>";
        echo "<p>A password reset link has been successfully sent to <b>$email</b>. Please check your inbox.</p>";
    } else {
        echo "<h3 style='color: orange;'>Mail Delivery Failed</h3>";
        echo "<p>We were unable to send the email, but you can use the link below to reset your password for testing:</p>";
    }
    echo "<p><strong>Reset Link:</strong> <a href='$resetLink'>$resetLink</a></p>";
    echo "<p><a href='doctor_login.html'>Back to Login</a></p>";
    echo "</div>";
    exit();

} else {
    echo "<script>alert('Email not found'); window.location='forget_password.html';</script>";
}
mysqli_close($conn);
?>
