<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Agar login nahi hai toh redirect
if (!isset($_SESSION['email'])) {
    header("Location: patient_dashboard.html");
    exit();
}

$email = $_SESSION['Email'];

// Database connection
$conn = mysqli_connect("localhost", "root", "", "patient_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Data fetch
$sql = "SELECT * FROM patient WHERE email = '$Email'";
$result = mysqli_query($conn, $sql);


if (!$result) {
    die("Query failed: " . mysqli_error($conn));
    token_name(exif_imagetype($Email));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("No data found");
}

else {
    $email   = $row['Email'];
    $age    = $row['Age'];
    $gender = $row['gender'];
    $weight = $row['Weight'];
    $blood_group = $row['Blood_Group'];
    $disease = $row['disease'];
    $history = $row['medical_History'];
  
}


$stmt = $conn->prepare("SELECT * FROM patient WHERE email = ?");
$stmt->bind_param("s", $email);
if ($stmt) {
    $stmt->execute();
}
else {
    echo "statemrntent preparation failed: " . $conn->error;
}

 if ($stmt->execute()) {
        echo "<script>
                alert('logout successful!');
                window.location.href = 'patient_dashboard.html';
              </script>";
    } else {
        echo "<script>alert('Logout mein error aa gaya. Dobara try karo.');</script>";
    }

    $stmt->close();

mysqli_close($conn);
?>