<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Invia Email Emergenza</title>
</head>
<body>
    <h2>Invio Email Personalizzata</h2>
    <form action="invioemail.php" method="post">
        <label for="titolo">Titolo:</label><br>
        <input type="text" name="titolo" id="titolo" required><br><br>

        <label for="testo">Testo:</label><br>
        <textarea name="testo" id="testo" rows="5" cols="40" required></textarea><br><br>

        <label for="destinatario">Email Destinatario:</label><br>
        <input type="email" name="destinatario" id="destinatario" required><br><br>

        <label for="oggetto">Oggetto Email:</label><br>
        <input type="text" name="oggetto" id="oggetto" required><br><br>

        <input type="submit" value="Invia Email">
    </form>
</body>
</html>
