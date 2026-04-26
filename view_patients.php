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
    
    <title>view Patients</title>
    <body>
    <h1 style="text-align: center;">Patients List</h1>
    <table border="1" style="width: 80%; margin: auto; text-align: center;">
              <form method="GET" style="text-align:center; margin-bottom:20px;">
    <input type="text" name="search" placeholder="Search patient..." 
           value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
    <button type="submit">Search</button>
</form>
        <tr>
          
            <th>Name</th>
            <th>Email</th>
            <th>Age </th>
            <th>Phone</th>
            <th>Weight</th>
            <th>Height</th>
            <th>Blood_group</th>
            <th>Disease</th>
            <th>Medical History</th>
         
        </tr>
         <?php
        $conn = mysqli_connect("localhost", "root", "", "Admin");
        $sql = "SELECT * FROM patient_db";
        $result = mysqli_query($conn, $sql);
         $search = "%" . $_GET['search'] . "%";

$stmt = $conn->prepare("SELECT * FROM patient_db 
    WHERE Name LIKE ? OR Email LIKE ?");

$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();

       
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result))  {
            echo "<tr>
                  
                    <td>{$row['Name']}</td>
                    <td>{$row['Email']}</td>
                    <td>{$row['Age']}</td>
                    <td>{$row['Phone']}</td>
                    <td>{$row['Weight']}</td>
                    <td>{$row['height']}</td>
                    <td>{$row['Blood_group']}</td>
                    <td>{$row['disease']}</td>
                    <td>{$row['medical_history']}</td>
                    
                  </tr>";
        }
        } else {
            echo "<tr><td colspan='10'>No patients found</td></tr>";
        }
        ?>