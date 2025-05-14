<?php

require './funzioniDB.php';
require './components/Head/head.php';

$idU = $_GET['id'];
$data = $_GET['data'];
$idUHash = $_GET['idUHash'];
$dataHash = $_GET['dataHash'];

?>
<html>
<?php
    echo COMP_head(); 
?>
<body>
<?php
if ($idUHash === md5($idU) && $dataHash === md5($data)) {
    $dataora = new DateTime('now', new DateTimeZone('Europe/Rome'));
    $dataora = new DateTime('2025-03-10 12:59:59');
    $dataoraStr = $dataora->format('Y-m-d H:i:s');

    $query = 'SELECT dataoraInvioEmail FROM Utenti WHERE idUtente = ? AND dataoraInvioEmail = ?';
    $valori = [$idU, $data];
    $tipi = [PDO::PARAM_INT, PDO::PARAM_STR];
    $dataInvio = db_query($query, $valori, $tipi);

    if (!isset($dataInvio['error'])) {
        if (!empty($dataInvio)) {
            
            $dataI = new DateTime($dataInvio[0]['dataoraInvioEmail']);
            $diff = $dataora->diff($dataI);
            $oreDifferenza = ($diff->d * 24) + $diff->h;

            if ($oreDifferenza < 24) {
                $query = 'UPDATE Utenti SET dataoraClickEmail = ? WHERE idUtente = ?';
                $valori = [$dataoraStr, $idU];
                $tipi = [PDO::PARAM_STR, PDO::PARAM_INT];
                $ris = db_query($query, $valori, $tipi);
                if ($ris == 1) {
                    echo "<div class='alert alert-success' role='alert'>
                        <h4 class='alert-heading'>Ben Fatto!</h4>
                        <p>Hai verificato correttamente il tuo indirizzo mail!</p>
                        <hr>
                        <p class='mb-0'>Chiudi pure la pagina e fai il login!</p>
                    </div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Problemi a caricare la tua richiesta!</div>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Il link è scaduto!</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Utente non trovato!</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Errore nella query al database!</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Link non valido!</div>";
}
?>
</body>
</html>
