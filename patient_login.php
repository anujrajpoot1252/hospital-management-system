<?php
session_start();

// Database connect
$conn = mysqli_connect("localhost", "root", "", "admin");

if (!$conn) {
    die("Connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email       = trim($_POST['email']);
    $password    = $_POST['password'];
    $userCaptcha = $_POST['userCaptcha'];
    $realCaptcha = $_POST['realCaptcha'];

    // Empty check
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill all fields');</script>";
        exit();
    }

    // Captcha check
    if ($userCaptcha != $realCaptcha) {
        echo "<script>alert('Wrong Captcha! Try again.');</script>";
        exit();
    }

    // Prepared statement
    $stmt = $conn->prepare("SELECT password FROM patient_db WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['patient_email'] = $email;

            echo "<script>
                    alert('Login Successful!');
                    window.location.href = 'patient_dashboard.php';
                  </script>";
            exit();
        }
    }

    echo "<script>alert('Wrong Email or Password!');</script>";
}

mysqli_close($conn);
?>