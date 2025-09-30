<?php
require_once("funzioniDB.php");
function API_getUtente($get, $post, $session){
  // if(!isset($post['emailUt']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
  //situazione di errore x cui non restituisco i dati dell'utente
  // non sono loggato oppure (sono loggato e non sono admin e email passata e diversa da email in sessione)
    $email=(isset($get['emailUt']))?$get['emailUt']:$post['emailUt'];
    if (!isset($session['tipoUtente'])||(isset($session['tipoUtente']) && $session['tipoUtente']!="admin" && $email!=$session['email'])){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }
    else{
        $sql = "SELECT * from utenti WHERE email=?;";
        $valori = [$post['emailUt']];
        $tipi = [PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}

?>