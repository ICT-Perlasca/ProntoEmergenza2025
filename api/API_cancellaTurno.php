<?php
require_once ('./funzioniDB.php');

function API_cancellaTurno($get, $post, $session){
    $idT = $post['idTurnoUtente'];

    $query = "delete from turniutenti where idTurnoUtente=?";
    $ret= db_query($query, [$idT], [PDO::PARAM_INT]); //restituisce numRow oppure error
   
    return $ret;
}
?>