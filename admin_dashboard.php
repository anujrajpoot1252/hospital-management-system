<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();


if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Admin Dashboard</title>
    <style>
   body {
            font-family: Arial;
            background: #f5f5f5;
            margin: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .add { background: green; }
        .view { background: green; }
        .logout { background: red; }


        .box {
            background: white;
            padding: 15px;
            margin-top: 20px;
            width: 300px;
            border-radius: 5px;
        }

        select, button {
            padding: 6px;
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Welcome Admin</h1>
    <div class="top-bar">
        <a href="add_doctor.php" class="btn add">Add Doctor</a>
        <a href="view_doctors.php" class="btn view">View Doctors</a>
        <a href="view_patients.php" class="btn view">View Patients</a>
        <a href="logout.php" class="btn logout">Logout</a>
    </div>

  
    <select name="doctor_id">
        <option value="">-- Select Doctor --</option>
   
        <?php
        $conn = mysqli_connect("localhost", "root", "", "Admin");
        $sql = "SELECT * FROM doctor";
        $result = mysqli_query($conn, $sql);

       
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['ID']."'>";
                echo $row['ID']." - ".$row['Name']." (".$row['Department'].")";
                echo "</option>";
            }
        } else {
            echo "<option>No doctors found</option>";
        }
        ?>
    </select>
</body>
</html>
