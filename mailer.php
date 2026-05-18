<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Linking files
require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

function sendHMSMail($to, $subject, $message) {
    $mail = new PHPMailer(true);

    // yaha apni detail dalni hai//
    $myEmail = 'anujrajpoot1252@gmail.com'; 
    $appPass = 'gqga uuix ccvw wbai'; // 16 digt ka pass//

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $myEmail;
        $mail->Password   = $appPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom($myEmail, 'Hospital Management System');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<html><body>$message</body></html>";

        $mail->send();
        file_put_contents(__DIR__ . "/mailer_log.txt", "[" . date("Y-m-d H:i:s") . "] SUCCESS: OTP sent to $to\n", FILE_APPEND);
        return true;
    } catch (Exception $e) {
        file_put_contents(__DIR__ . "/mailer_log.txt", "[" . date("Y-m-d H:i:s") . "] ERROR: {$mail->ErrorInfo}\n", FILE_APPEND);
        return false;
    }
}
?>
