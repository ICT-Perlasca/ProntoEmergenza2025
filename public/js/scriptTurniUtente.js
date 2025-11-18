function GetTurniUtente(form){

    let tipo=form.tipo.value;
	let idUtente=form.idUtente.value;
	
	const conn= new XMLHttpRequest();
	conn.open("POST","./api/API_elencoTurniUtente");
	conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	conn.onload= function(){
		rispostaGetTurniUtente(this,tipo);
	}
	conn.send("tipo="+tipo+"&idUtente="+idUtente);
}
function rispostaGetTurniUtente(xhttp,tipo){
    let risposta=JSON.parse(xhttp.responseText);
	if(risposta.length==0){
		document.getElementById('tableTurni').innerHTML="Nessun turno trovato";
	}else if(risposta==null){
		document.getElementById('tableTurni').innerHTML="ERRORE di connessione al database";
	}else{
		let str="<form name=frmBottoniApp method=POST action=elencoApp>";
		str+="<input type=hidden name=json value='"+xhttp.responseText+"'>";
        str+="<input type=hidden name=title value='Elenco turni convalidati'>";
		str+=`<nav><button type=submit class="btn" name=excel><img src="./public/images/excel-48.png"></button><button class="btn" type=submit name=pdf><img src="./public/images/pdf-50.png"></button></nav>`;
		str+='</form><br><h1>'+tipo+'</h1><table border=1 class=table><tr><th>Data</th><th>Ora Inizio</th><th>Ora Fine</th><th>Ruolo</th><th>Convalidato</th></tr>';
		for(let i=0;i<risposta.length; i++){
			str=str+"<tr>";
			str=str+"<td>"+risposta[i]['data']+"</td>";
			str=str+"<td>"+risposta[i]['oraInizio']+"</td>";
			str=str+"<td>"+risposta[i]['oraFine']+"</td>";
            str=str+"<td>"+risposta[i]['nomeRuolo']+"</td>";
			str=(risposta[i]['convalidato']==1)?str+"<td>SI</td>":"<td>NO</td>";
			str=str+"</tr>";
		}
		str=str+"</table>";
		//console.log(str);
		document.getElementById('tableTurni').innerHTML=str;		
	}
}
