<?php
require_once("./funzioniDB.php");

//Chiamando l'API si ricevono tutte le comunicazioni che hanno idUtente associato uguale all'idUtente della sessione, oppure un messaggio di errore
function API_elencoComunicazioni($get, $post, $session) {

    // Se non esiste la sessione non si procede
    if (!isset($session["idUtente"])) {
        header('HTTP/1.1 403 Forbidden');
        return [];
    }
        
    // Query per ottenere comunicazioni con tipo
    $sql = "SELECT * FROM comunicazioni AS c INNER JOIN tipicomunicazione AS t ON c.idTipo = t.idTipo
        INNER JOIN utenticomunicazioni AS u ON c.idComunicazione = u.idComunicazione WHERE u.idUtente = ? ORDER BY c.dataEmissione DESC;";

    $valori = [
        $session["idUtente"]
    ];

    $tipi = [
        PDO::PARAM_INT,
    ];

    $risultato = db_query($sql, $valori, $tipi);
    return $risultato;
}
?>