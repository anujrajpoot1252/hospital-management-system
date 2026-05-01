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

// Success message
if (isset($_GET['success'])) {
    echo "<p style='color:green; font-size:18px;'> Doctor Approved Successfully!</p>";
}

$sql = "SELECT * FROM doctor WHERE status='pending'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Doctors</title>
   
</head>
<body>
    <h2>Pending Doctors</h2>
    <a href="admin_dashboard.php">⬅ Back to Dashboard</a><br><br>

    <?php if (mysqli_num_rows($result) > 0) { ?>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Department</th>
            <th>Experience</th><th>Phone</th><th>Email</th>
            <th>Availability</th><th>Action</th>
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
            <td>
                <a href="approve_doctor.php?id=<?php echo $row['ID']; ?>" 
                   class="approve-btn"
                   onclick="return confirm('Approve this doctor?')"> Approve </a>
                  &nbsp;
                <a href="reject_doctor.php?id=<?php echo $row['ID']; ?>" 
                   class="reject-btn"
                   onclick="return confirm('Reject this doctor?')"> Reject </a>
            </td>
        </tr>
        <?php } ?>  
    </table>
    <?php } else { ?>
        <p class="no-data">No pending doctors found.</p>
    <?php } ?>
</body>
</html>
