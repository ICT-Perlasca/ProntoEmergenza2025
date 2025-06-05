<?php
require_once 'email_handler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titolo = $_POST['titolo'];
    $testo = $_POST['testo'];
    $destinatario = $_POST['destinatario'];
    $oggetto = $_POST['oggetto'];
    $mittente = $_POST['mittente'];

    if (inviaEmail($titolo,$testo,$destinatario,$oggetto,$mittente)) {
        echo "Email inviata con successo!";
    } else {
        echo "Errore nell'invio dell'email.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invia Email</title>
</head>
<body>
    <h1>Invia una Email</h1>
    <form method="POST" action="">
        <label for="titolo">Titolo:</label>
        <input type="text" id="titolo" name="titolo" required><br><br>

        <label for="testo">Testo:</label>
        <textarea id="testo" name="testo" required></textarea><br><br>

        <label for="destinatario">Destinatario:</label>
        <input type="email" id="destinatario" name="destinatario" required><br><br>

        <label for="oggetto">Oggetto:</label>
        <input type="text" id="oggetto" name="oggetto" required><br><br>

        <label for="mittente">Email mittente:</label>
        <input type="email" id="mittente" name="mittente" required><br><br>

        <button type="submit">Invia Email</button>
    </form>
</body>
</html>
