<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titoloUtente = $_POST["titolo"];
    $testoUtente = $_POST["testo"];
    $to = $_POST["destinatario"];
    $subject = $_POST["oggetto"];

    $htmlContent = file_get_contents('emailfont.html');

    $htmlContent = str_replace(['TITOLO', 'testo'], [$titoloUtente, $testoUtente], $htmlContent);

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: mattiapasinetti05@gmail.com\r\n";

    if (mail($to, $subject, $htmlContent, $headers)) {
        echo "Email inviata con successo a !".$to ;
    } else {
        echo "Errore nell'invio dell'email.";
    }
} else {
    echo "Accesso non autorizzato.";
}
?>
