<?php
include "connect.php";

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['pass'];
$gender = $_POST['gender'];

$sql = "INSERT INTO patients(fname,lname,email,phone,password,gender)
VALUES('$fname','$lname','$email','$phone','$password','$gender')";

if(mysqli_query($conn,$sql)){
    echo "<h2>Registration Successful</h2>";
    echo "<a href='index.html'>Go Home</a>";
}else{
    echo "Error: " . mysqli_error($conn);
}
?>