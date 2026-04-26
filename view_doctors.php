<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "Admin");

$search = "%";
if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = "%" . $_GET['search'] . "%";
}

$stmt = $conn->prepare("SELECT * FROM doctor 
    WHERE Name LIKE ? 
    OR Department LIKE ? 
    OR Email LIKE ? 
    OR Phone LIKE ?");

$stmt->bind_param("ssss", $search, $search, $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Doctors</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f7fb;
        margin: 0;
        padding: 0;
    }

    h1 {
        margin-top: 20px;
        color: #2c3e50;
        font-size: 28px;
        letter-spacing: 1px;
    }

    form {
        margin: 20px auto;
    }

    input[type="text"] {
        width: 300px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
    }

    input[type="text"]:focus {
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    button {
        padding: 10px 18px;
        border: none;
        background: #3498db;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        margin-left: 5px;
        transition: 0.3s;
    }

    button:hover {
        background: #2980b9;
    }

    table {
        border-collapse: collapse;
        width: 90%;
        margin: 30px auto;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    th {
        background: #3498db;
        color: white;
        padding: 12px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #333;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

    tr:hover {
        background: #eef6ff;
        transition: 0.2s;
    }
</style>
</head>
<a href="admin_dashboard.php" style="display: block; text-align: center; margin-top: 20px; color: #3498db; text-decoration: none;"> Back to Admin</a>

<body>

<h1 style="text-align: center;">Doctors List</h1>

<!-- SEARCH FORM (fixed placement) -->
<form method="GET" style="text-align:center; margin-bottom:20px;">
    <input type="text" name="search" placeholder="Search doctor..."
        value="<?php if(isset($_GET['search'])) echo htmlspecialchars($_GET['search']); ?>">
    <button type="submit">Search</button>
</form>

<table border="1" style="width: 80%; margin: auto; text-align: center;">
    <tr>
        <th>ID</th>
        <th>Password</th>
        <th>Name</th>
        <th>Department</th>
        <th>Experience</th>
        <th>Availability</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['ID']}</td>
                <td>{$row['Password']}</td>
                <td>{$row['Name']}</td>
                <td>{$row['Department']}</td>
                <td>{$row['Experience']}</td>
                <td>{$row['Availability']}</td>
                <td>{$row['Email']}</td>
                <td>{$row['Phone']}</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No doctors found</td></tr>";
    }
    ?>

</table>

</body>
</html>
