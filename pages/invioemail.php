<?php
$htmlContent = file_get_contents('emailfont.html');
$to = 'alessandrolombardi860@gmail.com';
$subject = 'pronto emergenza';
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: mattiapasinetti05@gmail.com\r\n";
mail($to, $subject, $htmlContent, $headers);
//mail('email@destinatario.it', 'oggetto della mail', 'contenuto del messaggio');
?>+
