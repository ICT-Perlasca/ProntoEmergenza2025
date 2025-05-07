<?php
function inviaEmail($titolo,$testo,$destinatario,$oggetto,$mittente) {

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: " . $mittente . "\r\n";

    $template = file_get_contents('templateEmail.html');

    $body = str_replace("{{Titolo}}", $titolo, $template);
    $body = str_replace("{{Testo}}", $testo, $body);

    return mail($destinatario, $oggetto, $body, $headers);
}
?>
