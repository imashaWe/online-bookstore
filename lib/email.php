<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'core/config.php';

define("sender", $_CONFIG['EMAIL']['sender_mail']);
define("sender_name", $_CONFIG['EMAIL']['sender_name']);

define("smtp_host", $_CONFIG['EMAIL']['smtp_host']);
define("smtp_port", $_CONFIG['EMAIL']['smtp_port']);
define("smtp_username", $_CONFIG['EMAIL']['smtp_username']);
define("smtp_password", $_CONFIG['EMAIL']['smtp_password']);

function send_mail($to, $subject, $body, $body_text)
{

    $mail = new PHPMailer(true);

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = smtp_username;
        $mail->Password = smtp_password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = smtp_port;

        //Recipients
        $mail->setFrom(sender, sender_name);
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $body_text;

        $mail->send();
        return 1;
        // echo 'Message has been sent';
    } catch (Exception $e) {
        return 0;
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


