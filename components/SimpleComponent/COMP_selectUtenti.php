<?php
require_once ("./api/API_ritornaUtenti.php");
/*
recupera tutti gli utenti
crea codice html per select avente name=1^ parametro 
con option che hanno come value l'idUtente e visualizzano il cognome e nome

*/
function COMP_selectUtenti($nameSelect){
    $dati=API_ritornaUtenti([],[],$_SESSION);//senza parametri quindi ritorna elenco di TUTTI gli utenti
    $select="<select name='".$nameSelect."'>";
    foreach($dati as $npla){
        $select.="<option value='".$npla['idUtente']."'>".$npla['cognome']." ".$npla['nome']."</option>";
    }
    $select.="</select>";
    return $select;
}
?>