<?php
if(!isset($_POST['inserisciComunicazione']) && $_SESSION['tipoUtente'] == "admin")
{
    require_once("./Head/head.php");
    require_once("./Header/header.php");
    require_once("./Footer/footer.php");
    require_once("./funzioniDB.php");

    echo COMP_head();
    echo "<body>".COMP_header();
?>
<div class="container py-5">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-lg animate__animated animate__fadeInDown">
                        <div class="card-body p-4">
                            <h3 class="text-center mb-4">
                                <i class="fas fa-bullhorn me-2" style="color: #fd7e14;"></i> Inserisci Comunicazione
                            </h3>
                            <form method="POST" class="needs-validation">
                                <div class="mb-3">
                                    <label for="dataEvento" class="form-label">Data Evento</label>
                                    <input type="date" class="form-control" id="dataEvento" name="dataEvento"
                                        required
                                        oninvalid="this.setCustomValidity('Inserisci una data')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label for="oraInizio" class="form-label">Ora Inizio Evento</label>
                                    <input type="time" class="form-control" id="oraInizio" name="oraInizio"
                                        required
                                        oninvalid='this.setCustomValidity("Inserisci a che ora inizia il nuovo evento")';
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label for="oraFine" class="form-label">Ora Fine Evento</label>
                                    <input type="time" class="form-control" id="oraFine" name="oraFine"
                                        required
                                        oninvalid='this.setCustomValidity("Inserisci a che ora finisce il nuovo evento")';
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label for="luogo" class="form-label">Luogo</label>
                                    <input type="text" class="form-control" id="luogo" name="luogo"
                                        required
                                        oninvalid="this.setCustomValidity('Inserisci il luogo')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome Richiedente</label>
                                    <input type="text" class="form-control" id="nome" name="nome"
                                        required
                                        oninvalid="this.setCustomValidity('Inserisci il nome del richiedente')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label for="cognome" class="form-label">Cognome Richiedente</label>
                                    <input type="text" class="form-control" id="cognome" name="cognome"
                                        required
                                        oninvalid="this.setCustomValidity('Inserisci il cognome del richiedente')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label for="mezzo" class="form-label">Mezzo</label>
                                    <select name="mezzo">
                                        <?php
                                            $query = "SELECT nomeMezzo, targa, idMezzo FROM mezzi";
                                            $dati = db_query($query, [], []);
                                            for($i = 0; $i < count($dati); $i++)
                                                echo "<option>" . $dati[$i]['idMezzo']. '-' . $dati[$i]['nomeMezzo']. "-" . $dati[$i]['targa'] . "</option>"; 
                                            
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
}
else if(isset($_POST['inserisciComunicazione']) && $_SESSION['tipoUtente'] == "admin")
{
    $datiMezzo = explode("-", $_POST['mezzo']);
    $q = "INSERT INTO eventiprogrammati(data, oraInizio, oraFine, luogo, nomeRichiedente, cognomeRichiedente, idMezzo)
    VALUES (?, ?, ?, ?, ?, ?, ?);";
    $tipi = ['PDO::PARAM_STR', 'PDO::PARAM_STR', 'PDO::PARAM_STR', 'PDO::PARAM_STR', 'PDO::PARAM_STR', 'PDO::PARAM_STR', 'PDO::PARAM_INT'];
    $values = [$_POST['dataEvento'], $_POST['oraInizio'], $_POST['oraFine'], $_POST['luogo'], $_POST['nome'], $_POST['cognome'], $datiMezzo[0]];
    db_query($q, $values, $tipi);
}
else
{
    header("location: login");
}