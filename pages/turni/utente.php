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
            <?php
                require_once ("./components/Footer/footer.php");
                require_once ("./components/Header/header.php");
            ?>
        </head>
        <?php
            require_once ("./components/Head/head.php");
            echo COMP_head();
        ?>
        <body>
            <?php echo COMP_header($_SESSION); ?>
            
            <form name="elenco" onsubmit="getTurni(this); return false;">
                <label>Inserisci l'utente</label>
                <select name="utente">
                    <?php foreach ($utenti as $u): ?>
                        <option value="<?= $u['idUtente'] ?>">
                            <?= $u['idUtente'] . " " . $u['cognome'] . " " . $u['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <div id="ris"></div>
            <?php 
                echo COMP_Footer(); 
            ?>
            
        </body>
    </html>
<?php
    }else{
        header("Location: ");
    }
?>