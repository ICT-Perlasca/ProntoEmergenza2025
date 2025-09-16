<?php
require_once ("./api/API_ritornaUtenti.php");
/*
recupera tutti gli utenti
crea codice html per select avente name=1^ parametro 
con option che hanno come value l'idUtente e visualizzano il cognome e nome

*/
function COMP_selectUtenti($nameIdSelect){
    $dati=API_ritornaUtenti([],[],$_SESSION);//senza parametri quindi ritorna elenco di TUTTI gli utenti
    $select="<select class='form-select p-1' name='$nameIdSelect' id='$nameIdSelect'>";
    foreach($dati as $npla){
        $select.="<option value='".$npla['idUtente']."'>".$npla['cognome']." ".$npla['nome']."</option>";
    }
    $select.="</select>";
    return $select;
}
?>