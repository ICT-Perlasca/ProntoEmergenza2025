<?php
require_once ('funzioniDB.php');
    session_start();
    if(isset($_SESSION['idUtente']) && $_SESSION['tipoUtente'] == 'admin'){
        $strSql = "SELECT cogome, nome FROM utenti";
        $utenti = db_query($strSql, [], []);
?>
    <html>
        <head>
            <title>elenco turni</title>
            <script type="text/javascript" src="./public/js/VisualizzaturniUtente.js"></script>
        </head>
        <body>
            <form name = elenco onsubmit="getTurni(elenco);return false;">
                <label>inserisci l'utente</label>
                <selcet name = utente>
                    <?php
                    foreach($utenti as $u)
                    ?>
                        <option value = <?php $u['idUtente'] ?>><?php $u['idUtente']." ".$u['cognome']." ".$u['nome'] ?></option>
                </select>
            </form>
            <div id="ris"></div>
        </body>
    </html>
<?php
    }else{
        header("Location: ");
    }
?>
