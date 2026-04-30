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
    margin: 0;
    font-family: Arial;
    background: #f4f6f9;
    text-align: center;
}

.header {
    padding: 20px;
}
    
.cards {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}

.card {
    width: 250px;
    background: white;
    padding: 20px;
    border-radius: 10px;
}

.card img {
    width: 80px;
    height: 80px;
    object-fit: contain;
}

.btn {
    display: inline-block;
    padding: 8px 15px;
    margin-top: 10px;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.blue { background: #007bff; }
.green { background: #28a745; }
.purple { background: #6f42c1; }
.red { background: #dc3545; }

</style>
</head>

<body>

<div class="header">
    <h1>Welcome Admin 👋</h1>
</div>

<div class="cards">

    <div class="card">
         <img src="https://img.freepik.com/premium-vector/doctor-icon-flat-vector-illustration_757387-939.jpg">
        <h3>Pending Requests</h3>
        <p>View and manage pending requests</p>
        <a href="pending_doctor.php" class="btn blue">View</a>
    </div>

    <div class="card">
        <img src="https://tse2.mm.bing.net/th/id/OIP.guvL8EaGRtvnNA3ggmc3DwAAAA?r=0&pid=ImgDet&w=206&h=206&c=7&o=7&rm=3">
        <h3>approve Doctors</h3>
        <p>view verify and  approve doctor registation requests</p>
        <a href="approve_doctors.php" class="btn green">View</a>
    </div>

    <div class="card">
        <img src="https://th.bing.com/th/id/OIP.p0aB6pKFgdcKoB1Q0Bp6IwHaHa?w=184&h=184&c=7&r=0&o=7&pid=1.7&rm=3">
        <h3>View Patients</h3>
        <p>Manage patients</p>
        <a href="view_patients.php" class="btn purple">View</a>
    </div>

    <div class="card">
        <img src="https://tse3.mm.bing.net/th/id/OIP.4UtNis_xGjmhFNrIBUxeZwHaHa?r=0&rs=1&pid=ImgDetMain&o=7&rm=3">
        <h3>Logout</h3>
        <p>Exit system</p>
        <a href="logout.php" class="btn red">Logout</a>
    </div>

</div>

</body>
</html>
