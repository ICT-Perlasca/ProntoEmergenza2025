<?php
session_start();

if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{
?>
<html>
        <head>
            <base href="./" />
            ....BOOTSTRAP....
        </head>
        <body>
<?php
require_once ("./components/Header/header.php");
require_once ("./components/SimpleComponent/comp.php");
require_once ("./api/elencoComunicazioni.php");
require_once ("./components/SimpleComponent/formRegistrazione.php");

echo COMP_formRegistrazione("form");

?>
</body>
</html>
<?php
}
?>