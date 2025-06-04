<?php
session_start();

if (!isset($_SESSION['idUtente'])) {
    header("Location: login");
} else {
?>
<!DOCTYPE html>
<html lang="it">
    <?php
        require("././api/apiINScom.php");
        require_once("./components/Head/head.php");
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

            echo COMP_header($_SESSION);

            if (!isset($_POST["inserisciComunicazione"])) {
                $tipi = db_query("SELECT nome, idTipo FROM tipicomunicazione", [], []);
        ?>
        <div class="container py-5">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-lg animate__animated animate__fadeInDown">
                        <div class="card-body p-4">
                            <h3 class="text-center mb-4">
                                <i class="fas fa-bullhorn me-2 text-primary"></i> Inserisci Comunicazione
                            </h3>
                            <form method="POST" action="" class="needs-validation" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="titolo" class="form-label">Titolo</label>
                                    <input type="text" class="form-control" id="titolo" name="titolo"
                                        required
                                        oninvalid="this.setCustomValidity('Inserisci un titolo')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label for="descrizione" class="form-label">Descrizione</label>
                                    <textarea class="form-control" id="descrizione" name="descrizione" rows="3"
                                        required
                                        oninvalid="this.setCustomValidity('Inserisci una descrizione')"
                                        oninput="this.setCustomValidity('')"></textarea>
                                </div>
                                <div class="mb-3">
                                    <select name="tipo" class="form-select p-1">
                                        <option>Scegli tipo Comunicazione</option>
                                        <?php
                                            foreach ($tipi as $tipo) {
                                                echo "<option value='{$tipo['idTipo']}'>{$tipo['nome']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="data_scadenza" class="form-label">Scadenza</label>
                                    <input type="date" class="form-control" id="data_scadenza" name="data_scadenza"
                                        required
                                        oninvalid="this.setCustomValidity('Seleziona una data di scadenza')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <div class="mb-3">
                                    <label for="allegato" class="form-label">Allegato</label>
                                    <input type="file" class="form-control" id="allegato" name="file"
                                        required
                                        oninvalid="this.setCustomValidity('Inserisci un allegato (es: link o nome file)')"
                                        oninput="this.setCustomValidity('')">
                                </div>
                                <button name="inserisciComunicazione" type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Invia Comunicazione
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            } else {
                $res = API_AggiuntaComunicazione($_GET, $_POST, $_SESSION);

                if(isset($res['errore'])){
                    echo '<div class="alert alert-danger" role="alert">'.
                        $res['errore'].
                    '</div>';
                }else{
                    echo '<div class="alert alert-success" role="alert">
                        Comunicazione inserita
                    </div>';
                }
            }

            echo COMP_Footer();
        ?>
    </body>
</html>
<?php
}
?>