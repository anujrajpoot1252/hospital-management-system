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


$datetime = $_POST['appointment_time'] ?? '';
if ($datetime) {
    $datetime = date("Y-m-d H:i:s", strtotime($datetime));

} else {
    $datetime = '';
}
$appointment_time = htmlspecialchars($datetime);


/*  DISEASE → DEPARTMENT */
$disease_lower = strtolower($disease);

if (strpos($disease_lower, 'heart pain') !== false || strpos($disease_lower, 'chest pain') !== false || strpos($disease_lower, 'breathing') !== false || strpos($disease_lower, 'accident') !== false || strpos($disease_lower, 'bleeding') !== false || strpos($disease_lower, 'emergency') !== false || strpos($disease_lower, 'stroke') !== false || strpos($disease_lower, 'attack') !== false) {
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

$time_from = $doctor['TimeFrom'] ?? '';
$time_to = $doctor['TimeTo'] ?? '';

/* BOOK APPOINTMENT*/
$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_POST['doctor_id']) && !empty($_POST['appointment_time'])) {
        $doctor_id = $_POST['doctor_id'];
        
        // Standardize time format to Y-m-d H:i:s
        $appointment_time = date('Y-m-d H:i:s', strtotime($_POST['appointment_time']));

        // Validate time within doctor's available hours
        $appt_datetime = strtotime($appointment_time);
        $appt_time = date('H:i', $appt_datetime);
        $from_time = strtotime($time_from);
        $to_time = strtotime($time_to);

        if ($appt_time >= date('H:i', $from_time) && $appt_time <= date('H:i', $to_time)) {
            
            // Check if the time slot is already booked for this doctor (Slot Check)
            $check = $conn->prepare("SELECT id FROM appointment WHERE doctor_id = ? AND appointment_time = ? AND status = 'pending'");
            $check->bind_param("ss", $doctor_id, $appointment_time);
            $check->execute();
            $check_res = $check->get_result();

            if ($check_res->num_rows > 0) {
                $message = "Yeh time slot pehle se hi kisi aur patient ke liye booked hai. Kripya doosra time select karein! (This time slot is already booked for this doctor. Please select another time.)";
            } else {
                $disease_lower = strtolower($disease);
                $priority = "normal";

                // Fetch dynamic priorities from disease_priority table
                $prio_stmt = $conn->query("SELECT disease_name, priority FROM disease_priority");
                $priorities_list = [];
                while ($prow = $prio_stmt->fetch_assoc()) {
                    $priorities_list[] = $prow;
                }

                // Match high priority first
                foreach ($priorities_list as $item) {
                    if ($item['priority'] === 'high' && strpos($disease_lower, strtolower($item['disease_name'])) !== false) {
                        $priority = "high";
                        break;
                    }
                }

                // Match moderate priority second
                if ($priority === "normal") {
                    foreach ($priorities_list as $item) {
                        if ($item['priority'] === 'moderate' && strpos($disease_lower, strtolower($item['disease_name'])) !== false) {
                            $priority = "moderate";
                            break;
                        }
                    }
                }

                $insert = $conn->prepare("INSERT INTO appointment 
    (doctor_id, patient_email, name, age, gender, phone, disease, appointment_time, priority) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $insert->bind_param("sssisssss", 
                    $doctor_id, 
                    $email, 
                    $name, 
                    $age, 
                    $gender, 
                    $phone, 
                    $disease, 
                    $appointment_time,
                    $priority
                );

                if ($insert->execute()) {
                    $message = "Appointment booked successfully";
                } else {
                    $message = "Error booking appointment";
                }
            }
        } else {
            $message = "Selected time is not within doctor's available hours";
        }
    } else {
        $message = "Please select a valid time";
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

<div class="header">HOSPITAL MANAGEMENT SYSTEM<br>
<a href="patient_dashboard.php" class="back-link">← Back To Dashboard</a>
</div>

<div class="container">

<h2>Book Appointment</h2>

<p><b>Name:</b> <?php echo $name; ?></p>
<p><b>Email:</b> <?php echo $email; ?></p>
<p><b>Age:</b> <?php echo $age; ?></p>
<p><b>Gender:</b> <?php echo $gender; ?></p>
<p><b>Phone:</b> <?php echo $phone; ?></p>
<p><b>Disease:</b> <?php echo $disease; ?></p>

<hr>

<?php if($message != "") echo "<div class='msg'>$message</div>"; ?>

<?php if($doctor): ?>

<p><b>Recommended Department:</b> <?php echo $department; ?></p>

<p><b>Doctor Assigned:</b><br>
<?php echo $doctor['Name']; ?> (<?php echo $doctor['Department']; ?>)
</p>

<form method="POST">
    <p><b>Available Time:</b> <?php echo $time_from; ?> to <?php echo $time_to; ?></p>
   <?php
$today = date('Y-m-d');
?>

<input 
    type="datetime-local" 
    id="appointment_time" 
    name="appointment_time"

    min="<?php echo $today . 'T' . date('H:i', strtotime($time_from)); ?>"
    
    max="<?php echo date('Y-m-d', strtotime('+2 days')) . 'T' . date('H:i', strtotime($time_to)); ?>"
    
    required
><br><br>
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
