<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\DB;

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
    $mail->setFrom('info@shamanmedia.by', 'Mailerr');
    $mail->addAddress('maksis175@gmail.com', 'Joe User');     //Add a recipient


    //Attachments
    if (!empty($_FILES['userfile']['name'][0])) {
        for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {
            $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['userfile']['name'][$ct]));

            $explode = explode('.', $_FILES['userfile']['name'][0]);
            $count = count($explode) - 1;
            $filename = 'CV.' . $explode[$count];
            if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
                $mail->addAttachment($uploadfile, $filename);
            } else {
                die();
            }
        }
    }
    /*$mail->addAttachment( 'new.jpg');    //Optional name*/

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->msgHTML('
        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
<header style="background: black">
    <h1 style="color: white; text-align: center">Тестовое письмо</h1>
</header>
<section>
    <h3 style="text-align: center">Привет {{name}}</h3>
    <p style="text-align: center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias eveniet excepturi expedita nisi nostrum, saepe
        veritatis? Excepturi harum minima officia ratione sed! Assumenda consequuntur, cumque eligendi repudiandae totam
        veritatis voluptates.</p>
       <img src=«file:///home/max/www/test3.localhost/public_html/public/img/nastol.com.ua-218332.jpg»>
</section>
<footer style="background: black">
    <h5 style="color: white; text-align: center">Какой-то футер</h5>
</footer>
</body>
</html>
    ');
    $mail->AltBody = $_POST['email'] . ' ' . $_POST['name'] . ' ' . $_POST['message'];

    $mail->send();
    DB::add("INSERT INTO `mails` SET `name` = :name, email = :email, message = :message",
        [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'message' => $_POST['message']
        ]);
    echo 'Message has been sent';

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}