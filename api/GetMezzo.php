<?php
require_once("funzioniDB.php");

function API_GetMezzo($get, $post, $session){
    if(!isset($post['idMezzo']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT * from mezzi WHERE idMezzo=?;";
        $valori = [$post['idMezzo']];
        $tipi = [PDO::PARAM_INT];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}
?>