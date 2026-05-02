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
    echo "<p style='color:green; font-size:18px; text-align:center;'> Doctor Approved Successfully!</p>";
}

$sql = "SELECT * FROM doctor WHERE status='pending'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pending Doctors</title>

<style>
/* Reset */
* {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* Header */
.header {
    background-color: #00bfff;
    color: white;
    text-align: center;
    padding: 20px;
}

/* Back button */
.back-link {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background-color: white;
    color: #00bfff;
    text-decoration: none;
    border-radius: 5px;
}

.back-link:hover {
    background-color: #e0f7ff;
}

/* Container */
.container {
    width: 90%;
    margin: 30px auto;
}

/* Table Box */
.table-wrapper {
    background-color: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background-color: #f0f0f0;
    padding: 12px;
    text-align: left;
}

td {
    padding: 12px;
    border-bottom: 1px solid #ccc;
}

/* Buttons */
.approve-btn, .reject-btn {
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 4px;
    color: white;
    font-size: 14px;
}

.approve-btn {
    background-color: #28a745;
}

.approve-btn:hover {
    background-color: #1e7e34;
}

.reject-btn {
    background-color: #dc3545;
}

.reject-btn:hover {
    background-color: #a71d2a;
}

/* No data */
.no-data {
    text-align: center;
    font-size: 18px;
    margin-top: 20px;
}
</style>

</head>

<body>

<div class="header">
    <h1>Hospital Management System</h1>
    <h2>Pending Doctor Requests</h2>
    <a href="admin_dashboard.php" class="back-link">← Back To Dashboard</a>
</div>

<div class="container">
<div class="table-wrapper">

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
               onclick="return confirm('Approve this doctor?')">Approve</a>

            <a href="reject_doctor.php?id=<?php echo $row['ID']; ?>" 
               class="reject-btn"
               onclick="return confirm('Reject this doctor?')">Reject</a>
        </td>
    </tr>
    <?php } ?>  
</table>

<?php } else { ?>
    <p class="no-data">No pending doctors found.</p>
<?php } ?>

</div>
</div>

</body>
</html>
