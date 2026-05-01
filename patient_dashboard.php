<?php
session_start();

// Correct session check
if (!isset($_SESSION['patient_email'])) {
    header("Location:  patient_login.html");
    exit();
}

$email = $_SESSION['patient_email'];

// Database connection
$conn = mysqli_connect("localhost", "root", "", "admin");

if (!$conn) {
    die("Connection failed");
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM patient_db WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("No data found");
}

// Assign data safely
$name = htmlspecialchars($row['Name'] ?? '');
$age = htmlspecialchars($row['Age'] ?? '');
$gender = htmlspecialchars($row['gender'] ?? '');
$phone = htmlspecialchars($row['Phone'] ?? '');
$weight = htmlspecialchars($row['Weight'] ?? '');
$height = htmlspecialchars($row['height'] ?? '');
$blood_group = htmlspecialchars($row['Blood_group'] ?? '');
$disease = htmlspecialchars($row['disease'] ?? '');
$history = htmlspecialchars($row['medical_history'] ?? '');
$photo = htmlspecialchars($row['photo'] ?? '');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="style.css">  
</head>

<body>

<div class="header">
    <h2>HOSPITAL MANAGEMENT SYSTEM</h2>
</div>
<div class="dashboard-container" style="position: relative; padding: 20px;">

    <h2>Welcome <?php echo $name; ?></h2>

    <!-- Profile Photo Top Right -->
    <?php if ($photo): ?>
        <img src="<?php echo $photo; ?>" 
             style="position:absolute; top:50px; right:20px; width:90px; height:100px;  object-fit:cover;">
    <?php else: ?>
        <img src="uploads"
             style="position:absolute; top:50px; right:20px; width:90px; height:100px; object-fit:cover;">
    <?php endif; ?>

    <p>Email: <b><?php echo $email; ?></b></p>
    <p>Age: <b><?php echo $age; ?></b></p>
    <p>Gender: <b><?php echo $gender; ?></b></p>
    <p>Phone: <b><?php echo $phone; ?></b></p>
    <p>Weight: <b><?php echo $weight; ?></b></p>
    <p>Height: <b><?php echo $height; ?> cm</b></p>
    <p>Blood Group: <b><?php echo $blood_group; ?></b></p>
    <p>Disease: <b><?php echo $disease; ?></b></p>
    <p>Medical History: <b><?php echo $history; ?></b></p>

    <a href="patient_appointment.php">Book Appointment</a>
    <button class="btn btn-primary" onclick="alert('Reports coming soon')">View Reports</button>

    <a href="logout.php">
        <button class="btn-danger">Logout</button>
    </a>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
