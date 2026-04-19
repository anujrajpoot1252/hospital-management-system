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
        body { font-family: Arial; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        .logout { float: right; padding: 10px 15px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Welcome Admin - Doctors Dashboard</h1>
    <a href="logout.php" class="logout">Logout</a>

    <h2>Doctors List</h2>
    <table>
        <tr>
           <th>ID</th>
           <th>Password</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Experience (Years)</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Availability</th>
        </tr>
        <?php
        $conn = mysqli_connect("localhost", "root", "", "Admin");
        $sql = "SELECT * FROM doctor";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['Password'] . "</td>";
                echo "<td>" . $row['Name'] . "</td>";
                echo "<td>" . $row['Department'] . "</td>";
                echo "<td>" . $row['Experience'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['Availability'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No doctors found in database.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
