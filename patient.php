<?php
$conn = mysqli_connect("localhost", "root", "", "patient_db");

if (!$conn) {
    die("Connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $weight = $_POST['weight'];
    $bgroup = $_POST['bgroup'];
    $disease = $_POST['disease'];
    $history = $_POST['history'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $gender = $_POST['gender'];

    if ($password != $confirm) {
        echo "Password match nahi kar raha hai";
        exit();
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO patient (Name, Email, Age, Phone, Weight, Blood_group, disease, medical_history, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssisssssss", $name, $email, $age, $phone, $weight, $bgroup, $disease, $history, $gender, $hashed);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Ab login karo'); window.location.href='patient login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

mysqli_close($conn);
?>
