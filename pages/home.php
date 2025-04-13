<?php
session_start();

if(!isset($_SESSION['nome'])){
    header("Location: login");
}else{
?>
<html>
        <head>
            <base href="./" />
            <link href="./public/css/bootstrap.min.css" rel="stylesheet"/>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        </head>
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
