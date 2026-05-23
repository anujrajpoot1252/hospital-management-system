<?php
session_start();

if (isset($_POST['otp']) && isset($_POST['email'])) {
    $user_otp = trim($_POST['otp']);
    $email = strtolower(trim($_POST['email']));

    if (
        isset($_SESSION['otp'])
        && $_SESSION['otp'] == $user_otp
        && isset($_SESSION['otp_email'])
        && strtolower($_SESSION['otp_email']) == $email
    ) {
        $_SESSION['otp_verified'] = true;
        echo "verified";
    } else {
        echo "invalid";
    }
}
?>
