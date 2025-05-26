<?php
require_once("funzioniDB.php");

function API_ElencoCompleanni($get, $post, $session){
    if(!isset($post['idUtente'])){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT idUtente, nome, cognome, dataNascita, status, immagine 
                FROM utenti 
                WHERE MONTH(dataNascita) = ?
                ORDER BY dataNascita;";
        $valori = [$post['dataNascita']];
        $tipi = [PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}