<?php
session_start();

require_once("./Head/head.php");
require_once("./Header/header.php");
require_once("./Footer/footer.php");
require_once("./funzioniDB.php");
if (!isset($_SESSION['tipoUtente']) || $_SESSION['tipoUtente'] !== "admin") {
    header("Location: login");
    exit;
}

if (isset($_POST['inserisciComunicazione'])) {
    $idMezzo = $_POST['mezzo'];
    $data = $_POST['dataEvento'];
    $oraInizio = $_POST['oraInizio'];
    $oraFine = $_POST['oraFine'];
    $luogo = trim($_POST['luogo']);
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    if (!empty($data) && !empty($oraInizio) && !empty($oraFine) && !empty($luogo) && !empty($nome) && !empty($cognome) && is_numeric($idMezzo)) {
        $q = "INSERT INTO eventiprogrammati(data, oraInizio, oraFine, luogo, nomeRichiedente, cognomeRichiedente, idMezzo)
              VALUES (?, ?, ?, ?, ?, ?, ?);";
        $tipi = ['PDO::PARAM_STR', 'PDO::PARAM_STR', 'PDO::PARAM_STR', 'PDO::PARAM_STR',
                 'PDO::PARAM_STR', 'PDO::PARAM_STR', 'PDO::PARAM_INT'];
        $values = [$data, $oraInizio, $oraFine, $luogo, $nome, $cognome, $idMezzo];

        $result = db_query($q, $values, $tipi);

        if (isset($result['error'])) {
            $messaggioErrore = "Errore durante l'inserimento: " . $result['error'];
        } else {
            $messaggioSuccesso = "Comunicazione inserita con successo.";
        }
    } else {
        $messaggioErrore = "Compila correttamente tutti i campi.";
    }
}
echo COMP_head();
echo "<body>" . COMP_header();
?>

<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg animate__animated animate__fadeInDown">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-bullhorn me-2" style="color: #fd7e14;"></i> Inserisci Comunicazione
                    </h3>

                    <?php if (isset($messaggioSuccesso)): ?>
                        <div class="alert alert-success"><?= $messaggioSuccesso ?></div>
                    <?php elseif (isset($messaggioErrore)): ?>
                        <div class="alert alert-danger"><?= $messaggioErrore ?></div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="dataEvento" class="form-label">Data Evento</label>
                            <input type="date" class="form-control" id="dataEvento" name="dataEvento" required
                                   oninvalid="this.setCustomValidity('Inserisci una data')"
                                   oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="oraInizio" class="form-label">Ora Inizio Evento</label>
                            <input type="time" class="form-control" id="oraInizio" name="oraInizio" required
                                   oninvalid="this.setCustomValidity('Inserisci l\'ora di inizio')"
                                   oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="oraFine" class="form-label">Ora Fine Evento</label>
                            <input type="time" class="form-control" id="oraFine" name="oraFine" required
                                   oninvalid="this.setCustomValidity('Inserisci l\'ora di fine')"
                                   oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="luogo" class="form-label">Luogo</label>
                            <input type="text" class="form-control" id="luogo" name="luogo" required
                                   oninvalid="this.setCustomValidity('Inserisci il luogo')"
                                   oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Richiedente</label>
                            <input type="text" class="form-control" id="nome" name="nome" required
                                   oninvalid="this.setCustomValidity('Inserisci il nome')"
                                   oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="cognome" class="form-label">Cognome Richiedente</label>
                            <input type="text" class="form-control" id="cognome" name="cognome" required
                                   oninvalid="this.setCustomValidity('Inserisci il cognome')"
                                   oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="mezzo" class="form-label">Mezzo</label>
                            <select name="mezzo" id="mezzo" class="form-select" required
                                    oninvalid="this.setCustomValidity('Seleziona un mezzo')"
                                    oninput="this.setCustomValidity('')">
                                <option value="">-- Seleziona un mezzo --</option>
                                <?php
                                $query = "SELECT nomeMezzo, targa, idMezzo FROM mezzi";
                                $mezzi = db_query($query, [], []);
                                if (isset($mezzi['error'])) {
                                    echo "<option disabled>Errore nel recupero dei mezzi</option>";
                                } else {
                                    foreach ($mezzi as $mezzo) {
                                        echo "<option value='{$mezzo['idMezzo']}'>{$mezzo['nomeMezzo']} - {$mezzo['targa']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button name="inserisciComunicazione" type="submit" class="btn btn-orange w-100">
                            <i class="fas fa-paper-plane me-2"></i> Invia Comunicazione
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo COMP_footer();
echo "</body></html>";
?>
