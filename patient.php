<?php

// Database connection
$conn = mysqli_connect("localhost", "root", "", "patient_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Form submit check
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $age      = $_POST['age'];
    $phone    = $_POST['phone'];
    $weight   = $_POST['weight'];
    $height   = $_POST['height']; // cm me number (e.g. 170.5)
    $bgroup   = $_POST['bgroup'];
    $disease  = $_POST['disease'];
    $history  = $_POST['history'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $gender   = $_POST['gender'];

    // Default photo
    $folder = "uploads/default.png";

    // File upload
    if (!empty($_FILES['photo']['name'])) {

        $filename = $_FILES['photo']['name'];
        $tempname = $_FILES['photo']['tmp_name'];
        $folder = "uploads/" . $filename;

        move_uploaded_file($tempname, $folder);
    }

    // Password validation
    if (!preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}/", $password)) {
        echo "Password must contain uppercase, lowercase, number and special character!";
        exit();
    }

    // Password match check
    if ($password != $confirm) {
        echo "<script>alert('Passwords match nahi kar rahe hain!');</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare query (FIXED)
    $stmt = $conn->prepare("INSERT INTO patient 
    (Name, Email, Age, Phone, Weight, height, Blood_group, disease, medical_history, gender, password, photo) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind types
    $stmt->bind_param("ssissdssssss",
        $name,
        $email,
        $age,
        $phone,
        $weight,
        $height,   // decimal number  (cm)
        $bgroup,
        $disease,
        $history,
        $gender,
        $hashed_password,
        $folder
    );

    // Execute
    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'patient_login.html';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

mysqli_close($conn);
?>
