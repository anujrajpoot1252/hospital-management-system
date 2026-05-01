<?php
$conn = mysqli_connect("localhost", "root", "", "Admin");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add'])) {
    $id        = trim($_POST['id']);
    $password  = trim($_POST['password']);
    $name      = trim($_POST['name']);
    $dept      = trim($_POST['dept']);
    $exp       = intval($_POST['exp']);
    $phone     = trim($_POST['phone']);
    $email     = trim($_POST['email']);
    $avail     = $_POST['avail'];
    $time_from = $_POST['time_from'];
    $time_to   = $_POST['time_to'];

    $stmt = $conn->prepare(
        "INSERT INTO doctor (ID, Password, Name, Department, Experience, Phone, Email, Availability, TimeFrom, TimeTo)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssssisssss", $id, $password, $name, $dept, $exp, $phone, $email, $avail, $time_from, $time_to);

    if ($stmt->execute()) {
        $stmt->close();
        mysqli_close($conn);
        // Redirect BEFORE any output
        echo "<script>alert('Doctor registered successfully!'); window.location.href='doctor_login.html';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "');</script>";
        $stmt->close();
    }
}

mysqli_close($conn);
?>
