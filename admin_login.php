<?php
session_start();

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "Admin");

if (!$conn) {
    die("Connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Safe Query
    $stmt = $conn->prepare("SELECT password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

   

            echo "<script>
                    alert('Admin Login Successful! Welcome.');
                    window.location.href = 'admin_dashboard.php';
                  </script>";
            exit();
        }
    

echo "<script>alert('Wrong Email or Password!');</script>";


mysqli_close($conn);
?>