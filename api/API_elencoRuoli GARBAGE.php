<?php
require_once("./funzioniDB.php");
/*
//Chiamando l'API si ricevono tutte i ruoli necessari per poter fare un servizio al 118
function API_elencoRuoli($get, $post, $session) {

    // Se non esiste la sessione non si procede
    if (!isset($session["idUtente"])) {
        header('HTTP/1.1 403 Forbidden');
        return [];
    }
        
    // Query per ottenere comunicazioni con tipo
    $sql = "SELECT * FROM ruoli AS r WHERE nome!='istruttore'
        ORDER BY nome;";

    $valori = [];
    $tipi = [];

    $risultato = db_query($sql, $valori, $tipi);
    return $risultato;
}*/
?>