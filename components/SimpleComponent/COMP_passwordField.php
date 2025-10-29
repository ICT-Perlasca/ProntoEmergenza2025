<?php
require_once "./globals.php";

function COMP_passwordField($id, $name) {
    global $publicImages,$imgEye,$DOMAIN_NAME;
    $nameImageEye=$DOMAIN_NAME."/".$publicImages."/".$imgEye;
    $strJs="(document.getElementById('$id').type==='password')?document.getElementById('$id').type='text':document.getElementById('$id').type='password';return false;";
    return '<div class="d-flex">
    <input type="password" name="'.$name.'" id="'.$id.'" class="form-control" maxlength="20">
    <!--<input type=button onclick="'.$strJs.'" value="show/hide" class="btn btn-primary col-sm2">-->
    <button class="btn btn-outline-primary" onclick="'.$strJs.'"><img src="'.$nameImageEye.'"></button>
    </div>';
}
function COMP_passwordCheckField($idPsw, $idCheck,$nameCheck) {
    global $publicImages,$imgEye,$DOMAIN_NAME;
    $nameImageEye=$DOMAIN_NAME."/".$publicImages."/".$imgEye;
    $strJs="(document.getElementById('$idCheck').type==='password')?document.getElementById('$idCheck').type='text':document.getElementById('$idCheck').type='password';return false;";
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
    <div class="d-flex">
    <input type="password" name="'.$nameCheck.'" id="'.$idCheck.'" onblur=ControllaPsw(this); class="form-control" maxlength="20">
    <!--<input type=button onclick="'.$strJs.'" value="show/hide" class="btn btn-primary">-->
    <button class="btn btn-outline-primary" onclick="'.$strJs.'"><img src="'.$nameImageEye.'"></button>
    </div>';
}

    
?>
