<?php
require './funzioniDB.php';
require './components/Head/head.php';
require './components/Footer/footer.php';
$idU = $_GET['id'];
$data = $_GET['data'];
$idUHash = $_GET['idUHash'];
$dataHash = $_GET['dataHash'];
$idU = 1;
$data = "2025-05-14 09:10:23";
$idUHash = md5($idU);
$dataHash = md5($data);
?>
<html>
<?php
    echo COMP_head(); 
?>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="height: 10%;">
        <div class="navbar-brand container-fluid">
            <img src="./public/images/logo-ambulanza.png"  class="" style="height: 10%;width:10%;"/>
        </div>
    </nav>
<?php
if ($idUHash === md5($idU) && $dataHash === md5($data)) {
    $dataora = new DateTime('now', new DateTimeZone('Europe/Rome'));
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
                    echo "<div class='alert alert-primary h-50' role='alert'>
                        <h4 class='alert-heading'>Ben Fatto!</h4>
                        <p>Hai verificato correttamente il tuo indirizzo mail!</p>
                        <hr>
                        <p class='mb-0'>Chiudi pure la pagina e fai il login!</p>
                    </div>";
                } else {
                    echo "<div class='alert alert-danger h-50'  role='alert'>
                        <h4 class='alert-heading'>Ops... Qualcosa è andato storto!</h4>
                        <p>Problemi a caricare la tua richiesta</p>
                        </div>";
                }
            } else {
                echo "<div class='alert alert-danger h-50' role='alert'>
                    <h4 class='alert-heading'>Ops... Qualcosa è andato storto!</h4>
                    <p>Il link è scaduto!</p>
                    </div>";
            }
        } else {
            echo "<div class='alert alert-danger h-50' role='alert'>
                <h4 class='alert-heading'>Ops... Qualcosa è andato storto!</h4>
                <p>Utente non trovato!</p>
                </div>";
        }
    } else {
        echo "<div class='alert alert-danger h-50' role='alert'>
            <h4 class='alert-heading'>Ops... Qualcosa è andato storto!</h4>
            <p>Errore nella query al database!</p>
            </div>";
    }
} else {
    echo "<div class='alert alert-danger h-50' role='alert'>
            <h4 class='alert-heading'>Ops... Qualcosa è andato storto!</h4>
            <p>Link non valido!</p>
            </div>";
}
echo COMP_footer();

?>
</body>
</html>
