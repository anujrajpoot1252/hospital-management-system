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
    <a href="admin_dashboard.php" style="display: block; text-align: center; margin-top: 20px; color: #3498db; text-decoration: none;"> Back to Admin</a>

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
