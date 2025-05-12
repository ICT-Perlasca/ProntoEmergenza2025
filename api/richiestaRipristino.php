<?php
require_once("./funzioniDB.php");
require_once("email_handler.php");

function checkEmail($email) {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "L'indirizzo email non è valido.";
    }

    if (strlen($email) > 30) {
        return "L'indirizzo email è troppo lungo.";
    }

    $sql = "SELECT COUNT(*) FROM utenti WHERE email = ?;";
    $risposta = db_query($sql, [$email], [PDO::PARAM_STR]);
    $count = $risposta[0]["COUNT(*)"] ?? 0;

    return $count;
}


function API_richiestaRipristino($get, $post, $session) {
    $email = $post["email"] ?? "";

    if (checkEmail($email) > 0) {

        $link = "http://localhost/ProntoEmergenza2025/ripristino?token=".trim(base64_encode($email ."-". md5($email) ."-". time()), "=")."";

        return $link;
        $titolo = "Ciao,";
        $testo = "Abbiamo ricevuto una richiesta di ripristino della password per il tuo account. "
            . "Clicca qui per procedere:\n\n"
            . "<a href='$link'>Ripristina la tua password</a>\n\n"
            . "Se non hai richiesto il ripristino, ignora questa email.";

        $destinatario = $email;
        $oggetto = "Ripristino password";
        $mittente = "no-reply@example.com";

        if (!inviaEmail($titolo, $testo, $destinatario, $oggetto, $mittente)) {
            return "Errore nell'invio dell'email.";
        }
    }
    return "Email inviata con successo.";
}
?>