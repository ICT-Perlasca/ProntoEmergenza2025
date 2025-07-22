<?php
require_once("../../funzioniDB.php");
function API_elencoUtentiRuolo($get, $post, $session){
  // if(!isset($post['emailUt']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
  //situazione di errore x cui non restituisco i dati dell'utente
  // non sono loggato oppure (sono loggato e non sono admin e email passata e diversa da email in sessione)

   if (!isset($session['tipoUtente'])||(isset($session['tipoUtente']) && $session['tipoUtente']!="admin" && $email!=$session['email'])){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }
    else{
        $ruolo=$post['ruolo'];
        $sql = "SELECT u.idUtente as idUtente, u.cognome as cognome, u.nome as nome from (utenti as u inner join utentiruoli as ur on u.idUtente=ur.idUtente) inner join ruoli as r on ur.idRuolo=r.idRuolo WHERE r.nome=?;";
        $valori = [$post['ruolo']];
        $tipi = [PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}

?>