<?php
include 'db.php';

$u=$_POST['username'];
$p=$_POST['password'];

$q=mysqli_query($conn,"SELECT * FROM doctors WHERE username='$u' AND password='$p'");

if(mysqli_num_rows($q)>0)
{
echo "<h2>Doctor Dashboard</h2>";

$res=mysqli_query($conn,"SELECT * FROM patients");

while($row=mysqli_fetch_assoc($res))
{
echo "<hr>";
echo "Name: ".$row['name']."<br>";
echo "Email: ".$row['email']."<br>";
echo "Disease: ".$row['disease']."<br>";
}
}
else echo "Doctor Login Failed";
?>