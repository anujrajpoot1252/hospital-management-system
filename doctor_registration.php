<?php
session_start();
require_once 'config.php';

if (isset($_POST['add'])) {
    // Auto-generate Doctor ID starting from hms2601
    $res = $conn->query("SELECT ID FROM doctor WHERE ID LIKE 'hms%' ORDER BY ID DESC LIMIT 1");
    if ($row = $res->fetch_assoc()) {
        $last_id = $row['ID'];
        $num = intval(substr($last_id, 3));
        $next_id = "hms" . ($num + 1);
    } else {
        $next_id = "hms2601";
    }
    $id = $next_id;

    $password  = trim($_POST['password']);
    $name      = trim($_POST['name']);
    $dept      = trim($_POST['dept']);
    $exp       = intval($_POST['exp']);
    $phone     = trim($_POST['phone']);
    $email     = trim($_POST['email']);
    $avail     = $_POST['avail'];
    $time_from = $_POST['time_from'];
    $time_to   = $_POST['time_to'];
    $user_otp  = isset($_POST['otp']) ? trim($_POST['otp']) : '';

    // Final Security Check for OTP
    if (!isset($_SESSION['otp']) || $_SESSION['otp'] != $user_otp || $_SESSION['otp_email'] != $email) {
        echo "<script>alert('Security Error: Email not verified!'); window.history.back();</script>";
        exit();
    }

    // Clear session after use
    unset($_SESSION['otp']);
    unset($_SESSION['otp_email']);

    $status = 'pending';
    $stmt = $conn->prepare("INSERT INTO doctor (ID, Password, Name, Department, Experience, Phone, Email, Availability, TimeFrom, TimeTo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $id, $password, $name, $dept, $exp, $phone, $email, $avail, $time_from, $time_to, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Registration Successful! Your ID is: $id. Wait for Admin approval.'); window.location.href='doctor_login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
mysqli_close($conn);
?>