/*file contenente le funzioni ajax per le richieste dei turni convalidati
Percorso: ProntoEmergenza2025/public/js
*/
function GetTurniMese(form){
	let tipo=form.tipo.value;
	let meseAnno=form.meseAnno.value;
	let array=meseAnno.split('-');
	const conn= new XMLHttpRequest();
	conn.open("POST","./api/API_ElencoTurniConvalidatiMensile");
	conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	conn.onload= function(){
		rispostaGetTurniMesi(this);
	}
	conn.send("tipo="+tipo+"&year="+array[0]+"&month="+array[1]);
}

function rispostaGetTurniMesi(xhttp){
	let risposta=JSON.parse(xhttp.responseText);
	if(risposta.length==0){
		document.getElementById('tableTurni').innerHTML="Nessun turno trovato";
	}else if(risposta==null){
		document.getElementById('tableTurni').innerHTML="ERRORE di connessione al database";
	}else{
		let str="<nav><button><i class='bi bi-filetype-xml'></i></button><button><i class='bi bi-file-pdf'></i></button></nav><br><br><table border=1 class=table><tr><th>Data</th><th>Ora Inizio</th><th>Ora Fine</th><th>Nome</th><th>Cognome</th><th>Ruolo</th></tr>";
		for(let i=0;i<risposta.length; i++){
			str=str+"<tr>";
			str=str+"<td>"+risposta[i]['data']+"</td>";
			str=str+"<td>"+risposta[i]['oraInizio']+"</td>";
			str=str+"<td>"+risposta[i]['oraFine']+"</td>";
			str=str+"<td>"+risposta[i]['nome']+"</td>";
			str=str+"<td>"+risposta[i]['cognome']+"</td>";
			str=str+"<td>"+risposta[i]['m']+"</td>";
			str=str+"</tr>";
		}
		str=str+"</table>";
		document.getElementById('tableTurni').innerHTML=str;		
	}
}
function GetMesi(tipoSelect){
	let tipo=tipoSelect.value;
//	alert("tipo turno richiesto:"+tipo);
	const conn=new XMLHttpRequest();
	conn.open("POST", "./api/API_GetMesi");
	conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	conn.onload=function(){
		rispostaGetMesi(this);
	}
	conn.send("tipo="+tipo);

	}
function rispostaGetMesi(xhttp){
	let risposta=JSON.parse(xhttp.responseText);
	if(risposta.length==0){
		document.getElementById("selectMeseAnno").innerHTML="Nessun Mese Trovato";
	}else if(risposta==null){
		document.getElementById("selectMeseAnno").innerHTML="Errore";
	}else{
		
		let str="<label for='meseAnno' class='form-label'>Scegli mese e anno: </label><select name=meseAnno>";
		for(let i=0; i<risposta.length; i++){
			str=str+"<option value="+risposta[i]['year']+"-"+risposta[i]['mese']+">"+risposta[i]['year']+"-"+risposta[i]['mese']+"<option>";
		}
		str=str+"</select>";
		document.getElementById('selectMeseAnno').innerHTML=str;
		document.getElementById('btnRicercaTurni').disabled=false;
	}
}
function getTurniMeseUtente(form){
	let tipo=form.tipo.value;
	let meseAnno=form.meseAnno.value;
	let array=meseAnno.split('-');
	let utente=form.utente.value;
	let arrayutente=utente.split(' ');
	const conn= new XMLHttpRequest();
	conn.open("POST","./api/API_ElencoTurniConvalidatiMensileUtente");
	conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	conn.onload= function(){
		rispostaGetTurniMesi(this);
	}
	conn.send("tipo="+tipo+"&year="+array[0]+"&month="+array[1]+"&nome="+arrayutente[0]+"&cognome="+arrayutente[1]);
}