<?php
//byprati: questo file viene richiamato SOLO se utente è admin!!! (al click sulla matita accanto al nome del volontario/lavoratorio inserito nel turno da modificare)
    session_start();
    $idTurnoDaModificare = $_POST['idTurno118'] ?? null;
    

    // Ruolo dell'utente corrente: sicuramente admin
    $ruoloUtente = 'admin'; //$_SESSION['tipoUtente'] ?? 'user'; 
   
      ob_start();
    require_once ('./api/elencoDatiTurnoSingolo.php');
    $datiTurno=API_elencoDatiTurnoSingolo([],[$idTurnoDaModificare],[]);
    //byprati:non dovrebbe essere vuoto!!!!
?>
<!--
<script>  
    document.addEventListener('DOMContentLoaded', () => {
        <?php if ($ruoloUtente === 'admin'): ?>
            caricaUtenti();
        <?php endif; ?>
    });
</script>
        -->
<div class="modal fade" id="popupModificaTurno" tabindex="-1" aria-labelledby="popupTurnoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica Turno per <?php echo htmlspecialchars($data); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <form id="formModificaTurnoUtente" name='formModificaTurno'>
                    <input type="hidden" name="dataTurno" value="<?php echo htmlspecialchars($data); ?>">

                    <div class="mb-2">
                        <label class="form-label">Nome utente</label>
                        <select class="form-select" name="nomeUtente" id="selectUtenti" required>
                            <option value="">-- Seleziona utente --</option>
                        </select>
                      <!-- by prati: si devonocaricare utenti e si deve selezionare l'utente=$datiTurno.idUtente
                        --> 
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Fascia oraria</label>
                        <select name="fasciaOraria" class="form-select" onchange="aggiornaOra(this.form)">
                            <option value="07:00:00 - 13:00:00" <?php echo $datiTurno['oraInizio']=='07:00:00'?selected:'';?>>7:00 - 13:00</option>
                            <option value="13:00:00 - 19:00:00" <?php echo $datiTurno['oraInizio']=='13:00:00'?selected:'';?>>13:00 - 19:00</option>
                            <option value="19:00:00 - 07:00:00"<?php echo $datiTurno['oraInizio']=='19:00:00'?selected:'';?>>19:00 - 07:00</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Ora inizio effettiva</label>
                        <input type="time" name="oraInizioEffettiva" class="form-control" value=<?php echo $datiTurno['oraInizioEffettiva'];?>>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Ora fine effettiva</label>
                        <input type="time" name="oraFineEffettiva" class="form-control" value=<?php echo $datiTurno['oraInizioEffettiva'];?>>
                    </div>
                    //byprati: inserire qui elenco dei ruoli che è possibile selezionare prendendoli dalla tabella ruoli del DB
                    <div class="mb-2">
                        <label class="form-label">Ruolo</label>
                        <select name="ruolo" class="form-select">
                            <option value="autista" <?php echo $datiTurno['ruolo']=='autista'?selected:'';?>>Autista</option>
                            <option value="soccorritore" <?php echo $datiTurno['ruolo']=='soccorritore'?selected:'';?>>Soccorritore</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="3" value=<?php echo $datiTurno['testoNota'];?>></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="ModificaTurno(this.form)">Modifica</button>
                        <button type="button" class="btn btn-secondary" onclick="CancellaTurno(this.form)">Cancella</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annulla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $html = ob_get_clean();

    $response = [
        'html' => $html,
        'utenteIsAdmin' => ($ruoloUtente === 'admin') //qui sempre TRUE!!!!
    ];

    header('Content-Type: application/json');
    echo json_encode($response);