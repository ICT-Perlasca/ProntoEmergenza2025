<?php
require_once("api/RitornaTipo.php");
require_once("funzioniDB.php");

//Questa funzione permette agli admin di accedere a tutte le comunicazioni presenti nel DB.
function API_tutteComunicazioni($get, $post, $session) {
    // Se non esiste la sessione non si procede
    if (!isset($_SESSION["idUtente"]))
        return ["Nessun utente!"];

    $tipo = API_RitornaTipo([], [], []);

    // Se non esiste il risultato oppure non è admin
    if (empty($tipo) || $tipo[0]['tipoUtente'] !== 'admin') {
        return ["L'utente non è un admin!"];
    }

    // Query per ottenere tutte le comunicazioni
    $sql = "SELECT
            *
        FROM
            comunicazioni c
        INNER JOIN
            tipicomunicazione t ON c.idTipo = t.idTipo
        INNER JOIN
            utenticomunicazioni u ON c.idComunicazione = u.idComunicazione
        ORDER BY
            c.dataEmissione DESC
    ";

    // In questo caso nessun valore da passare
    $comunicazioni = db_query($sql, null, null);

    // Controllo se c'è stato un errore nella query
    if (isset($comunicazioni['error'])) {
        return ["Errore nel recupero delle comunicazioni: " . $comunicazioni['error']];
    }

    // Verifica se ci sono comunicazioni
    if (!empty($comunicazioni)) {
        return $comunicazioni;
    } else {
        return ["Non c'è nessuna comunicazione"];
    }
}

?>