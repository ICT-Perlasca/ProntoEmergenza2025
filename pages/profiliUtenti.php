<?php
    session_start();

    if(!isset($_SESSION['idUtente']) || $_SESSION['tipoUtente'] != 'admin'){
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
require_once ("./api/RitornaUtenti.php");

echo COMP_header();

foreach(API_RitornaUtenti([],[], $_SESSION) as $u) {
    echo COMP_simpleComponent($u['id']);
}

?>
</body>
</html>
<?php
    }
?>