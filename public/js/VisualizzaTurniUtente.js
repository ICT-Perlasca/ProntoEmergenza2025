function getTurni(form){
    let utente = form.utente.value;
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "VisualizzaTurniUtente.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onload = function(){
        stampaTurni(this);
    }
    xhttp.send("utente="+utente);
}