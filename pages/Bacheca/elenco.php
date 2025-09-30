<?php
    session_start();

    if (!isset($_SESSION['idUtente'])) {
        header("Location: ../login");
    } else {
        require_once ("api/API_elencoComunicazioni.php");
        require_once ("api/TutteComunicazioni.php");
        require_once ("components/Head/head.php");
        require_once ("components/Header/header.php");
        require_once ("components/Footer/footer.php");
        require_once("./globals.php");
?>

<!DOCTYPE html>
<html lang = "it">

    <?php echo COMP_head(); ?>
    
    <body>
        
    <?php
    echo COMP_header($_SESSION);
    ?>

        <div class="col-12 d-flex flex-column align-items-center pt-3" style="min-height: 80vh;">

        <?php

        $comunicazioni = API_elencoComunicazioni([], [], $_SESSION);

        foreach ($comunicazioni as $index => $c) {
            $modalId = "modal_" . $index;
            $modalLabelId = "modalLabel_" . $index;
        ?>

            <!-- Riga comunicazione -->
            <div class="col-11 col-sm-9 p-3 border my-2 d-flex flex-row" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>" style="cursor:pointer;">
                <div class="col-1 d-flex justify-content-center align-items-center" style="font-size: 2rem;">
                    <?php
                    echo isset($c['dataLettura']) ? '<i class="bi bi-envelope-open"></i>' : '<i class="bi bi-envelope"></i>';
                    ?>
                </div>
                <div class="col-11 d-flex flex-column">
                    <div>
                        <span class="text-primary"><?php echo $c['nome']; ?></span> - <strong><?php echo $c['titolo']; ?></strong>
                    <?php   
                    if (isset($c['nomeFileAllegato']) && strcmp($c['nomeFileAllegato'],"")!=0)
                        echo "<strong> ( Allegato ) </strong>";
                    ?>
                    </div>
                    Emessa il: <?php echo date("d/m/Y", strtotime($c["dataEmissione"])); ?>
                </div>
            </div>
            
            <?php
            if(!isset($c['dataLettura'])){
                ?>
                <script>
                    document.querySelector("[data-bs-target='#<?php echo $modalId; ?>']").addEventListener("click", function(){
                        var xhttp = new XMLHttpRequest();
                        xhttp.open("POST", "api/segnarecomunicazioneletta", true);
                        xhttp.withCredentials = true;
                        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                // Typical action to be performed when the document is ready
                            }
                        };
                        const data = `idComunicazione=${encodeURIComponent(<?php echo  $c['idComunicazione']; ?>)}`;
                        xhttp.send(data);
                    })
                </script>
                <?php
            }
            ?>    

            <!-- Modal -->
            <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="<?php echo $modalLabelId; ?>">
                                <?php echo htmlspecialchars($c["titolo"]); ?>
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Scadenza:</strong> <?php echo date("d/m/Y", strtotime($c["dataScadenza"])); ?></p>
                            <p>
                                <?php echo htmlspecialchars($c["testo"]); ?>
                            </p>

                        </div>
                        <div class="modal-footer">
                            <?php
                               if(isset($c['nomeFileAllegato']) && strcmp($c['nomeFileAllegato'],"")!=0){
                                    echo "<a href='/$cartellaBacheca/".$c['nomeFileAllegato']."' download='".$c['nomeFileAllegato']."'>
                                        Scarica allegato
                                    </a>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
        </div>
 <?php
  echo COMP_Footer();
 ?>


    </body>
</html>

<?php
    }    
?>