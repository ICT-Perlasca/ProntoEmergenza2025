<?php
/*
Idea generale: stabilire format delle email generali con queste variabili che si renderanno disponibili 
per i codici php che includeranno il file per usare la funzione invio email. i dati tra le {} dovranno
essere sostituiti prima di essere passati come parametri alla funzione inviaEmail
*/
// formato della email di validazione della email dell'utente necessaria in caso di nuovo utente
//sostituire {nomeUtente} e {link} con i valori coerenti
$validazioneEmail=[
    "titolo"=>"ciao {nomeUtente}",
    "testo"=>"Ti sei registrato come nuovo utente su ProntoEmergenza!<br>
Per completare la registrazione e accedere a tutti i vantaggi, ti preghiamo di confermare il tuo indirizzo email cliccando sul link qui sotto:
{link}.<br>
Se il link non funziona, puoi copiarlo e incollarlo nel tuo browser.<br>
Se non hai effettuato questa registrazione, ignora questo messaggio.<br>
Grazie ancora e benvenuto a nome di tutta l'associazione!<br>
Cordiali saluti,<br>
Il team di ProntoEmrgenza di Agnosine(BS)",
    "oggetto"=>" Grazie per esserti registrato su Pronto Emergenza!!"

];
$cambioPsw=[
    "titolo"=>"Gentile {nomeUtente},",
    "testo"=>"La tua password è stata cambiata con successo.<br>
Se hai richiesto tu questo cambio password, ora puoi accedere al tuo account con la nuova password. 
Se non hai richiesto questo cambio o sospetti un accesso non autorizzato, ti invitiamo a contattare il nostro team di supporto all'indirizzo info@prontoemergenza.it o al numero 0365/826210.<br>
Grazie,<br>
Il team di ProntoEmrgenza di Agnosine(BS)<br>
Associazione di Volontariato",
    "oggetto"=>"Conferma cambio password"
];
$nuovomeseProgrammazione=[
    "titolo"=>"Mese in programmazione {mese}",
    "testo"=>"Gentile utente. Ti inviatiamo ad inserire i turni per cui ti vuoi rendere disponibile nel nuovo mese in programmazio: {nomeMese}.
Grazie,
Pronto Emergenza
Associazione di volontariato",
    "oggetto"=>"Conferma cambio password"
];
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
