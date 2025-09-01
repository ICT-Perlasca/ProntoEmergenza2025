//byprati: nel form x ins Turno ogni scelta dello slot modifica in autmatico i campi ora inizio effettiva ed ora fine effettiva
function aggiornaOra(form){
    let valIntervallo=form.fasciaOraria.value;
    let parti=valIntervallo.split('-');
    //alert("fascia letta dal form evento onChange -"+parti[0]+"-"+parti[1]+"-");
    form.oraInizioEffettiva.value=parti[0].trim();
    form.oraFineEffettiva.value=parti[1].trim();
}
/*function aggiornaUtenti(form){
   $.ajax({
        url: '/api/ritornaUtenti',
        method: 'POST',
        async: false,
        dataType: 'json',
        data: { idRuolo: form.ruolo.value},//vien passato direttamente id del ruolo
        success: function(response) {
            let str="";

            $('#selectUtenti').html();
          
          //  $('#popupTurno').modal('show');
        },
        error: function(xhr, status, error) {
            console.error("Errore AJAX:", xhr.responseText);
            console.error("Errore AJAX:", status);
            console.error("Errore AJAX:", error);
            alert("Errore durante la ricerca dell'elenco degli utenti sulla base del ruolo in inserimento turno (aggiornaUtenti in formTurno.js).");
        }
    }); 
}*/

function apriPopupTurno(data, nomeUtente) {
    $.ajax({
        url: './components/SimpleComponent/popupTurno.php',
        method: 'POST',
        async: false,
        dataType: 'json',
        data: { dataTurno: data, nomeUtente: nomeUtente },
        success: function(response) {
            //console.log(response.html);
            $('#popupContainer').html(response.html);
           //byprati: gli utenti sono caricati all'evento change del ruolo (dinamicamente) se utente è admin if(response.utenteIsAdmin) caricaUtenti();
            $('#popupTurno').modal('show');
        },
        error: function(xhr, status, error) {
            console.error("Errore AJAX:", xhr.responseText);
            console.error("Errore AJAX:", status);
            console.error("Errore AJAX:", error);
            alert("Errore durante l'apertura del popup x inserimento Turno.");
        }
    });
}

function confermaTurno(form) {
    let nomeUtente = form.nomeUtente.value;
    let dataTurno = form.dataTurno.value;
    let fasciaOraria = form.fasciaOraria.value;
    let oraInizioEffettiva = form.oraInizioEffettiva.value;
    let oraFineEffettiva = form.oraFineEffettiva.value;
    let ruolo = form.ruolo.value;
    let note = form.note.value;
/* by prati
se esiste il campo con id=idUtente 
allora utente loggato non è admin
     idUtente da testo hidden del fomr con name=idUtente
altrimenti
    idUtente dalla value della select con id=selectUtenti
fse
*/
    let idUtente;
    if (document.getElementById('idUtente'))
        idUtente=document.getElementById('idUtente').value;
    else
        idUtente=document.getElementById('selectUtenti').value;
    console.log("idUtente:",idUtente);
    console.log("Nome Utente:", nomeUtente);
    console.log("Data Turno:", dataTurno); 
    console.log("Fascia Oraria:", fasciaOraria);
    console.log("Ora Inizio Effettiva:", oraInizioEffettiva);
    console.log("Ora Fine Effettiva:", oraFineEffettiva);
    console.log("Ruolo:", ruolo);
    console.log("Note:", note);

    $.ajax({
        url: 'api/salvaTurno',
        method: 'POST',
        async: false,
        data: { idUtente: idUtente, dataTurno: dataTurno, fasciaOraria: fasciaOraria, oraInizioEffettiva: oraInizioEffettiva, oraFineEffettiva: oraFineEffettiva, ruolo: ruolo, note: note },
        dataType: "json", 
        success: function(risposta) {
            console.log("Risposta AJAX:", risposta);
            if (risposta.success) {
                alert(risposta.messaggio || "Turno salvato!");
                $('#popupTurno').modal('hide');
               // $('#popupTurno').on("hidden", function() {
                    //location.reload();
                  //  handleCalendareDateClick(new Date(dataTurno));
                //});
                $('#popupTurno').remove();
                //byprati calendar.dateclick??? a ggiornare pagina del turno inserito???
                $('#dayCal').html('');//cancella calendario di 1 giorno
                const fakeInfo = {
                    dateStr: dataTurno,
                    date: new Date(dataTurno)
                };
                handleCalendarDateClick(fakeInfo);//ricostruirsce calendario di un giorno

            }else{
                alert(risposta.errore || "Turno non salvato!");
            }
        },
        error: function(xhr, status, error) {
            console.error("Errore AJAX:", xhr.responseText);
            console.error("Errore AJAX:", status);
            console.error("Errore AJAX:", error);
            alert("Errore durante il salvataggio del turno.");
        }
    });
}

