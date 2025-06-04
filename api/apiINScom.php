<?php
require_once("funzioniDB.php");
require_once("API_upload_img.php");
function API_AggiuntaComunicazione($get, $post, $session){
    $ctrlImg = upload("","", $session);
    echo "Controllo immagine: " . $ctrlImg . "\n";
    if($ctrlImg == false)
    {
        echo json_encode(["errore" => "file non compatibile"]);
        return;       
    }
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(["errore" => "Accesso negato"]);
        return;
    }

    if (!isset($post['titolo'], $post['descrizione'], $post['data_scadenza'], $post['tipo'])) {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(["errore" => "Dati mancanti"]);
        return;
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
        echo json_encode(["successo" => true]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(["errore" => "Errore nel database"]);
    }
}
?>