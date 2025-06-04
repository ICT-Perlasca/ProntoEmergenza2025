<?php
require_once("funzioniDB.php");

function API_ElencoTurniAnnoPrecedente($get, $post, $session){
    if(!isset($post['idUtente']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT data, 'Turno utente' AS tipo_turno, oraInizio AS oraInizio, oraFine AS oraFine
                FROM turni118
                WHERE YEAR(data) = YEAR(CURDATE()) - 1
                
                UNION
                
                SELECT data, 'Turno 118' AS tipo_turno, oraInizio AS oraInizio, oraFine AS oraFine
                FROM turni118
                WHERE YEAR(data) = YEAR(CURDATE()) - 1
                ORDER BY MONTH(data), DAY(data), tipo_turno;";
        $valori = [];
        $tipi = [];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}