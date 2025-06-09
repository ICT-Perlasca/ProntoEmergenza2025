<?php
session_start();
if(!isset($_SESSION['idUtente']))
    header("Location: login");
else{
    if (isset($_GET['emailUt']) || isset($_SESSION['email']))
    {
?>
        <html>
        <?php
        require_once ("./components/Head/head.php");
        echo COMP_head();
        ?>
        <body>
        <?php
        require_once ("./components/Header/header.php");
        require_once ("./components/Footer/footer.php");
        require_once ("./components/profiloUtenteSingolo/COMP_profiloUtenteSingolo.php");

        echo COMP_header($_SESSION);

        if(isset($_GET['emailUt']))
            $email=$_GET['emailUt'];
        else
            $email=$_SESSION['email'];

        $codice=CMP_profiloUtenteSingolo($email);
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