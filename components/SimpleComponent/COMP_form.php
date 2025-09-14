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
function COMP_formFooter($testoBottone,$idBottone,$disabledBottone,$linkReset=""){ //bottoni finali di un qualsiasi form
    //disabledBottone: se =true il bottone è disabilitato
    $formFooter= "<div class='d-flex justify-content-center mt-4'>
        <div class='px-2'>";
    if ($linkReset!="")
        $formFooter.="<button type='reset' onClick=window.location.assign('".$linkReset."') class='btn btn-primary'>Annulla</button>";
    else
        $formFooter.="<button type='reset' onClick=location.reload() class='btn btn-primary'>Annulla</button>";
    
    $disabled=($disabledBottone==true)?"disabled":"";
    
    $formFooter.="</div>
        <div class='px-2'>
            <button type='submit' class='btn btn-primary' id=$idBottone name=$idBottone $disabled>$testoBottone</button>
        </div>
    </div>";
    return $formFooter;
    
}
function COMP_formContainerFooter(){
    return "</div><!-- chiusura div contenitoreForm-->
    </div>";
}