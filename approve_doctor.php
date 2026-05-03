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

<style>

* {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.header {
    background-color: #00bfff;
    color: white;
    text-align: center;
    padding: 20px;
}

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

.container {
    width: 90%;
    margin: 30px auto;
}

.table-wrapper {
    background-color: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

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
    <h2>Approved Doctors</h2>
    <a href="admin_dashboard.php" class="back-link">← Back To Dashboard</a>
</div>

<div class="container">
<div class="table-wrapper">

<?php if (mysqli_num_rows($result) > 0) { ?>

<table>
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
<p class="no-data">No approved doctors found.</p>
<?php } ?>

</div>
</div>

</body>
</html>
