<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost","root","","hms");

if(!$conn){
    die("Database connection failed");
}

// Form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check patient in database
$sql = "SELECT * FROM patients WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==1){
    
    $row = mysqli_fetch_assoc($result);
    
    // Session create
    $_SESSION['patient'] = $row['name'];
    $_SESSION['email'] = $row['email'];

    // Redirect to dashboard
    header("Location: patient_dashboard.php");
}
else{
    echo "<h2>Invalid Email or Password</h2>";
    echo "<a href='patient_login.html'>Try Again</a>";
}
?>