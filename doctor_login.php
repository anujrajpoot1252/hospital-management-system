<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "admin");

$id = $_POST['id'];
$password = $_POST['password'];

$sql = "SELECT * FROM doctor WHERE ID=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $id, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $_SESSION['doctor_id'] = $row['ID'];  

    header("Location: doctor_dashboard.php");
} else {
    echo "Invalid login";
}
?>
