<?php
    //Pagina che contiene la "home" della bacheca
    //DEVI AGGIUNGERE LE COMUNICAZIONI E VISUALIZZARLE CI DEVE ESSERE UN MODALE

    /*require("../funzioniBacheca.php");
    session_start();
    $_SESSION['utente']['tipoUtente'] = "admin";        //Da commentare finito il lavoro
    $_SESSION['utente']['idUtente'] = 1;                //Da commentare finito il lavoro

    if (!isset($_SESSION['utente']['idUtente']) || !isset($_SESSION['utente']['tipoUtente'])) {
        header("Location: login");
    } 
    
    //Prende le comunicazioni dal DB, se l'utente e' un admin le prende tutte, altrimenti unicamente quelle a lui associate.
    $com = comunicazioni($_SESSION['utente']['tipoUtente'], $_SESSION); 
    $urgenti = remCom("Urgente", $com);        //$urgenti contiene un array con solo comunicazioni urgenti
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Bacheca</title>
    <link href="../public/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../public/css/cssBacheca.css" rel="stylesheet"/> 
    <script src="../public/js/scriptBacheca.js"></script>
</head>

<body class="bg-white">
    <div class="container py-4">
        <!-- Titolo bacheca e bottone -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Bacheca</h2>
            <button id="addButton" onclick="apriAddComunicazione()">+</button>
        </div>

        <!-- Comunicazioni urgenti -->
        <h3>Comunicazioni urgenti</h3>
        <div class="list-group">
            <?php    
                if (count($urgenti) != 0) {    
                    echo stampaArray($urgenti);
                } else {
                    echo '<p class="text-muted">Non ci sono comunicazioni urgenti al momento</p>';
                }
            ?>
        </div>

        <!-- Comunicazioni generali -->
        <h3>Comunicazioni generali</h3>
        <div class="list-group">
            <?php          
                echo stampaArray($com);
            ?>
        </div>

        <!-- Comunicazioni admin -->
        <?php
            if ($_SESSION['utente']["tipoUtente"] == "admin") {                 
                $comAdmin = remCom("Comunicazione_admin", $com);

                if (count($comAdmin) != 0) {
        ?>
            <h3>Comunicazioni per l'admin</h3>
            <div class="list-group">
                <?php 
                    echo stampaArray($comAdmin);
                ?>
            </div>
        <?php 
                }
            }
        ?>
    </div>
</body>
</html>
*/


    session_start();
    //print_r(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
    //Quando ho questo genere di problemi (non va il percorso) utilizza la funzione sopra
    if (!isset($_SESSION['idUtente'])) {
        header("Location: login");
    } else {
        require_once ("api/elencoComunicazioni.php");
        require_once ("api/TutteComunicazioni.php");
        require_once ("components/Head/head.php");
        require_once ("components/Header/header.php");
        require_once ("components/SimpleComponent/comp.php");
        require_once ("components/Footer/footer.php");
        require_once ("components/SimpleComponent/COMP_Buttons.php");
        
?>

<!DOCTYPE html>
<html lang = "it">
    
    <?php echo COMP_head(); //<HEAD>...</HEAD> ?>
    
    <body>
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
    <?php
    echo COMP_header($_SESSION); //modulo menu utente
    

    //$comunicazioni contiene l'elenco delle comunicazioni.
    $comunicazioni = API_elencoComunicazioni([], [], $_SESSION);

    foreach ($comunicazioni as $index => $c) {
        $modalId = "modal_" . $index;
        $modalLabelId = "modalLabel_" . $index;
    ?>
    <!-- Trigger -->
    <div class="p-3 border mb-2" data-mdb-toggle="modal" data-mdb-target="#<?php echo $modalId; ?>" style="cursor:pointer;">
        <strong><?php echo htmlspecialchars($c["titolo"]); ?></strong>
        <p>Emessa il: <?php echo htmlspecialchars($c["dataEmissione"]); ?></p>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="<?php echo $modalLabelId; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?php echo $modalLabelId; ?>">
                        <?php echo htmlspecialchars($c["titolo"]); ?>
                    </h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Testo:</strong> <?php echo nl2br(htmlspecialchars($c["testo"])); ?></p>
                    <p><strong>Scadenza:</strong> <?php echo htmlspecialchars($c["dataScadenza"]); ?></p>
                    <p><strong>Letta il:</strong> <?php echo htmlspecialchars($c["dataLettura"]); ?></p>
                    <!-- AGGIUNGERE TUTTI I CAMPI DELLA COMUNICAZIONE E SOPRATTUTTO ATTENZIONE ALLEGATO -->

                </div>
            </div>
        </div>
    </div>
<?php } //FINE FOREACH ?>


    
    </body>
</html>

<?php
}
?>














    


