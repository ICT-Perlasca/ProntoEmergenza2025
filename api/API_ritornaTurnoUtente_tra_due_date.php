<?php
require_once("funzioniDB.php");

function API_ritornaTurnoUtente_tra_due_date($get, $post, $session){
    if(!isset($post['idUtente']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT t.idTurno118, u.nome, u.cognome, t.data, t.oraInizio, t.oraFine
            FROM turniutenti AS tu INNER JOIN turni118 AS t ON tu.idTurno118 = t.idTurno118
            INNER JOIN utenti as u ON tu.idUtente = u.idUtente
            WHERE tu.idUtente = ? AND t.data BETWEEN ? AND ? ORDER BY t.data;";
        $valori = [$post['idUtenteSel'], $post['data1'], $post['data2']];
        $tipi = [PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}
?>