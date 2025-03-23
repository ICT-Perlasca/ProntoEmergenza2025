<?php
session_start();

if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{
?>
<html>
        <head>
            <base href="./" />
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
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
