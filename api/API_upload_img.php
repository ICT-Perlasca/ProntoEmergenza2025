<?php
function upload($get, $post, $session)
{
    if (!isset($_FILES['file'])) 
    {
        return false; 
    }

    $foto = $_FILES['file'];
    $estensioni = ['jpg', 'jpeg', 'png'];
    $dimensioneMassima = 3 * 1024 * 1024; // 3MB
    $percorso = "";
    $result = false;

    $estensione = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    if (!in_array($estensione, $estensioni)) 
    {
        return false; 
    }
    if ($foto['size'] > $dimensioneMassima) 
    {
        return false; 
    }
    if (!is_uploaded_file($foto['tmp_name'])) 
    {
        return false; 
    }
    $ts = new DateTime("now");
    $cartella = '../uploads/images/';
    if (!file_exists($cartella)) 
    {
        mkdir($cartella, 0755, true);
    }
    $nomeFile = $session['username'] . "_" . $ts->getTimestamp() . "." . $estensione;
    $percorso = $cartella . $nomeFile;
    if (move_uploaded_file($foto['tmp_name'], $percorso)) 
    {
        $result = $nomeFile;
    }

    return $result;
}
?>
