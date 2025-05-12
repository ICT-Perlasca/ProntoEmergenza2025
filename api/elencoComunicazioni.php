<?php
require_once("funzioniDB.php");

//Chiamando l'API si ricevono tutte le comunicazioni che hanno idUtente associato uguale all'idUtente della sessione, oppure un messaggio di errore
function API_elencoComunicazioni($get, $post, $session) {

    // Se non esiste la sessione non si procede
    if (!isset($session["idUtente"]))
        return ["Nessun utente!"];
 
    // Query per ottenere comunicazioni con tipo
    $sql = "SELECT
            *
        FROM
            comunicazioni AS c
        INNER JOIN
            tipicomunicazione AS t ON c.idTipo = t.idTipo
        INNER JOIN
            utenticomunicazioni AS u ON c.idComunicazione = u.idComunicazione
        WHERE
            u.idUtente = ?
        ORDER BY
            c.dataEmissione DESC
    ;";

    $valori = [
        $session["idUtente"]
    ];

    $tipi = [
        PDO::PARAM_INT, // idUtente
    ];

    $risultato = db_query($sql, $valori, $tipi);

    // Gestione del risultato
    if (isset($risultato['error'])) {
        return ["Non e' stato possibile connettersi al DB: " . $risultato['error']];
    }

    if (count($risultato) > 0) {
        return $risultato;
    } else {
        return ["Non c'e' nessuna comunicazione relazionata a questo id"];
    }
}
?>