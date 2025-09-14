<?php
require_once("./globals.php");
function API_upload($get, $post, $session)
{
    global $cartellaImmagini;
    if (!isset($_FILES['file'])) 
    {
        return (['error'=>'non è stato trasferito alcun file']); 
    }

    $fileUp = $_FILES['fileUp'];
    $estensioni = ['jpg', 'jpeg', 'png','pdf'];
    $dimensioneMassima = 3 * 1024 * 1024; // 3MB
    $percorso = "";
    $result = false;

    $estensione = strtolower(pathinfo($fileUp['name'], PATHINFO_EXTENSION));
    if (!in_array($estensione, $estensioni)) 
    {
        return (['error'=>'estensione non ammessa']);
    }
    if ($fileUp['size'] > $dimensioneMassima) 
    {
        return (['error'=>'dimensione troppo grande del file']); 
    }
    if (!is_uploaded_file($fileUp['tmp_name'])) 
    {
        return (['error'=>'sul server non è stato trasferito alcun file']); 
    }
    $ts = new DateTime("now");
    $cartella = "./$cartellaImmagini/";
    if (!file_exists($cartella)) 
    {
        mkdir($cartella, 0755, true);
    }
    $nomeFile = $session['username'] . "_" . $ts->getTimestamp() . "." . $estensione;
    $percorso = $cartella . $nomeFile;
    if (move_uploaded_file($fileUp['tmp_name'], $percorso)) 
    {
        $ret['success']='file trasferito con successo';
        $ret['nomeFile']=$nomeFile;
        return $ret;
    }else{
        return (['error'=>'file non copiato nella cartella di destinazione']);
        //$result = "Errore durante il caricamento del file.";
    }

    //return $result;
}
?>
