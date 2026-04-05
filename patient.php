<?php

// Database connection
$conn = mysqli_connect("localhost", "root", "", "patient_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];
$phone = $_POST['phone'];
$weight = $_POST['weight'];
$bgroup = $_POST['bgroup'];
$disease = $_POST['disease'];
$history = $_POST['history'];
$gender = $_POST['gender'];

// Insert query
$sql = "INSERT INTO patient (Name, Email, Age, Phone, weight, `Blood_group`, disease, `medical_history`, gender)
VALUES ('$name', '$email', '$age', '$phone', '$weight', '$bgroup', '$disease', '$history', 'gender')";
if(isset($_POST['gender'])){
    $gender = $_POST['gender'];
} else {
    $gender ="";
}

// Execute query
if (mysqli_query($conn, $sql)) {
    echo "✅ Data inserted successfully";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);

?>