<?php
$conn = mysqli_connect("localhost", "root", "", "admin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM doctor WHERE Status='pending'");
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['ID'];
    $sql = "DELETE FROM doctor WHERE ID='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Doctor rejected successfully!')</script>";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}