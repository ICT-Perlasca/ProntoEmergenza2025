<?php
require_once("funzioniDB.php");

function API_RitornaUtenti($get, $post, $session){
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT * from utenti ORDER BY cognome,nome;";
        $valori = [];
        $tipi = [];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}  
?>
