<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__.'/../PHPMailer/src/Exception.php';
require __DIR__.'/../PHPMailer/src/PHPMailer.php';
require __DIR__.'/../PHPMailer/src/SMTP.php';


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'twitterclonecompany@gmail.com';        // SMTP username
    $mail->Password   = '1q2w3e4rzxc';                          // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;

    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    //Recipients
    $mail->setFrom('twitterclonecompany@gmail.com', 'Twitter Clone');
    // $mail->addAddress($_POST['userEmail'] ?? 'mariaa.stefaniaa123@gmail.com' , $_POST['userProfileName']);
    $mail->addAddress('mariaa.stefaniaa123@gmail.com' , $_POST['userProfileName']);

    $mail->isHTML(true);
    $mail->Subject = 'Verify User';
    $_POST['userProfileName'] = $_POST['userProfileName'] ?? 'User Name';

    $mail->Body =
'<p>Welcome ' . '<b>'. $_POST['userProfileName']. '</b>' .' to Twitter Clone. </p>'.
'<p>Click on the link to verify your account: '.
'<a href="http://localhost/db-exam-twitter/api/api-verification-code.php?user_id='.$lastInsertedUserId.'&verification_code='.$verificationCode.'" target="_blank">'.$lastInsertedUserId.'&'.$verificationCode.'</a>'
.'</p>';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}