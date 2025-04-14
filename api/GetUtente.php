<?php
function API_GetUtente($get, $post, $session){
    require_once("./funzioniDB.php");
    if(!isset($post['idUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT * from utenti WHERE idUtente=?;";
        $valori = [$post['idUtente']];
        $tipi = [PDO::PARAM_INT];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}

?>
