<?php
require_once("funzioniDB.php");

function API_elencoOreUtenteMensile($get, $post, $session){
    if(!isset($post['idUtente']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT MONTH(t.data) AS mese, YEAR(t.data) AS anno, SUM(TIMESTAMPDIFF(MINUTE, t.oraInizio, t.oraFine)) AS minuti_totali 
        FROM turniutenti tu JOIN turni118 t ON tu.idTurno118 = t.idTurno118 
        WHERE tu.idUtente = ? 
        GROUP BY mese, anno 
        ORDER BY mese, anno;";
        $valori = [$post['idUtenteSel']];
        $tipi = [PDO::PARAM_INT, PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}
?>