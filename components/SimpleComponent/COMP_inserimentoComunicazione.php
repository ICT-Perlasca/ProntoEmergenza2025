<?php
require_once("./api/API_aggiuntaComunicazione.php");
require_once("./components/SimpleComponent/COMP_Alert.php");
require_once("./components/SimpleComponent/COMP_selectUtenti.php");
require_once("./components/SimpleComponent/COMP_form.php");
            
/*
Visualizza il form per inserire nupva cpmunicazione sia x admin (fa vedere tutti i possibii destinatari
sia per user semplici (fa vedere come destinatari solo gli admin))
*/
function COMP_inserimentoComunicazione($tipoUtente){

     ob_start();
     if (!isset($_POST["btnInserisciComunicazione"])) {
                
                $tipi = db_query("SELECT nome, idTipo FROM tipicomunicazione", [], []);
        ?>

            <?php echo COMP_formContainerHeader('Inserimento Nuova Comunicazione',false,'');?>
                            
            <form method="POST" action="" id="comunicazioneForm" class="needs-validation" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="titolo" class="form-label">Titolo</label>
                    <input type="text" class="form-control" id="titolo" name="titolo"
                        required
                        oninvalid="this.setCustomValidity('Inserisci un titolo')"
                        oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione</label>
                    <textarea class="form-control" id="descrizione" name="descrizione" rows="3"
                        required
                        oninvalid="this.setCustomValidity('Inserisci una descrizione')"
                        oninput="this.setCustomValidity('')"></textarea>
                </div>
                <div class="mb-3">
                    <select name="tipo" class="form-select p-1">
                        <option>Scegli tipo Comunicazione</option>
                        <?php
                            foreach ($tipi as $tipo) {
                                echo "<option value='{$tipo['idTipo']}'>{$tipo['nome']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="data_scadenza" class="form-label">Scadenza</label>
                    <input type="date" class="form-control" id="data_scadenza" name="data_scadenza"
                        required
                        oninvalid="this.setCustomValidity('Seleziona una data di scadenza')"
                        oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label for="allegato" class="form-label">Allegato</label>
                    <input type="file" class="form-control" id="allegato" name="fileUp"
                        oninvalid="this.setCustomValidity('Inserisci un allegato (es: link o nome file)')"
                        oninput="this.setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label for="destinatario" class="form-label">Destinatario</label>
                    <select class="form-control" name="destinatario" id="destinatario" onchange="toggleUserField()">
                        <option value="tutti_user" <?php echo ($tipoUtente==="user")?"disabled":""?>>Tutti i user</option>
                        <option value="tutti_admin" <?php echo ($tipoUtente==="user")?"selected":""?>>Tutti gli admin</option>
                        <option value="tutti" <?php echo ($tipoUtente==="user")?"disabled":""?>>Tutti</option>
                        <option value="utente_specifico" <?php echo ($tipoUtente==="user")?"disabled":""?>>Un solo utente specifico</option>
                    </select>
                </div>
                <div class="mb-3" id="specificoField" style="display:none;">
                    <center>
                        <?php echo COMP_selectUtenti('idUtente');?>
                    </center>
                </div>

                <?php echo COMP_formFooter('Invia Comunicazione','btnInserisciComunicazione',false);?>

            </form>
            <?php echo COMP_formContainerFooter();?>
<!--                        </div>
                    </div>
                </div>
            </div>
        </div>
-->
        <script>
            function toggleUserField() {
                const destinatario = document.getElementById('destinatario').value;
                const specificoField = document.getElementById('specificoField');
                
                if (destinatario === 'utente_specifico') {
                    specificoField.style.display = 'block';
                    document.getElementById('idUtente').setAttribute('required', '');
                    //document.getElementById('nome').setAttribute('required', '');
                } else {
                    specificoField.style.display = 'none';
                    document.getElementById('idUtente').removeAttribute('required');
                    //document.getElementById('nome').removeAttribute('required');
                }
            }

            // Validazione form lato client
    /*        document.getElementById('comunicazioneForm').addEventListener('submit', function(e) {
               alert("premuto bottone submit");
                const fileInput = document.getElementById('allegato');
                const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
                
                if (fileInput.files.length > 0) {
                    if (!allowedExtensions.exec(fileInput.value)) {
                        alert('Per favore carica solo file con estensione .jpg, .jpeg, .png  o .pdf');
                        e.preventDefault();
                        return false;
                    }
                    else{
                        alerti("ritorno true");
                        return true;
                    }
                }
                else {
                    alert('Per favore carica un file di dimensione >0');
                    e.preventDefault();
                    return false;
                }
            });
      */
      </script>
        <?php
        } else {
            $res = API_aggiuntaComunicazione($_GET, $_POST, $_SESSION);

            if(isset($res['error'])){
                echo COMP_Alert("alert-danger",$res['error']);
            }
            else{
                // print_r($res);
                echo COMP_Alert("alert-success",$res['msgio']);
            }
        }
        return ob_get_clean();


}