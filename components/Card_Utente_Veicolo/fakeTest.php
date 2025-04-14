<?php
require_once 'cardUtente.php';
require_once 'cardVeicolo.php';

$utente = [
    'idUtente' => 1,
    'nome' => 'Mario',
    'cognome' => 'Rossi',
    'email' => 'mario.rossi@example.com',
    'foto' => 'test.jpg'
];

$veicolo = [
    'idVeicolo' => 101,
    'modello' => 'Fiat Panda',
    'tipoMezzo' => 'macchina',
    'targa' => 'AB123CD',
    'colore' => 'Bianco',
    'foto' => 'test.jpg'
];

$card = generaCardUtente($utente);
$cardVeicolo = generaCardMezzo($veicolo);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Card Utente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Test Card Utente</h1>
        <?php
        echo $card;
        echo $cardVeicolo;
        ?>
    </div>
</body>
</html>