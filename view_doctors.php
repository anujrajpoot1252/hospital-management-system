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
</head>

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