/*file contenente le funzioni ajax per le richieste dei turni convalidati
Percorso: ProntoEmergenza2025/public/js
*/
var array; // byprati: resa globale percè il suo contenuto caricato in GetTurniMese deve essere visibile anche in RispostaGetTurniMese
function GetTurniMese(form){
	let tipo=form.tipo.value;
	let meseAnno=form.meseAnno.value;
	array=meseAnno.split('-');
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
		//document.getElementById('hiddenJson').value=xhttp.responseText;
//		let str="<nav><button><i class='bi bi-filetype-xml'></i></button><button><i class='bi bi-file-pdf'></i></button></nav><br><br><table border=1 class=table><tr><th>Data</th><th>Ora Inizio</th><th>Ora Fine</th><th>Nome</th><th>Cognome</th><th>Ruolo</th></tr>";
		let str="<form name=frmBottoniApp method=POST action=elencoApp>";
		str+="<input type=hidden name=json value='"+xhttp.response+"'>";
        str+="<input type=hidden name=title value='Elenco turni convalidati'>";
		str+=`<nav><button type=submit class="btn" name=excel><img src="./public/images/excel-48.png"></button><button class="btn" type=submit name=pdf><img src="./public/images/pdf-50.png"></button></nav>`;
//		str+=`<nav><button class="btn" onclick="creaExcel('hiddenJson','Elenco Turni Convalidati in');"><img src="./public/images/excel-48.png"></button><button class="btn"><img src="./public/images/pdf-50.png"></button></nav><br><br><table border=1 class=table><tr><th>Data</th><th>Ora Inizio</th><th>Ora Fine</th><th>Nome</th><th>Cognome</th><th>Ruolo</th></tr>`;
		str+="</form><br><br><table border=1 class=table><tr><th>Data</th><th>Ora Inizio</th><th>Ora Fine</th><th>Nome</th><th>Cognome</th><th>Ruolo</th></tr>";
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
/*
function creaExcel(idHiddenJson,titolo){
	let strJson=document.getElementById(idHiddenJson).value;
//	alert("chiamata di CreaExcel con questi Dati:--->"+strJson+"<------>"+titolo);
	 $.ajax({
                url: './api/API_elaboraExcel.php',
                method: 'POST',
                async: false,
                dataType: "json",
                data: { json: strJson,tit: titolo },
                success: function(response) {
                  
                },
            error:function(xhr, status, error) {
                    console.error("Errore AJAX:", xhr.responseText);
                    console.error("Errore AJAX:", status);
                    console.error("Errore AJAX:", error);
                    alert("Errore durante la creazione del foglio excel con elenco turni convalidati");
                }
            });
			
	$.ajax({ //byprati: preso dal sito https://www.mattepuffo.com/blog/articolo/2155-download-dei-file-tramite-ajax.html
        type: "POST",
        url: "./api/API_elaboraExcel.php",
        headers: {
            Accept: 'application/octet-stream',
        }
    }).done(function (res) {
        const a = document.createElement('a');
        a.style = 'display: none';
        document.body.appendChild(a);
        const blob = new Blob([res], {type: 'octet/stream'});
        const url = URL.createObjectURL(blob);
        a.href = url;
        a.download = titolo;
        a.click();
        URL.revokeObjectURL(url);
    }).fail(function (err) {
        alert("ERRORE raber: " + err);
    });
}*/