<?php
require_once("funzioniDB.php");

//Questa funzione permette agli admin di accedere a tutte le comunicazioni presenti nel DB.
function API_tutteComunicazioni($get, $post, $session) {
    // Se non esiste la sessione non si procede
    if (!isset($session["idUtente"])) {
        header('HTTP/1.1 403 Forbidden');
        return [];
    } else {
        // Query per ottenere tutte le comunicazioni
        $sql = "SELECT c.*, t.nome, u.dataLettura
        FROM comunicazioni AS c 
        INNER JOIN tipicomunicazione AS t ON c.idTipo = t.idTipo 
        INNER JOIN utenticomunicazioni AS u ON c.idComunicazione = u.idComunicazione 
        ORDER BY c.dataEmissione DESC;";

        // In questo caso nessun valore da passare
        $comunicazioni = db_query($sql, null, null);

        return $comunicazioni;
    }   
}

?>