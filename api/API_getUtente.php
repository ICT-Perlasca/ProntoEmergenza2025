<?php
require_once("funzioniDB.php");
function API_getUtenteByEmail($get, $post, $session){
  // if(!isset($post['emailUt']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
  //situazione di errore x cui non restituisco i dati dell'utente
  // non sono loggato oppure (sono loggato e non sono admin e email passata e diversa da email in sessione)
  if (isset($get['emailUt']))
    $email=$get['emailUt'];
  else
    if (isset($post['emailUt'])) 
        $email=$post['emailUt'];
    else
        $email=$session['email']; 
    
//  $email=(isset($get['emailUt']))?$get['emailUt']:$post['emailUt'];
    if (!isset($session['tipoUtente'])||(isset($session['tipoUtente']) && $session['tipoUtente']!="admin" && $email!=$session['email'])){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }
    else{
        $sql = "SELECT u.*,GROUP_CONCAT(r.nome) as ruoli from (utenti as u inner join utentiruoli as ur on u.idUtente=ur.idUtente) inner JOIN ruoli as r on ur.idRuolo=r.idRuolo WHERE u.email=? group by u.idUtente";
        $valori = [$email];
        $tipi = [PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}
function API_getUtenteById($get, $post, $session){
    //situazione d'errore: o nomi è arrivato idUtente via post o utente non loggato
   if(!isset($post['idUtente']) || !isset($session['tipoUtente'])){// || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        if (isset($get['idUtente']))
            $idUtente=$get['idUtente'];
        else
            if (isset($post['idUtente'])) 
                $idUtente=$post['idUtente'];
            else
                $idUtente=$session['idUtente']; 
            
        $sql = "SELECT u.*,GROUP_CONCAT(r.nome) as ruoli from (utenti as u inner join utentiruoli as ur on u.idUtente=ur.idUtente) inner JOIN ruoli as r on ur.idRuolo=r.idRuolo WHERE u.idUtente=?;";
        $valori = [$idUtente];
        $tipi = [PDO::PARAM_INT];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}

?>