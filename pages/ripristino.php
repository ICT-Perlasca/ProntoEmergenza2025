<?php
    session_start();

    require_once ("./api/richiestaRipristino.php");
    require_once ("./components/Ripristino/formEmail.php");
    require_once ("./components/Ripristino/formPassword.php");
?>

<html lang="it">
    <?php
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

            if (isset($_GET["token"]))
                $token = base64_decode($_GET["token"]);
            else
                $token;
        
            if (!isset($token)) {
                echo COMP_formRichiestaEmail();
            } else {
                list($email, $hash, $time) = explode("-", $token);
                if ($time < time() + 3600) {
                    if (checkEmail($email) > 0 && md5($email) === $hash) {
                        echo COMP_formResetPassword(trim(base64_encode($email ."-". md5($email)), "="));
                    } else {
                        echo "email manomessa.";
                    }
                } else {
                    echo "sessione scaduta.";
                }
            }

            echo COMP_Footer();
        ?>
    </body>
</html>