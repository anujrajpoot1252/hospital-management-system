<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: doctor_login.html");
    exit();
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (empty($username) || empty($password)) {
    echo "<script>alert('Username aur Password daalna zaroori hai!'); history.back();</script>";
    exit();
}

/* 🔐 Prepared Statement (SQL Injection se safe) */
$stmt = mysqli_prepare($conn, "SELECT * FROM doctors WHERE username=?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($doc = mysqli_fetch_assoc($result)) {

    // 🔑 Password Verify (MD5 nahi use karna)
    if (password_verify($password, $doc['password'])) {

        $_SESSION['doctor_id']       = $doc['id'];
        $_SESSION['doctor_username'] = $doc['username'];
        $_SESSION['doctor_name']     = $doc['name'];

        header("Location: doctor_dashboard.php");
        exit();
    }
}

echo "<script>alert('❌ Galat Username ya Password!'); history.back();</script>";
?>