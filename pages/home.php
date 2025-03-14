<?php
session_start();

if(!isset($_SESSION['idUtente'])){
    header("Location: elenco");
}else{
?>
<html>
        <head>
            <base href="./" />
        </head>
        <body>
<?php
require_once ("./components/Header/header.php");
require_once ("./components/SimpleComponent/comp.php");
require_once ("./api/elencoComunicazioni.php");

echo COMP_header();

foreach(API_elencoComunicazioni([],[], $_SESSION) as $c) {
    echo COMP_simpleComponent($c['id']);
}

?>
</body>
</html>
<?php
}
?>