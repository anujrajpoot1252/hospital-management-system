<?php
// LANGUAGE 4: PHP
// logout.php - Session destroy karo
session_start();
session_destroy();
header("Location: doctor_login.html");
exit();
?>