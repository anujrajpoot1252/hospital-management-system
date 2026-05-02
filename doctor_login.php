<?php
session_start();

// Database connect
$conn = mysqli_connect("localhost", "root", "", "admin");


if (!$conn) {
    die("Connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id       = trim($_POST['id']);
    $password    = $_POST['password'];
    
    // Empty check
    if (empty($id) || empty($password)) {
        echo "<script>alert('Please fill all fields');</script>";
        exit();
    }




    $sql = "SELECT * FROM doctor WHERE ID='$id' AND Password='$password' AND status='approved'";
    $result = mysqli_query($conn, $sql);
    $sql = "SELECT * FROM doctor WHERE ID='$id' AND Password='$password' AND status='approved'";        
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
             echo "<script>
                    alert('Login Successful!');
                    window.location.href = 'doctor_dashboard.php';
                  </script>";
            exit();
        }
    }

    echo "<script>alert('Wrong id or Password!');</script>";


mysqli_close($conn);
?>