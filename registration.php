<?php
$conn = mysqli_connect("localhost","root","","hms");

if(!$conn){
    die("Connection Failed");
}

// form data lena
$name     = $_POST['name'];
$email    = $_POST['email'];
$password = $_POST['password'];
$age      = $_POST['age'];
$phone    = $_POST['phone'];
$weight   = $_POST['weight'];
$bgroup   = $_POST['bgroup'];
$disease  = $_POST['disease'];
$history  = $_POST['history'];
$gender   = $_POST['gender'];

// insert query
$sql = "INSERT INTO patients(name,email,password,age,phone,weight,bgroup,disease,history,gender)
VALUES('$name','$email','$password','$age','$phone','$weight','$bgroup','$disease','$history','$gender')";

if(mysqli_query($conn,$sql)){
    echo "<h2>Registration Successful</h2>";
    echo "<a href='patient_login.html'>Go to Login</a>";
}else{
    echo "Error";
}
?>