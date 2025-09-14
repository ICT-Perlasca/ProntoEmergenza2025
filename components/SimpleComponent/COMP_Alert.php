<?php
function COMP_Alert($tipoAlert,$message) {
//    $codice="<div class='col-sm-6 col-md-3 text-center alert-secondary' role='alert'>$message</div>";
     $codice="<center><div class='alert $tipoAlert' role='alert'>$message</div></center>";
    return $codice;
}
?>