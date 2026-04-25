<?php
session_start();

// Correct session check
if (!isset($_SESSION['patient_email'])) {
    header("Location:  patient_login.html");
    exit();
}

$email = $_SESSION['patient_email'];

// Database connection
$conn = mysqli_connect("localhost", "root", "", "patient_db");

if (!$conn) {
    die("Connection failed");
}

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM patient WHERE Email = ?");
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
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #d3d3d3;
}

/* Header */
header {
    background-color: #3b82f6;
    color: white;
    text-align: center;
    padding: 20px;
    font-size: 26px;
    font-weight: bold;
}

/* Dashboard Container */
.dashboard-container {
    width: 350px;
    margin: 50px auto;   /* center horizontally */
    background-color: #66d1c7;
    padding: 20px;
    border-radius: 10px;
    text-align: left;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
}

/* Welcome Title */
.dashboard-container h2 {
    text-align: center;
    color: #1e3a8a;
    margin-bottom: 15px;
}

/* Text Styling */
.dashboard-container p {
    margin: 5px 0;
    font-size: 14px;
}

/* Image */
.dashboard-container img {
    display: block;
    margin: 10px auto;
    border-radius: 8px;
}

/* Links & Buttons */
.dashboard-container a {
    text-decoration: none;
}

/* Book Appointment Link */
.dashboard-container a:first-of-type {
    color: red;
    display: block;
    text-align: center;
    margin: 10px 0;
    font-weight: bold;
}

/* Buttons */
button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
    margin-top: 10px;
}

/* View Reports Button */
.btn-primary {
    background-color: #1d4ed8;
    color: white;
}

/* Logout Button */
.btn-danger {
    background-color: red;
    color: white;
}

    </style>
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
    <p>Height: <b><?php echo $height; ?></b></p>
    <p>Blood Group: <b><?php echo $blood_group; ?></b></p>
    <p>Disease: <b><?php echo $disease; ?></b></p>
    <p>Medical History: <b><?php echo $history; ?></b></p>

    <a href="patient_appointment.html">Book Appointment</a>
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
