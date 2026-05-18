<?php
session_start();

if (isset($_POST['otp']) && isset($_POST['email'])) {
    $user_otp = trim($_POST['otp']);
    $email = trim($_POST['email']);

    if (isset($_SESSION['otp']) && $_SESSION['otp'] == $user_otp && $_SESSION['otp_email'] == $email) {
        echo "verified";
    } else {
        echo "invalid";
    }
}
?>
