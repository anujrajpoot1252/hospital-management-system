<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.html"); 
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

$stmt = $conn->prepare("SELECT * FROM appointment WHERE doctor_id = ?");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// use string instead of integer
$stmt->bind_param("s", $doctor_id);

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Doctor Dashboard</title>

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
.title {
    text-align: center;
    margin-bottom: 15px;
    font-size: 22px;
}
.no-data {
    text-align: center;
    font-size: 18px;
    padding: 20px;
}
</style>

</head>

<body>

<div class="header">
    <h1>Doctor Dashboard</h1>
    <a href="logout.php" style="color: red; text-decoration: none; position: absolute; top: 20px; right: 20px;">Logout</a>
</div>

<div class="container">
<div class="table-wrapper">

<div class="title">
<?php
if ($result->num_rows > 0) {
    echo "Appointments";
} else {
    echo "No Appointments Found";
}
?>
</div>

<?php if ($result->num_rows > 0) { ?>

<table>
    <tr>
        <th>ID</th>
        <th>Patient Email</th>
        <th>Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Disease</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['patient_email']); ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['age']); ?></td>
        <td><?php echo htmlspecialchars($row['gender']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>   
        <td><?php echo htmlspecialchars($row['disease']); ?></td> 
        <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
        <td>
            <span style="padding: 4px 8px; border-radius: 4px; color: white; background: <?php 
                echo ($row['status'] == 'completed') ? '#28a745' : (($row['status'] == 'cancelled') ? '#dc3545' : '#ffc107'); 
            ?>;">
                <?php echo ucfirst($row['status']); ?>
            </span>
        </td>
        <td>
            <?php if($row['status'] == 'pending'): ?>
                <a href="update_appointment.php?id=<?php echo $row['id']; ?>&status=completed" 
                   style="color: green; text-decoration: none; font-weight: bold; margin-right: 10px;"
                   onclick="return confirm('Mark as completed?')">✔ Complete</a>
                
                <a href="update_appointment.php?id=<?php echo $row['id']; ?>&status=cancelled" 
                   style="color: red; text-decoration: none; font-weight: bold;"
                   onclick="return confirm('Cancel this appointment?')">✖ Cancel</a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php } ?>

</table>

<?php } else { ?>
    <div class="no-data">No appointments available</div>
<?php } ?>

</div>
</div>

</body>
</html>