<?php
$conn = mysqli_connect("localhost", "root", "", "admin");   
$id = $_GET['id'];
$sql = "UPDATE doctor SET Status='approved' WHERE ID='$id'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Doctor approved successfully!')</script>";
    header("Location: admin_dashboard.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>