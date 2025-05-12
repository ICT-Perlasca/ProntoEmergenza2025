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
        $session["idUtente"]
    ];

    $tipiVer = [
        PDO::PARAM_INT
    ];

    $tipo = db_query($sqlVer, $valoriVer, $tipiVer);

    return $tipo;
}