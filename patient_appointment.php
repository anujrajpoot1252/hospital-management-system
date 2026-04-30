<?php
session_start();

if (!isset($_SESSION['patient_email'])) {
    header("Location: patient_login.html");
    exit();
}

$email = $_SESSION['patient_email'];

$conn = mysqli_connect("localhost", "root", "", "admin");
if (!$conn) {
    die("Connection failed");
}


  /* PATIENT DATA */

$stmt = $conn->prepare("SELECT * FROM patient_db WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$name = htmlspecialchars($row['Name'] ?? '');
$age = htmlspecialchars($row['Age'] ?? '');
$gender = htmlspecialchars($row['gender'] ?? '');
$phone = htmlspecialchars($row['Phone'] ?? '');
$disease = htmlspecialchars($row['disease'] ?? '');


/*  DISEASE → DEPARTMENT */
$disease_lower = strtolower($disease);

if (strpos($disease_lower, 'heart') !== false) {
    $department = "Cardiology";
} elseif (strpos($disease_lower, 'skin') !== false) {
    $department = "Dermatology";
} elseif (strpos($disease_lower, 'eye') !== false) {
    $department = "Ophthalmology";
} elseif (strpos($disease_lower, 'bone') !== false) {
    $department = "Orthopedic";
} else {
    $department = "General";
}


/*FETCH DOCTOR*/
$doc_stmt = $conn->prepare("SELECT * FROM doctor WHERE Department = ? LIMIT 1");
$doc_stmt->bind_param("s", $department);
$doc_stmt->execute();
$doctor_result = $doc_stmt->get_result();
$doctor = $doctor_result->fetch_assoc();


/* BOOK APPOINTMENT*/
$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_POST['doctor_id'])) {
        $doctor_id = $_POST['doctor_id'];

       $insert = $conn->prepare("INSERT INTO appointment 
(doctor_id, patient_email, name, age, gender, phone, disease) 
VALUES (?, ?, ?, ?, ?, ?, ?)");

$insert->bind_param("sssisss", 
    $doctor_id, 
    $email, 
    $name, 
    $age, 
    $gender, 
    $phone, 
    $disease
);

        if ($insert->execute()) {
            $message = "Appointment booked successfully";
        } else {
            $message = "Error booking appointment";
        }
    } else {
        $message = "Doctor not available";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Appointment</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #eef2f7;
    margin: 0;
}

.header {
    background: #3498db;
    color: white;
    text-align: center;
    padding: 15px;
    font-size: 20px;
}

.container {
    width: 400px;
    margin: 40px auto;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    color: #2c3e50;
}

p {
    margin: 8px 0;
}

button {
    width: 100%;
    padding: 10px;
    margin-top: 15px;
    border: none;
    background: #3498db;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background: #2980b9;
}

.msg {
    text-align: center;
    margin-top: 10px;
    color: green;
    font-weight: bold;
}
</style>

</head>

<body>

<div class="header">HOSPITAL MANAGEMENT SYSTEM</div>

<div class="container">

<h2>Book Appointment</h2>

<p><b>Name:</b> <?php echo $name; ?></p>
<p><b>Email:</b> <?php echo $email; ?></p>
<p><b>Age:</b> <?php echo $age; ?></p>
<p><b>Gender:</b> <?php echo $gender; ?></p>
<p><b>Phone:</b> <?php echo $phone; ?></p>
<p><b>Disease:</b> <?php echo $disease; ?></p>

<?php if($message != "") echo "<div class='msg'>$message</div>"; ?>

<hr>

<?php if($doctor): ?>

<p><b>Recommended Department:</b> <?php echo $department; ?></p>

<p><b>Doctor Assigned:</b><br>
<?php echo $doctor['Name']; ?> (<?php echo $doctor['Department']; ?>)
</p>

<form method="POST">
    <input type="hidden" name="doctor_id" value="<?php echo $doctor['ID']; ?>">
    <button type="submit">Book Appointment</button>
</form>

<?php else: ?>

<p style="color:red;">No doctor available</p>

<?php endif; ?>

</div>

</body>
</html>

<?php
$conn->close();
?>