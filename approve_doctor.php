<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "admin");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("UPDATE doctor SET status='approved' WHERE ID=? AND status='pending'");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);

        header("Location: pending_doctor.php?success=1");
        exit();

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid Doctor ID";
}

$sql = "SELECT * FROM doctor WHERE status='approved'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Approved Doctors</title>
</head>
<body>

<h2>Approved Doctors</h2>
<a href="admin_dashboard.php">⬅ Back to Dashboard</a><br><br>

<?php if (mysqli_num_rows($result) > 0) { ?>
<table border="1" cellpadding="10">
<tr>
<th>ID</th>
<th>Name</th>
<th>Department</th>
<th>Experience</th>
<th>Phone</th>
<th>Email</th>
<th>Availability</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo htmlspecialchars($row['ID']); ?></td>
<td><?php echo htmlspecialchars($row['Name']); ?></td>
<td><?php echo htmlspecialchars($row['Department']); ?></td>
<td><?php echo htmlspecialchars($row['Experience']); ?></td>
<td><?php echo htmlspecialchars($row['Phone']); ?></td>
<td><?php echo htmlspecialchars($row['Email']); ?></td>
<td><?php echo htmlspecialchars($row['Availability']); ?></td>
</tr>
<?php } ?>

</table>
<?php } else { ?>
<p>No approved doctors found.</p>
<?php } ?>

</body>
</html>
