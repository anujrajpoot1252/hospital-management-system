<?php
$conn = mysqli_connect("localhost", "root", "", "Admin");

if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $dept = $_POST['dept'];
    $exp = $_POST['exp'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $avail = $_POST['avail'];

    $sql = "INSERT INTO doctor (Name, Department, Experience, Phone, Email, Availability)
            VALUES ('$name','$dept','$exp','$phone','$email','$avail')";

    mysqli_query($conn, $sql);

    header("Location: admin_dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Doctor</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
        }

        .container {
            width: 350px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
        }

        h2 {
            text-align: center;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
        }

        .lang input {
            width: auto;
            margin-right: 5px;
        }

        .time-group {
            display: flex;
            gap: 10px;
        }

        .time-group input {
            width: 100%;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkgreen;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Add Doctor</h2>

        <form method="POST">

            <label>ID:</label>
            <input type="text" name="id" placeholder="Enter ID">

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter Password">

            <label>Doctor Name:</label>
            <input type="text" name="name" placeholder="Enter name">

            <label>Specialization:</label>
            <input type="text" name="dept" placeholder="e.g. Cardiology">

            <label>Experience (Years):</label>
            <input type="number" name="exp" placeholder="e.g. 5">

            <label>Phone:</label>
            <input type="text" name="phone" placeholder="Enter phone number">

            <label>Email:</label>
            <input type="email" name="email"  placeholder="Enter email">

            <label>Availability:</label>
            <select name="avail">
                <option>Morning</option>
                <option>Evening</option>
                <option>Full Day</option>
            </select>

            <label>Timing:</label>
            <div class="time-group">
                <input type="time"> 
                <input type="time">
            </div>

          

            <button type="submit">Add Doctor</button>
        </form>
    </div>

</body>
</html>