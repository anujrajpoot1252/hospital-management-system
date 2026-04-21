<?php

// Database se connect karo
$conn = mysqli_connect("localhost", "root", "", "patient_db");

if (!$conn) {
    die("Connection failed");
}

// Jab patient form bhar ke submit kare tab ye code chalega
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $age      = $_POST['age'];
    $phone    = $_POST['phone'];
    $weight   = $_POST['weight'];
    $bgroup   = $_POST['bgroup'];
    $disease  = $_POST['disease'];
    $history  = $_POST['history'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $gender   = $_POST['gender'];

    // Default values (IMPORTANT)
    $folder = "/uploads/"; // Agar photo upload nahi hota to default image set kar do
   

   if (isset($_FILES['photo'])) {

    $filename = $_FILES['photo']['name'];
    $tempname = $_FILES['photo']['tmp_name'];
    $folder = "uploads/" . $filename;

    if (move_uploaded_file($tempname, $folder)) {
        echo "File uploaded successfully";
    } else {
        echo "Upload failed";
    }

} else {
    echo "File not received";
}



   // Pehle check karo ki dono password same hain ya nahi
    if ($password != $confirm) {
        echo "<script>alert('Passwords match nahi kar rahe hain!');</script>";
        exit();
    }

    // Password ko safe banao (hash karo)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Data database mein safe tarike se insert karo
    $stmt = $conn->prepare("INSERT INTO patient 
        (Name, Email, Age, Phone, Weight, Blood_group, disease, medical_history, gender, password, photo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param( "ssississsss", $name, $email, $age, $phone, $weight, $bgroup, $disease, $history, $gender, $hashed_password, $folder);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Ab login kar sakte ho.');
                window.location.href = 'patient login.html';
              </script>";
    } else {
        echo "<script>alert('Registration mein error aa gaya. Dobara try karo.');</script>";
    }

    $stmt->close();
}

mysqli_close($conn);
?>
