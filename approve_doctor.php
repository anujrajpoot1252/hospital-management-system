<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$conn = mysqli_connect("localhost", "root", "", "admin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = $_GET['id'];

    $stmt = $conn->prepare("UPDATE doctor SET Status='approved' WHERE ID=?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        ob_end_clean();
        header("Location: pending_doctor.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

} else {
    echo "Invalid Doctor ID";
}

mysqli_close($conn);
ob_end_flush();
?>
