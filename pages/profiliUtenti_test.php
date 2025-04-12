<?php
    session_start();

    if(!isset($_SESSION['idUtente']) || $_SESSION['tipoUtente'] != 'admin'){
        header("Location: login");
    }else{
?>
<html>
        <head>
            <base href="./" />
            <div class="row">
                <div class="col">col</div>
                <div class="col">col</div>
                <div class="col">col</div>
                <div class="col">col</div>
                </div>
                <div class="row">
                <div class="col-8">col-8</div>
                <div class="col-4">col-4</div>
            </div>
        </head>
        <body>
            <?php
                require_once ("../components/Header/header.php");
                require_once ("../components/SimpleComponent/comp.php");
                require_once ("../api/RitornaUtenti.php");

                echo COMP_header();
                echo COMP_Footer();

                foreach(API_RitornaUtenti([],[], $_SESSION) as $u) {
                    echo COMP_cardUtente($u);
                }
            ?>
        </body>
</html>
<?php
    }
?>