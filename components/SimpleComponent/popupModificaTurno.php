<?php
//byprati: questo file viene richiamato se utente è admin oppure è user e sta modificando uno dei suoi stessi turni!!! (al click sulla matita accanto al nome del volontario/lavoratorio inserito nel turno da modificare)
//l'html viene restituito come API (nel valore html dell'array response) e verrà visualizzato dallo scritp js che lo ha richiamato (apripopupModificaTurno in calendar.js)
   

    require_once('../../api/API_elencoDatiTurnoSingolo.php');
    require_once('../../api/API_elencoUtentiRuolo.php');
    session_start();
    $idT = $_POST['idTurno'];
    
    // Ruolo dell'utente corrente
    $ruoloUtente = $_SESSION['tipoUtente']; 
    $datiTurno=API_elencoDatiTurnoSingolo([],['idTurno'=>$idT],$_SESSION);
    //print_r($datiTurno);
    //byprati 31-08: se sono admin devo ottenere elenco degli utenti con il ruolo che si sta modificando
    // se sono user: negli utenti deve comparire solo nome e id dell'utente loggato
    if ($ruoloUtente==='admin')
        $utenti=API_elencoUtentiRuolo([],['ruolo'=>$datiTurno[0]['ruolo']],$_SESSION);
    else{
        $utenti[0]['idUtente']=$_SESSION['idUtente'];
        $utenti[0]['cognome']=$_SESSION['cognome'];
        $utenti[0]['nome']=$_SESSION['nome'];
    }

    //si permette di modificare nome della persona, orario di inzio e di fine ma NON il ruolo!!!
   ob_start();

?>
<div class="modal fade" id="popupModificaTurno" tabindex="-1" aria-labelledby="popupTurnoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica Turno del giorno <?php echo htmlspecialchars($datiTurno[0]['data']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <form id="formModificaTurnoUtente" name='formModificaTurno'>
                    <input type="hidden" name="dataTurno" value="<?php echo htmlspecialchars($datiTurno[0]['data']); ?>">
                    <input type="hidden" name ='idTurno' value="<?php echo $datiTurno[0]['idT'];?>">
                    <div class="mb-12">
                        <label class="form-label">Nome utente</label>
                        <select class="form-select" name="nomeUtente" id="selectUtenti" <?php echo ($ruoloUtente==='admin')?'required':'disabled';?>>
                            <!--<option value="">-- Seleziona utente </option>-->
                            <?php
                            foreach($utenti as $ut){
                                echo"<option value='{$ut['idUtente']}'>{$ut['cognome']}  {$ut['nome']}</option>";
                            }
                            ?>
                        </select>
                      <!-- by prati: si devonocaricare utenti aventi lo stesso ruolodi quello che subisce la modifica e si deve selezionare utente=$datiTurno.idUtente-->
                 
                    </div>
                
                    <div class="mb-2">
                        <label class="form-label">Fascia oraria</label>
                        <select name="fasciaOraria" class="form-select" onchange="aggiornaOra(this.form)">
                            <option value="07:00:00 - 13:00:00" <?php echo $datiTurno[0]['oraInizio']=='07:00:00'?'selected':'';?>>7:00 - 13:00</option>
                            <option value="13:00:00 - 19:00:00" <?php echo $datiTurno[0]['oraInizio']=='13:00:00'?'selected':'';?>>13:00 - 19:00</option>
                            <option value="19:00:00 - 07:00:00"<?php echo $datiTurno[0]['oraInizio']=='19:00:00'?'selected':'';?>>19:00 - 07:00</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Ora inizio effettiva</label>
                        <input type="time" name="oraInizioEffettiva" class="form-control" value=<?php echo $datiTurno[0]['oraInizioEffettiva'];?>>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Ora fine effettiva</label>
                        <input type="time" name="oraFineEffettiva" class="form-control" value=<?php echo $datiTurno[0]['oraFineEffettiva'];?>>
                    </div>
                   
                    <div class="mb-2">
                        <label class="form-label">Ruolo</label>
                        <!-- byprati: nella Modifica del >Turno si visualizza solo il ruolo attuale, sena possibilitàdi modifica (si modifica la persiona su quel ruolo)
                        -->
                        <select name="ruolo" class="form-select" disabled>
                            <option value=<?php echo $datiTurno[0]['idRuolo'];?>> <?php echo $datiTurno[0]['ruolo'];?></option>
<!--                          <option value="soccorritore" <?php //echo $datiTurno[0]['ruolo']==='soccorritore'?'selected':'';?>>Soccorritore</option>-->
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Note</label>
                        <textarea name="note" class="form-control" rows="3" value=<?php echo $datiTurno[0]['testoNota'];?>></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="ModificaTurno(this.form)">Modifica</button>
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
        'utenteIsAdmin' => true
    ];
  header('Content-Type: application/json');
  echo json_encode($response);

?>