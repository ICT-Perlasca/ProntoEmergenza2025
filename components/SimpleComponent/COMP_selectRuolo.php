<?php
require_once ("./api/API_elencoRuoli.php");
/*
recupera tutti i ruoli oppure solo i ruoli associti ad un idUtente
crea codice html per select avente name=1^ parametro 
con option che hanno come value l'idRuolo e visualizzano il nome del ruolo

*/
function COMP_selectRuolo($nameIdSelect,$idUtente=-1){
//byprati: per poter usare dovumenque questa ai (anche in Registrazione utente senza sessione)
// se sessione non è settato faccio finta di passare 'admin' così mi fa vedere tutti i ruoli nella select 
    if (isset($_SESSION['tipoUtente']))
        $session=$_SESSION;
    else
        $session['tipoUtente']='admin';

    if ($idUtente==-1)
        $dati=API_elencoRuoli([],[],$session);//senza parametri quindi ritorna elenco di TUTTI i ruoli
    else
        $ruoli=API_elencoRuoli([],['idUtente'=>$idUtente],$session);//con parametri quindi ritorna elenco dei ruoli di quell'utente

    $select="<select class='form-select p-1' name='$nameIdSelect' id='$nameIdSelect'>";
    foreach($dati as $npla){
        $select.="<option value='".$npla['idRuolo']."'>".$npla['nome']."</option>";
    }
    $select.="</select>";
    return $select;
}
?>