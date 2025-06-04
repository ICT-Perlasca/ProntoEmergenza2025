<?php
require_once("funzioniDB.php");

function API_ElencoTurniConvalidatiUtente($get, $post, $session){
    if(!isset($post['idUtente']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT t.idTurno118 AS id, t.data, t.oraInizio, t.oraFine, 'Turno 118' AS tipo_turno, tu.convalidato
                FROM turniutenti tu
                JOIN turni118 t ON tu.idTurno118 = t.idTurno118
                WHERE tu.idUtente = ? AND tu.convalidato = 1 AND MONTH(t.data) = ? AND YEAR(t.data) = ?

                UNION

                SELECT
                e.idEventoProgrammato AS id, e.data, e.oraInizio, e.oraFine, 'Evento Programmato' AS tipo_turno, tu.convalidato
                FROM eventiprogrammati e
                JOIN turniutenti tu ON e.idEventoProgrammato = tu.idEventoProgrammato
                WHERE tu.idUtente = ? AND tu.convalidato = 1 AND MONTH(e.data) = ? AND YEAR(e.data) = ?

                UNION

                SELECT a.idAssistenza AS id, a.data, a.oraInizio, a.oraFine, 'Assistenza' AS tipo_turno, tu.convalidato
                FROM assistenze a
                JOIN turniutenti tu on a.idAssistenza = tu.idTurnoUtente
                WHERE tu.idUtente = ? AND tu.convalidato = 1 AND MONTH(a.data) = ? AND YEAR(a.data) = ?
                ORDER BY data, tipo_turno;";
        $valori = [$post['idUtenteSel'], $post['data']];
        $tipi = [PDO::PARAM_INT, PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}