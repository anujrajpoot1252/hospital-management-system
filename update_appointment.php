<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.html");
    exit();
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];
    $doctor_id = $_SESSION['doctor_id'];

    // Only allow 'completed' or 'cancelled' status updates
    if (in_array($status, ['completed', 'cancelled'])) {
        $stmt = $conn->prepare("UPDATE appointment SET status = ? WHERE id = ? AND doctor_id = ?");
        $stmt->bind_param("sis", $status, $id, $doctor_id);

        if ($stmt->execute()) {
            if ($status === 'completed') {
                $alert_msg = "Appointment successfully complete ho gayi hai! Ab iske baad koi doosra appointment liya ja sakta hai.\\n(Appointment completed successfully! Another appointment can now be booked.)";
            } else {
                $alert_msg = "Appointment has been successfully cancelled.";
            }
            echo "<script>alert(\"$alert_msg\"); window.location.href='doctor_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating appointment'); window.location.href='doctor_dashboard.php';</script>";
        }
        $stmt->close();
    } else {
        header("Location: doctor_dashboard.php");
    }
} else {
    header("Location: doctor_dashboard.php");
}

$conn->close();
?>
