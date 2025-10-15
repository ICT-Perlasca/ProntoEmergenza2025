<?php
session_start();

if (!isset($_SESSION['idUtente'])) {
    header("Location: login");
} else {
?>
<!DOCTYPE html>
<html lang="it">
    <?php
        require("././api/API_aggiuntaComunicazione.php");
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
            //require_once("./components/SimpleComponent/COMP_Alert.php");
            require_once("./components/SimpleComponent/COMP_inserimentoComunicazione.php");
            
            echo COMP_header($_SESSION);

            echo COMP_inserimentoComunicazione($_SESSION['tipoUtente']);

           
            echo COMP_Footer();
        ?>
    </body>
</html>
<?php
}
?>