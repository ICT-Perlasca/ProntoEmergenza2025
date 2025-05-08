<?php
require_once "../funzioniDB.php";

$idU = $_GET['id'];
$data = $_GET['data'];
$idUHash = $_GET['idUHash'];
$dataHash = $_GET['dataHash'];

?>
<html>
<head>
    <link href='./public/css/bootstrap.min.css' rel='stylesheet'/>
    <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js'></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
</head>
<body>
<?php
if ($idUHash === md5($idU) && $dataHash === md5($data)) {
    $dataora = new DateTime('now', new DateTimeZone('Europe/Rome'));
    $dataoraStr = $dataora->format("Y-m-d H:i:s");

    $query = "SELECT dataoraInvioEmail FROM Utenti WHERE idUtente = ? AND dataInvioEmail = ?";
    $valori = [$idU, $data];
    $tipi = ["PDO::PARAM_INT", "PDO::PARAM_STR"];
    $dataInvio = db_query($query, $valori, $tipi);

    if (!isset($dataInvio['errore'])) {
        if (!empty($dataInvio)) {
            $dataI = new DateTime($dataInvio[0]['dataoraInvioEmail']);
            $diff = $dataora->diff($dataI);
            $oreDifferenza = ($diff->d * 24) + $diff->h;

            if ($oreDifferenza < 24) {
                $query = "UPDATE Utenti SET dataoraClickEmail = ? WHERE idUtente = ?";
                $valori = [$dataoraStr, $idU];
                $tipi = ["PDO::PARAM_STR", "PDO::PARAM_INT"];
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
