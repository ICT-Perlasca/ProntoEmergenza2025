<?php
require_once ("./api/API_elencoRuoli.php");
/*
recupera tutti i ruoli oppure solo i ruoli associti ad un idUtente
crea codice html per select avente name=1^ parametro 
con option che hanno come value l'idRuolo e visualizzano il nome del ruolo

*/
function COMP_checkRuolo($nameBlocco,$idUtente){
//byprati: per poter usare dovumenque questa ai (anche in Registrazione utente senza sessione)
// se sessione non è settato faccio finta di passare 'admin' così mi fa vedere tutti i ruoli nella select 
    if (isset($_SESSION['tipoUtente']))
        $session=$_SESSION;
    else
        $session['tipoUtente']='admin';

    //tutti i ruoli
    $ruoli=API_elencoRuoli([],[],$session);//senza parametri quindi ritorna elenco di TUTTI i ruoli
    //solo i ruoli dell'utente
    $dati=API_elencoRuoli([],['idUtente'=>$idUtente],$session);//con parametri quindi ritorna elenco dei ruoli di quell'utente

    $bloccoCheck="";
    
    foreach($ruoli as $npla){
        if (array_search($npla['idRuolo'],array_column($dati, 'idRuolo'))!==false)
            // il ruolo generico è ruolo dell'utente
            $sel="checked";
        else
            $sel="";
        $bloccoCheck.='<input type="checkbox" name="'.$nameBlocco.'" value="'.$npla['idRuolo'].'" '.$sel.'> '.$npla['nome'].'<br>';
    }
    return $bloccoCheck;
}
?>