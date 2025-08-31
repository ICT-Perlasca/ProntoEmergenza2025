<?php
    require_once("../../funzioniDB.php");
function API_elencoRuoli($get, $post, $session){
    //prati: può esserechiamata sia su utente admin che su utente user x cui controllo solo la sessione esistente
    if (!isset($session['tipoUtente'])){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
       /* prati: elenco ruoli da visualizzare
    se utente è admin non mi arriva in POST l'id del ruolo
    allora
        recupero dal DB tutti i ruoli
    altrimenti
        recupero dalDB solo i ruoli dell'utente user loggato
    fse
    carico i ruoli recuperati dal DB
    
    */
        if ($session['tipoUtente']==='admin'){
            $strsql="select * from ruoli";
            $dati=[];
            $tipi=[];
        }
        else {
            $strsql="select * from ruoli where idRuolo in (select idRuolo from utenti as u inner join utentiruoli as ur on u.idUtente=ur.idUtente where u.idUtente=?)";
            $dati=[$post['idUtente']];
            $tipi=[PDO::PARAM_INT];
        }
        $risposta = db_query($strsql, $dati,$tipi);
        return $risposta;
    }
}

?>
