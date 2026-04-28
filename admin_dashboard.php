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
        <a href="pending_doctor.php" class="btn view">View Pending Doctors</a>
        <a href="approved_doctor.php" class="btn view">View Approved Doctors</a>
       
        <a href="view_doctors.php" class="btn view">View Doctors</a>
        <a href="view_patients.php" class="btn view">View Patients</a>
        <a href="logout.php" class="btn logout">Logout</a>
    </div>

  
   
</body>
</html>
