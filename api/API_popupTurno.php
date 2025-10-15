<?php
   // require_once('../../api/API_elencoUtentiRuolo.php');
require_once('./api/API_elencoRuoli.php');
//require_once "./funzioniDB.php";
function API_popupTurno($get, $post, $session) {
   // session_start();
    $nomeUtente = $_POST['nomeUtente'] ?? null;
    $data = $_POST['dataTurno'] ?? null;

    // Ruolo dell'utente corrente
    $tipoUtente = $session['tipoUtente'];//prati ?? 'user'; 
    //byprati: recupero id utente dalla sessione (lo metterò come campo nascosto se utente non è admin)
    $idUtente=$session['idUtente'];
    /*print_r('tipoUtente: ' . $_SESSION['tipoUtente'] );
    print_r('Ruolo utente: ' . $ruoloUtente);*/
   
    /* prati: elenco ruoli da visualizzare
    chiamo API_elencoRuoli passando idutente solo se utente non è admin
    su evento change del ruolo chiamo API che carica tutti utenti con tale ruolo nella select
    */
    if ($tipoUtente==='admin')
        $ruoli=API_elencoRuoli([],[],$_SESSION);
    else
        $ruoli=API_elencoRuoli([],['idUtente'=>$idUtente],$_SESSION);
// non è stato usato COMP_selectRuolo x creare la select sulla scelta del ruolo perchè 
// qui all'evento onChange si devon scegliere anche gli utenti abbinati al ruolo

     ob_start();

?>

<div class="modal fade" id="popupTurno" tabindex="-1" aria-labelledby="popupTurnoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserisci Turno per <?php echo htmlspecialchars($data); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <form id="formTurnoUtente" name='formInsTurno'>
                    <input type="hidden" name="dataTurno" value="<?php echo htmlspecialchars($data); ?>">
  <!--byprati: inserire qui elenco dei ruoli che è possibile selezionare prendendoli dalla tabella ruoli del DB
                        -->
                    <div class="mb-2">
                        <label class="form-label">Ruolo</label>
                        <select name="ruolo" class="form-select" onchange="caricaUtenti(this.form)">
                        <option value="">-- Seleziona un ruolo --</option>
                        <?php
                        foreach($ruoli as $r ){
                            echo "<option value={$r['idRuolo']}>{$r['nome']}</option>";
                        }
                        ?>    
                        
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Nome utente</label>
                        <?php if ($tipoUtente === 'admin'): ?>
                            <select class="form-select" name="nomeUtente" id="selectUtenti" required>
                                <option value="">-- Seleziona utente --</option>
                            </select>
                        <?php else: //utente non è admin quindi il suo id è memorizzato in campo nascosto?>
                            <input type="text" class="form-control" name="nomeUtente" value="<?php echo htmlspecialchars($nomeUtente); ?>" readonly>
                            <input type=hidden value="<?php echo htmlspecialchars($idUtente);?>" id=idUtente>
                        <?php endif; ?>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Fascia oraria</label>
                        <select name="fasciaOraria" class="form-select" onchange="aggiornaOra(this.form)">
                            <option value="07:00:00 - 13:00:00">7:00 - 13:00</option>
                            <option value="13:00:00 - 19:00:00">13:00 - 19:00</option>
                            <option value="19:00:00 - 07:00:00">19:00 - 07:00</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Ora inizio effettiva</label>
                        <input type="time" name="oraInizioEffettiva" class="form-control" value="07:00">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Ora fine effettiva</label>
                        <input type="time" name="oraFineEffettiva" class="form-control" value="13:00">
                    </div>
                  
                    <div class="mb-2">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="confermaTurno(this.form)">Conferma</button>
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
        'utenteIsAdmin' => ($tipoUtente === 'admin')
    ];
    return $response;
//    header('Content-Type: application/json');
//    echo json_encode($response);
}
?>