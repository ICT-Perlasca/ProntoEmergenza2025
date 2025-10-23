<?php
require_once ("./components/Head/head.php");
require_once ("./components/Header/header.php");
require_once ("./components/Footer/footer.php");
require_once ("./components/profiloUtenteSingolo/COMP_profiloUtenteSingolo.php");
require_once("./api/API_getUtente.php");
require_once("./funzioniDB.php");

session_start();
if(!isset($_SESSION['idUtente']))
    header("Location: login");
else{
    if (isset($_GET['emailUt']) || isset($_SESSION['email']))
    {
        if(isset($_GET['emailUt']))
            $email=$_GET['emailUt'];
        else
            $email=$_SESSION['email'];

        //recupero idUtente dal DB
        $datiUtente=API_getUtenteByEmail(['emailUt'=>$email],[],$_SESSION);
        //memorizza nel cookie idUtenteUpdate x utente da modificare
        setcookie("idUtenteUpdate",$datiUtente[0]['idUtente']);


?>
    <html>
    <?php
        echo COMP_head();
    ?>
    <body>
    <?php     
        echo COMP_header($_SESSION);

        $codice=COMP_profiloUtenteSingolo($datiUtente);
        if ($codice=="")
            echo COMP_Alert("utente non autorizzato a vedere il profilo");
        else
            echo $codice;

        echo COMP_Footer();
    ?>
    </body>
    </html>
<?php
    }  
}
?>