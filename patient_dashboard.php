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
$blood_group = htmlspecialchars($row['Blood_Group'] ?? '');
$disease = htmlspecialchars($row['disease'] ?? '');
$history = htmlspecialchars($row['medical_History'] ?? '');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
        }

        header {
            background-color: #0097a7;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #75f7f0;
            border-radius: 8px;
        }

        .btn {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: red;
            color: white;
        }
    </style>
</head>

<body>

<header>
    <h2>HOSPITAL MANAGEMENT SYSTEM</h2>
</header>

<div class="dashboard-container">
    <h2>Welcome <?php echo $name; ?></h2>

    <p>Email: <b><?php echo $email; ?></b></p>
    <p>Age: <b><?php echo $age; ?></b></p>
    <p>Gender: <b><?php echo $gender; ?></b></p>
    <p>Phone: <b><?php echo $phone; ?></b></p>
    <p>Weight: <b><?php echo $weight; ?></b></p>
    <p>Blood Group: <b><?php echo $blood_group; ?></b></p>
    <p>Disease: <b><?php echo $disease; ?></b></p>
    <p>Medical History: <b><?php echo $history; ?></b></p>

    <button class="btn btn-primary" onclick="alert('Appointment coming soon')">Book Appointment</button>
    <button class="btn btn-primary" onclick="alert('Reports coming soon')">View Reports</button>

    <a href="logout.php">
        <button class="btn btn-danger">Logout</button>
    </a>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
