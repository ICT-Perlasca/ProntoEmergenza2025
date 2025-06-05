<?php
require_once("../globals.php");

function inviaEmail($titolo,$testo,$destinatario,$oggetto,$mittente) {
global $logo_email;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: " . $mittente . "\r\n";

    $template = file_get_contents('../api/templateEmail.html');
    $template=str_replace("{{logo_email_and_server}}",$logo_email,$template);
    $body = str_replace("{{Titolo}}", $titolo, $template);
    $body = str_replace("{{Testo}}", $testo, $body);

    return mail($destinatario, $oggetto, $body, $headers);

}
?>
