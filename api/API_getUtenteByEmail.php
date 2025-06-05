<?php
require_once("funzioniDB.php");
function API_GetUtente($get, $post, $session){
   if(!isset($post['emailUt']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT * from utenti WHERE email=?;";
        $valori = [$post['emailUt']];
        $tipi = [PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}

?>