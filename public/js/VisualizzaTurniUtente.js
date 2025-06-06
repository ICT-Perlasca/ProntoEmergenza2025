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

function stampaTurni(xhttp){
    let ris = JSON.parse(xhttp.responseText);
    if(ris == null)
       document.getElementById('ris').innerHTML = "Errore connessione";
    else if(ris.length == 0)
       document.getElementById('ris').innerHTML = "Nessuna turno trovato";
    else{
        let tab = "<table><tr><th>idTurnoUtente</th><th>testoNota</th<th>oraInizioEffettiva</th><th>oraInizioEffettiva</th>></tr>";
        for(let i=0; i<ris.length; i++){
            tab += "<tr><td>"+ris[i].idTurnoUtente+"</td><td>"+ris[i].testoNota+"</td><td>"+ris[i].oraInizioEffettiva+"</td><td>"+ris[i].oraInizioEffettiva+"</td></tr>";
        }
        tab += "</table>";
        document.getElementById('ris').innerHTML = tab;
    }
}