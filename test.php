<?php
include "lib/email.php";
$name = "Imasha";
$code = "1234";
$email= "imasha98.we@gmail.com";
$template = file_get_contents('email-templates/user-verify.html');
$template = str_replace("{CUSTOMER_NAME}", $name, $template);
$template = str_replace("{CODE}", $code, $template);
send_mail($email, "Verify your Email Address", $template, "Your verify code {$code}");
// send_mail("imasha98.we@gmail.com","New Text","Hellow","Hello");