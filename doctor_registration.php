<?php
$conn = mysqli_connect("localhost", "root", "", "Admin");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $dept = $_POST['dept'];
    $exp = $_POST['exp'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $avail = $_POST['avail'];






    $stmt = $conn->prepare("INSERT INTO doctor (ID, Password, Name, Department, Experience, Phone, Email, Availability) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $id, $password, $name, $dept, $exp, $phone, $email, $avail);

    if ($stmt->execute()) {
        echo "<script>alert('Doctor added successfully!')<script>";
        header("Location: doctor_login.html");
       
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
mysqli_close($conn);
?>