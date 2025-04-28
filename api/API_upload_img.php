<?php
function upload($foto) 
{
    $estensioni = ['jpg', 'jpeg', 'png'];
    $dimensioneMassima = 3 * 1024 * 1024; //dimensione massima 5 MB
    $estensione = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $percorso = "";
    $result = false;

    if (in_array($estensione, $estensioni)) {
        if ($foto['size'] <= $dimensioneMassima) {
            if (is_uploaded_file($foto['tmp_name'])) {
                $ts = new DateTime("now");
                $cartella = '../uploads/images/';
                $nomeFile = $_SESSION['username'] . "_" . $ts->getTimestamp() . "." . $estensione;
                $percorso = $cartella . $nomeFile;

                if (move_uploaded_file($foto['tmp_name'], $percorso)) {
                    $result = $nomeFile;
                }
            }
        }
    }

    return $result;
}
?>
