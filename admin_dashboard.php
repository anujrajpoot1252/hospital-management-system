<?php
session_start();

if (!isset($_SESSION['admin_email'])) {
    header("Location: admin.html");
    exit();
}

$admin_email = $_SESSION['admin_email'];

$conn = mysqli_connect("localhost", "root", "", "Admin");
if (!$conn) {
    die("Connection failed");
}

$result = mysqli_query($conn, "SELECT Name, Specialization, Experience, Email, Phone FROM doctor ORDER BY Name ASC");
?>
<!DOCTYPE html>
<html>  
<head>
    <title>Admin Dashboard</title>
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
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0097a7;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, Admin!</h1>
        <a href="logout.php" style="color: white; float: right; margin-top: -40px;">Logout</a>
    </header>

    <div class="dashboard-container">
        <h2>Doctor List</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Specialization</th>
                <th>Experience (Years)</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Name']); ?></td>
                    <td><?php echo htmlspecialchars($row['Specialization']); ?></td>
                    <td><?php echo htmlspecialchars($row['Experience']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo htmlspecialchars($row['Phone']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
