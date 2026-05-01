<?php
session_start();

//  admin login check
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// DB connection
$conn = mysqli_connect("localhost", "root", "", "admin");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check ID
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];

    // Prepared statement
    $stmt = $conn->prepare("DELETE FROM doctor WHERE status='pending' AND ID=?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
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
