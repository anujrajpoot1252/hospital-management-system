<?php
require_once 'mailer.php';

echo "Testing OTP Email...<br>";
if (sendHMSMail('anujrajpoot1252@gmail.com', 'Test Email', 'Aapka OTP system ab working hai!')) {
    echo "<h3>SUCCESS! Email has been sent to your mobile.</h3>";
} else {
    echo "<h3>FAILED! Please check mailer_log.txt for errors.</h3>";
}
?>
