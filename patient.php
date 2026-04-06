<?php

// Database connection
$conn = mysqli_connect("localhost", "root", "", "patient_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//  Code only run when form submit
if($_SERVER["REQUEST_METHOD"]=="POST"){

// Get form data  
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];
$phone = $_POST['phone'];
$weight = $_POST['weight'];
$bgroup = $_POST['bgroup'];
$disease = $_POST['disease'];
$history = $_POST['history'];
$new_password = $_POST['password'];          
$confirm_password = $_POST['confirm_password'];  
$gender = $_POST['gender'];

// Password match check 
if ($new_password !== $confirm_password) {
    echo " Passwords do not match. Please try again.";
    exit();
}

// Password HASH
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// INSERT query FIXED 
$sql = "INSERT INTO patient 
(Name, Email, Age, Phone, Weight, Blood_group, disease, medical_history, gender, password)
VALUES 
('$name', '$email', '$age', '$phone', '$weight', '$bgroup', '$disease', '$history', '$gender', '$hashed_password')";

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

} // POST close

mysqli_close($conn);

?>
