<?php
session_start();

if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{
?>
<html>
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

echo COMP_header($_SESSION);

foreach(API_elencoComunicazioni([],[], $_SESSION) as $c) {
    echo COMP_simpleComponent($c['id']);
}

echo COMP_Footer();
?>
</body>
</html>
<?php
}
?>
