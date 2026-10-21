<?php
$to = "muhammadzeeshan8055@gmail.com";
$subject = "Test Email";
$message = "This is a test email sent from PHP!";
$headers = "From: muhammadzeeshan8055@gmail.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Email sending failed.";
}
?>
