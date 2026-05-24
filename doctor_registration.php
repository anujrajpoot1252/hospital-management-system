<?php
session_start();
require_once 'config.php';
require_once 'mailer.php';

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

    // Generate random 8-character password
    $password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);

    $name      = trim($_POST['name']);
    $dept      = trim($_POST['dept']);
    $exp       = intval($_POST['exp']);
    $phone     = trim($_POST['phone']);
    $email     = strtolower(trim($_POST['email']));
    $avail     = $_POST['avail'];
    $time_from = $_POST['time_from'];
    $time_to   = $_POST['time_to'];
    $user_otp  = isset($_POST['otp']) ? trim($_POST['otp']) : '';

    // Final Security Check for OTP
    if (
        !isset($_SESSION['otp_verified'])
        || $_SESSION['otp_verified'] !== true
        || !isset($_SESSION['otp_email'])
        || strtolower($_SESSION['otp_email']) !== $email
    ) {
        echo "<script>alert('app ka registration  successful ho gya hai admin approverl kre ga '); window.history.back();</script>";
        exit();
    }

    // Clear session after use
    unset($_SESSION['otp']);
    unset($_SESSION['otp_email']);
    unset($_SESSION['otp_verified']);

    $status = 'pending';
    $stmt = $conn->prepare("INSERT INTO doctor (ID, Password, Name, Department, Experience, Phone, Email, Availability, TimeFrom, TimeTo, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $id, $password, $name, $dept, $exp, $phone, $email, $avail, $time_from, $time_to, $status);

    if ($stmt->execute()) {
        $subject = "Your HMS Doctor Account Details - Pending Approval";
        $message = "<h2>Doctor Registration Successful</h2>
                    <p>Hello $name,</p>
                    <p>Your doctor account has been created successfully and is now pending admin approval.</p>
                    <p><strong>Doctor ID:</strong> $id</p>
                    <p><strong>Password:</strong> $password</p>
                    <p>Please keep this password safe. You can log in using these credentials once the administrator approves your account.</p>
                    <p>Thank you!</p>";

        $mail_sent = sendHMSMail($email, $subject, $message);

        if ($mail_sent) {
            echo "<script>alert('Registration Successful! Your Doctor ID is: $id. Your password has been sent to $email. Wait for Admin approval.'); window.location.href='doctor_login.html';</script>";
        } else {
            echo "<script>alert('Registration Successful! Your Doctor ID is: $id. Your password is: $password. Email sending failed, please save this password. Wait for Admin approval.'); window.location.href='doctor_login.html';</script>";
        }
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
mysqli_close($conn);
?>
