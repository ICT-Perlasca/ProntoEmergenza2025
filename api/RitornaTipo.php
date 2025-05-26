<?php
require_once("funzioniDB.php");

//API che controlla che tipo sia l'utente, ritorna il tipo in un array oppure un errore.
function API_RitornaTipo ($get, $post, $session) {
    $sqlVer = "SELECT
            tipoUtente
        FROM
            utenti
        WHERE
            idUtente = ?
    ";

    $valoriVer = [
        $_SESSION["idUtente"]
    ];

    $tipiVer = [
        PDO::PARAM_INT
    ];

    $tipo = db_query($sqlVer, $valoriVer, $tipiVer);

    // Controllo se c'è stato un errore nella query
    if (isset($tipo['error'])) {
        return ["Errore nella verifica dell'utente: " . $tipo['error']];
    }

    return $tipo;
}