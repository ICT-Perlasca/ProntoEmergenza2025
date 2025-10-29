<?php

function COMP_passwordField($id, $name) {
    $strJs="(document.getElementById('$id').type==='password')?document.getElementById('$id').type='text':document.getElementById('$id').type='password'";
    return '<div class="d-flex ps-3">
    <input type="password" name="'.$name.'" id="'.$id.'" class="form-control  col-sm-8" maxlength="20">
    <div class="col-sm-2"></div>
    <input type=button onclick="'.$strJs.'" value="show/hide" class="btn btn-primary col-sm2">
    </div>';
}
function COMP_passwordCheckField($idPsw, $idCheck,$nameCheck) {
    $strJs="(document.getElementById('$idCheck').type==='password')?document.getElementById('$idCheck').type='text':document.getElementById('$idCheck').type='password'";
    return '
    <script>
    function ControllaPsw(form){
        psw1=document.getElementById("'.$idPsw.'");
        pswchk=document.getElementById("'.$idCheck.'");
        if (psw1.value!=pswchk.value){
            alert("le due password indicate non corrispondono");
            psw1.value="";
            pswchk.value="";
            psw1.focus();
            return false;
        }
        else
            return true;
    }
    </script>
    <div class="d-flex ps-3">
    <input type="password" name="'.$nameCheck.'" id="'.$idCheck.'" onblur=ControllaPsw(this); class="form-control  col-sm-8" maxlength="20">
    <div class="col-sm-2"></div>
    <input type=button onclick="'.$strJs.'" value="show/hide" class="btn btn-primary col-sm2">
    </div>';
}

    
?>
