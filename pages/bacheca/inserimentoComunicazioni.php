
<?php
session_start();

if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{
?>
    <html lang="it">
        <?php
            require("./api/apiINScom.php");
            require_once ("./components/Head/head.php");
            echo COMP_head();
        ?>
        <body>
            <?php
                require_once ("./components/Header/header.php");
                require_once ("./components/SimpleComponent/comp.php");
                require_once ("./api/elencoComunicazioni.php");
                require_once ("./components/Footer/footer.php");
                require_once ("./components/SimpleComponent/COMP_Buttons.php");
               
                echo COMP_header($_SESSION);
              
            if(!isset($_POST["Inserisci Comunicazione"]))
            { 
            ?>
            <h2>Inserisci Nuova Comunicazione</h2>
            <form method="POST" action="">
                <label for="titolo">Titolo:</label>
                <input type="text" name="titolo" required>
                <label for="descrizione">Descrizione:</label>
                <textarea name="descrizione" required></textarea>
                <label for="data_scadenza">Scadenza:</label>
                <input type="date" name="data_scadenza" required>
                <label for="allegato">Allegato:</label>
                <input type="text" name="allegato" required>
                <input type="submit" value="Inserisci Comunicazione">
            </form>
            <div id="ris"><?php echo $c; ?></div>
            <?php 
            }
            else
            {
                $c = API_AggiuntaComunicazione($_GET[], $POST_[], $_SESSION[]);
                
            }
                echo COMP_Footer(); 
            ?>
        </body>
    </html>
<?php
}
?>