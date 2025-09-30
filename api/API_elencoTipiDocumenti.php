<?php
require_once "./funzioniDB.php";
    //require_once("../../funzioniDB.php");
function API_elencoTipiDocumenti($get, $post, $session){
    //prati: può esserechiamata sia su utente admin che su utente user x cui controllo solo la sessione esistente
    if (!isset($session['tipoUtente'])){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
       /* prati: elenco tipi dei documenti
    per qulsiasi utete carico i tipidi documenti recuperati dal DB
    
    */
        $strsql="select * from tipidocumenti";
        $risposta = db_query($strsql, [],[]);
        return $risposta;
    }
}

?>
