<?php
$conn = mysqli_connect("localhost", "root", "", "admin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM doctor WHERE Status='pending'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Doctors</title>
</head>
<body>
    <h2>Pending Doctors</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Experience</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Availability</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['ID']; ?></td>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Department']; ?></td>
            <td><?php echo $row['Experience']; ?></td>
            <td><?php echo $row['Phone']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['Availability']; ?></td>
            <td><a href="approve_doctor.php?id=<?php echo $row['ID']; ?>">Approve</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>