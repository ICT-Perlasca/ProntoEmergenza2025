<?php
$DB = "pronto_emergenza";
$USERDB = "root";
$PSWDB="";
$HOST = "localhost";
$DSN="mysql:host=" .$HOST . ";dbname=" . $DB;
$DOMAIN_NAME = "http://localhost/ProntoEmergenza2025";
$cartellaImmagini="uploads/images";
$cartellaBacheca="ProntoEmergenza2025/uploads/bacheca";
$cartellaDocumenti="uploads/document";
$imgAvatar="avatar-100.png";
$imgDocF="documentF";
$imgDocR="documentoR";
$imgAllegato="allegatoDoc";
$imgProfilo="profiloImg";


//turni da inserire (mattina, pomeriggio e notte)
$turni = [
    ['07:00:00', '13:00:00'],
    ['13:00:00', '19:00:00'],
    ['19:00:00', '07:00:00']
]; 
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
Il team di ProntoEmergenza di Agnosine(BS)",
    "oggetto"=>" Grazie per esserti registrato su Pronto Emergenza!!",

];
$cambioPsw=[
    "titolo"=>"Gentile {nomeUtente},",
    "testo"=>"La tua password è stata cambiata con successo.<br>
Se hai richiesto tu questo cambio password, ora puoi accedere al tuo account con la nuova password. 
Se non hai richiesto questo cambio o sospetti un accesso non autorizzato, ti invitiamo a contattare il nostro team di supporto all'indirizzo info@prontoemergenza.it o al numero 0365/826210.<br>
Grazie,<br>
Il team di ProntoEmergenza di Agnosine(BS)<br>
Associazione di Volontariato",
    "oggetto"=>"Pronto Emergenza: Conferma cambio password"
];
$nuovomeseProgrammazione=[
    "titolo"=>"Mese in programmazione {mese}",
    "testo"=>"Gentile utente. Ti inviatiamo ad inserire i turni per cui ti vuoi rendere disponibile nel nuovo mese in programmazio: {nomeMese}.
Grazie,<br>
Il team di ProntoEmergenza di Agnosine(BS)<br>
Associazione di Volontariato",
    "oggetto"=>"ProntoEmergenza: Nuovo mese in programmazione"
];
?>