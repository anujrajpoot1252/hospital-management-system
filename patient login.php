<?php
session_start();   // Login ke baad user ko yaad rakhne ke liye

// Database connect
$conn = mysqli_connect("localhost", "root", "", "patient_db");

if (!$conn) {
    die("Connection failed");
}

// Form submit hone par ye code chalega
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email       = trim($_POST['email']);
    $password    = $_POST['password'];
    $userCaptcha = $_POST['userCaptcha'];
    $realCaptcha = $_POST['realCaptcha'];

    // Captcha check
    if ($userCaptcha != $realCaptcha) {
        echo "<script>alert('Wrong Captcha! Try again.');</script>";
        exit();
    }

    // Safe query (SQL Injection se bachne ke liye)
    $stmt = $conn->prepare("SELECT password FROM patient WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Password sahi hai ya nahi check karo
        if (password_verify($password, $hashed_password)) {
            $_SESSION['patient_email'] = $email;   // Session mein save karo
            echo "<script>
                    alert('Login Successful! Welcome.');
                    window.location.href = 'patient_dashboard.php';
                  </script>";
            exit();
        }
    }

    // Agar email ya password galat ho
    echo "<script>alert('Wrong Email or Password!');</script>";
}

mysqli_close($conn);
?>