<?php
require_once("funzioniDB.php");

function API_elencoEventiPrevisti($get, $post, $session){
    if(!isset($post['idUtente'])){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT DISTINCT idEventoProgrammato, data, oraInizio, oraFine, luogo, nomeRichiedente, cognomeRichiedente, idMezzo
                FROM eventiprogrammati
                WHERE data BETWEEN ? AND ?
                ORDER BY data DESC, oraInizio DESC;";
        $valori = [$post['data']];
        $tipi = [PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}
?>