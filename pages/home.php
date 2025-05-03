<?php
session_start();

if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{
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
            ?>

            <section class="bg-primary text-white text-center d-flex align-items-center" style="min-height: 500px;">
                <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <h1 class="display-4 fw-bold lh-tight mb-3">Ciao <?php echo $_SESSION['nome']; ?>!</h1>
                            <p class="lead fs-5 fw-light">Come possiamo aiutarti?</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="container mt-4">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <?php
                        echo COMP_Button('person-circle','Profilo','profiloUtente');
                        echo COMP_Button('calendar-date','Calendario','turni');
                        echo COMP_Button('card-list','Bacheca','bacheca');
                        if($_SESSION['tipoUtente'] == 'admin')
                            echo COMP_Button('people-fill','Gestione Utenti','utenti');
                    ?>
                </div>
            </div>

            <?php 
                echo COMP_Footer(); 
            ?>
        </body>
    </html>
<?php
}
?>
