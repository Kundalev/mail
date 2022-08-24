<?php

use App\DB;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'mail.shamanmedia.by';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'info@shamanmedia.by';                     //SMTP username
    $mail->Password = '5MWVe#8(Rakn';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('info@shamanmedia.by', 'CRON Info');
    $mail->addAddress('maksis175@gmail.com', 'Max');     //Add a recipient
    $allMessages = DB::getAll("SELECT * FROM `mails`");
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Statistic';
    $mail->Body = 'Отпрвленных сообщений: ' . count($allMessages);
    $mail->AltBody = $_POST['email'] . ' ' . $_POST['name'] . ' ' . $_POST['message'];


    $mail->send();
    echo 'Message has been sent';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

print_r($allMessages);