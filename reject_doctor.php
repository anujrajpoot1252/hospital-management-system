<?php
session_start();
require_once 'config.php';

// admin login check
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Check ID
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];

    // Fetch doctor info for email before deleting
    $res = mysqli_query($conn, "SELECT Name, Email FROM doctor WHERE ID='$id'");
    $doctor = mysqli_fetch_assoc($res);

    // Prepared statement
    $stmt = $conn->prepare("DELETE FROM doctor WHERE status='pending' AND ID=?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        if ($doctor) {
            require_once 'mailer.php';
            $subject = "Application Status - HMS";
            $message = "<h3>Registration Update</h3>
                        <p>Dear Dr. " . $doctor['Name'] . ",</p>
                        <p>We regret to inform you that your registration application for the Hospital Management System has been declined.</p>
                        <p>If you have any questions, please contact our support team.</p>";
            sendHMSMail($doctor['Email'], $subject, $message);
        }

        $stmt->close();
        mysqli_close($conn);

        // Redirect after delete
        header("Location: pending_doctor.php?rejected=1");
        exit();

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "Invalid Doctor ID";
}

mysqli_close($conn);
?>