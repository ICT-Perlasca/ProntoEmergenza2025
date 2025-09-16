<?php
session_start();

if (!isset($_SESSION['idUtente'])) {
    header("Location: login");
} else {
?>
<!DOCTYPE html>
<html lang="it">
    <?php
        require("././api/API_AggiuntaComunicazione.php");
        require_once("./components/Head/head.php");
        require_once("./components/SimpleComponent/COMP_form.php");
        echo COMP_head();
    ?>
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
        <style>
            body {
                background: #f4f7fa;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .card {
                border: none;
                border-radius: 1rem;
            }
            .fa-paper-plane {
                animation: float 1.5s infinite ease-in-out;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-3px); }
            }
        </style>
    </head>
    <body>
        <?php
            require_once("./components/Header/header.php");
            require_once("./components/Footer/footer.php");
            require_once("./components/SimpleComponent/COMP_Alert.php");
            require_once("./components/SimpleComponent/COMP_selectUtenti.php");
            
            echo COMP_header($_SESSION);

            if (!isset($_POST["btnInserisciComunicazione"])) {
                
                $tipi = db_query("SELECT nome, idTipo FROM tipicomunicazione", [], []);
        ?>
<!--        <div class="container py-5">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-lg animate__animated animate__fadeInDown">
                        <div class="card-body p-4">
                            <h3 class="text-center mb-4">
                                <i class="fas fa-bullhorn me-2 text-primary"></i> Inserisci Comunicazione
                            </h3>
            -->
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
                        <option value="tutti_user">Tutti i user</option>
                        <option value="tutti_admin">Tutti gli admin</option>
                        <option value="tutti">Tutti</option>
                        <option value="utente_specifico">Un solo utente specifico</option>
                    </select>
                </div>
                <div class="mb-3" id="specificoField" style="display:none;">
<!--                    <div class="row">
                        <div class="col-md-6">
                            <label for="cognome" class="form-label">Cognome</label>
                            <input type="text" class="form-control" id="cognome" name="cognome" placeholder="Cognome">
                        </div>
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                        </div>
                    </div>
                        -->
                    <center>
                        <?php echo COMP_selectUtenti('idUtente');?>
                    </center>
                </div>
<!--                                <button name="inserisciComunicazione" type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-paper-plane me-2"></i> Invia Comunicazione
                </button>
-->
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
                $res = API_AggiuntaComunicazione($_GET, $_POST, $_SESSION);

                if(isset($res['error'])){
                    echo COMP_Alert("alert-danger",$res['error']);
                }
                else{
                   // print_r($res);
                    echo COMP_Alert("alert-success",$res['msgio']);
                }
            }

            echo COMP_Footer();
        ?>
    </body>
</html>
<?php
}
?>