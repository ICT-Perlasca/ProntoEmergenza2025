<?php
require_once("funzioniDB.php");
require_once("API_upload_img.php");
function API_AggiuntaComunicazione($get, $post, $session){
    $ctrlImg = upload("","", $session);
    // echo "Controllo immagine: " . $ctrlImg . "\n";
    if($ctrlImg == false)
    {
        return ["errore" => "file non compatibile"];
    }
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header('HTTP/1.1 403 Forbidden');
        return  ["errore" => "Accesso negato"];
    }

    if (!isset($post['titolo'], $post['descrizione'], $post['data_scadenza'], $post['tipo'])) {
        header('HTTP/1.1 400 Bad Request');
        return ["errore" => "Dati mancanti"];
    }

    $sql = "INSERT INTO comunicazioni (titolo, testo, dataScadenza, idTipo, dataEmissione, nomeFileAllegato, idUtente) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $valori = [
        $post['titolo'],
        $post['descrizione'],
        $post['data_scadenza'],
        $post['tipo'],
        date("Y-m-d"),
        $ctrlImg,
        $session['idUtente']
    ];

    $tipi = [
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_INT,
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_INT
    ];

    $risposta = db_query($sql, $valori, $tipi);

    if ($risposta) {
        return ["successo" => true];
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        return ["errore" => "Errore nel database"];
    }
}
?>