function caricaUtenti(form) {
   // alert("sonoin carica utenti!!");
    $.ajax({
        url: 'api/ritornaUtenti',
        method: 'POST',
        dataType: 'json',
        data: { idRuolo: form.ruolo.value},
        async: false,
        success: function(response) {
            const select = document.getElementById('selectUtenti');
            select.innerHTML="";
            response.forEach(utente => {
                const option = document.createElement('option');
                option.value = utente.idUtente;
                option.textContent = `${utente.cognome} ${utente.nome}`;
                select.appendChild(option);
            });
        },
        error: function(xhr, status, error) {
            console.error('Errore durante il caricamento degli utenti in caricaUtenti in formTurno.js da inseirmento nuovo turno x admin:', error);
        }
    });
}
function ModificaTurno(form){
    
    let nomeUtente = form.nomeUtente.value;
    let idTurnoUtente=form.idTurno.value;
    let dataTurno = form.dataTurno.value;
    let fasciaOraria = form.fasciaOraria.value;
    let oraInizioEffettiva = form.oraInizioEffettiva.value;
    let oraFineEffettiva = form.oraFineEffettiva.value;
    let ruolo = form.ruolo.value;
    let note = form.note.value;

    let idUtente;
    if (document.getElementById('idUtente'))
        idUtente=document.getElementById('idUtente').value;
    else
        idUtente=document.getElementById('selectUtenti').value;
    console.log("idUtente:",idUtente);
    console.log("Nome Utente:", nomeUtente);
    console.log("Data Turno:", dataTurno); 
    console.log("Fascia Oraria:", fasciaOraria);
    console.log("Ora Inizio Effettiva:", oraInizioEffettiva);
    console.log("Ora Fine Effettiva:", oraFineEffettiva);
    console.log("Ruolo:", ruolo);
    console.log("Note:", note);

    $.ajax({
        url: 'api/API_modificaTurno',
        method: 'POST',
        async: false,
        data: { idTurnoUtente:idTurnoUtente, idUtente: idUtente, dataTurno: dataTurno, fasciaOraria: fasciaOraria, oraInizioEffettiva: oraInizioEffettiva, oraFineEffettiva: oraFineEffettiva, ruolo: ruolo, note: note },
        dataType: "json", 
        success: function(risposta) {
            console.log("Risposta AJAX:", risposta);
            if (risposta.success) {
                alert("Turno modificato!");
                $('#popupTurno').modal('hide');
               // $('#popupTurno').on("hidden", function() {
                    //location.reload();
                  //  handleCalendareDateClick(new Date(dataTurno));
                //});
                $('#popupTurno').remove();
                //byprati calendar.dateclick??? a ggiornare pagina del turno inserito???
                $('#dayCal').html('');//cancella calendario di 1 giorno
                const fakeInfo = {
                    dateStr: dataTurno,
                    date: new Date(dataTurno)
                };
                handleCalendarDateClick(fakeInfo);//ricostruirsce calendario di un giorno

            }else{
                alert(risposta.errore || "Turno non modificato!");
            }
        },
        error: function(xhr, status, error) {
            console.error("Errore AJAX:", xhr.responseText);
            console.error("Errore AJAX:", status);
            console.error("Errore AJAX:", error);
            alert("Errore durante la modifica del turno.");
        }
    });
}
