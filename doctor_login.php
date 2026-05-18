<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = trim($_POST['id'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($id) || empty($password)) {
        echo "<script>alert('Please fill all fields'); window.history.back();</script>";
        exit();
    }

    $sql = "SELECT ID, Password, status FROM doctor WHERE ID=?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($password == $row['Password']) {
            if ($row['status'] == 'approved') {
                $_SESSION['doctor_id'] = $row['ID'];
                header("Location: doctor_dashboard.php");
                exit();
            } else {
                echo "<script>alert('Your account is pending approval by admin.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Invalid Password'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Invalid ID'); window.history.back();</script>";
    }
}
?>