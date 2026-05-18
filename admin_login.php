<?php 
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        $stmt->bind_result($password);
        $stmt->fetch();

        if ($password == $password) { 

            $_SESSION['admin'] = $email;

            header("Location: admin_dashboard.php");
            exit();

        } else {
            echo "Wrong Password";
        }

    } else {
        echo "Email not found";
    }
}

mysqli_close($conn);
?>