<?php
    require_once("./funzioniDB.php");
    
function API_ritornaUtenti($get, $post, $session){
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        /*byprati:
        se è stato definito il ruolo utente in POST
        allora 
            la query cerca utenti con tale ruolo
        altrimenti
             la query cerca tutti gli utenti
        fse
        */
        if (isset($_POST['idRuolo'])){ //memorizza idRuolo
            $sql = "SELECT * from utenti as u inner join utentiruoli as ur on u.idUtente=ur.idUtente  where ur.idRuolo=? ORDER BY cognome,nome;";
            $valori = [$_POST['idRuolo']];
            $tipi = [PDO::PARAM_INT];
        }
        else{
            $sql = "SELECT * from utenti ORDER BY cognome,nome;";
            $valori = [];
            $tipi = [];
        }
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}

?>
