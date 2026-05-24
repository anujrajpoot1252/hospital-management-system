<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.html"); 
    exit();
}

$doctor_id = $_SESSION['doctor_id'];


// AUTOMATIC TIMING EXCHANGE LOGIC (Priority Based per day)

$dates_stmt = $conn->prepare("SELECT DISTINCT DATE(appointment_time) as app_date FROM appointment WHERE doctor_id = ? AND status = 'pending'");
$dates_stmt->bind_param("s", $doctor_id);
$dates_stmt->execute();
$dates_res = $dates_stmt->get_result();

while ($date_row = $dates_res->fetch_assoc()) {
    $app_date = $date_row['app_date'];
    
    // Fetch pending appointments for this date, sorted by priority and age
    $day_stmt = $conn->prepare("SELECT id, appointment_time FROM appointment WHERE doctor_id = ? AND status = 'pending' AND DATE(appointment_time) = ? ORDER BY FIELD(priority, 'high', 'moderate', 'normal'), age DESC, appointment_time ASC");
    $day_stmt->bind_param("ss", $doctor_id, $app_date);
    $day_stmt->execute();
    $day_res = $day_stmt->get_result();
    
    $app_ids = [];
    $app_times = [];
    
    while ($row = $day_res->fetch_assoc()) {
        $app_ids[] = $row['id'];
        $app_times[] = strtotime($row['appointment_time']);
    }
    
    // Sort times from earliest to latest
    sort($app_times);
    
    // Re-assign the earliest times to the highest priority patients
    for ($i = 0; $i < count($app_ids); $i++) {
        $new_time = date('Y-m-d H:i:s', $app_times[$i]);
        $upd = $conn->prepare("UPDATE appointment SET appointment_time = ? WHERE id = ?");
        $upd->bind_param("si", $new_time, $app_ids[$i]);
        $upd->execute();
    }
}

$stmt = $conn->prepare("SELECT * FROM appointment WHERE doctor_id = ? ORDER BY FIELD(priority, 'high', 'moderate', 'normal'), age DESC, appointment_time ASC");

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
        <th>Priority</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['doctor_id']; ?></td>
        <td><?php echo htmlspecialchars($row['patient_email']); ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['age']); ?></td>
        <td><?php echo htmlspecialchars($row['gender']); ?></td>
        <td><?php echo htmlspecialchars($row['phone']); ?></td>   
        <td><?php echo htmlspecialchars($row['disease']); ?></td> 
        <td>
            <?php 
                $pri = strtolower($row['priority'] ?? 'normal');
                if($pri == 'high') echo '<span style="color:red; font-weight:bold;">High</span>';
                elseif($pri == 'moderate') echo '<span style="color:orange; font-weight:bold;">Moderate</span>';
                else echo '<span style="color:green; font-weight:bold;">Normal</span>';
            ?>
        </td>
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
