<?php
require_once "./api/API_elencoTipiDocumenti.php";
/*
recupera tutti i dati della tabella tipidocumenti
crea codice html per select avente name=1^ parametro 
con option che hanno come value l'idTipoDocumento e visualizzano la descrizione

*/
function COMP_selectTipiDocumenti($nameIdSelect){
//byprati: per poter usare dovumenque questa api (anche in Registrazione utente senza sessione)
// se sessione non è settato faccio finta di passare 'admin' così mi fa vedere tutti i tipi di dcumenti nella select 
    if (isset($_SESSION['tipoUtente']))
        $session=$_SESSION;
    else
        $session['tipoUtente']='admin';

    
    $dati=API_elencoTipiDocumenti([],[],$session);//senza parametri quindi ritorna elenco di TUTTI i ruoli   

    $select="<select class='form-select p-1' name='$nameIdSelect' id='$nameIdSelect' required>";
    foreach($dati as $npla){
        $select.="<option value='".$npla['idTipoDocumento']."'>".$npla['descrizione']."</option>";
    }
    $select.="</select>";
    return $select;
}
?>