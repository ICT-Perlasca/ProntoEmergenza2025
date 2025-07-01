<?php
function COMP_formContainerHeader($titolo,$hasMsg,$txtMessage) {
//min-vh-100
    $formHeader= " <span class='col-8 text-center'><h1>$titolo</h1></span>
    <div class='row  justify-content-center align-items-center bg-primary text-white py-5' m-0>
        <div class='col-12 col-md-8 col-lg-6 bg-white text-dark p-5 rounded shadow'>";
    if ($hasMsg) 
        $formHEader.= "<div class='alert alert-danger mb-4'>$$txtMessage</div>";
    return $formHeader;
}
function COMP_formFooter($testoBottone,$linkReset){ //bottoni finali di u qualsiasi form
return "<div class='d-flex justify-content-center mt-4'>
        <div class='px-2'>
            <button type='reset' onClick=window.location.assign('".$linkReset."') class='btn btn-primary'>ANNULLA</button>
        </div>
        <div class='px-2'>
            <button type='submit' class='btn btn-primary'>$testoBottone</button>
        </div>
    </div>";
    
}
function COMP_formContainerFooter(){
    return "</div><!-- chiusura div contenitoreForm-->
    </div>";
}