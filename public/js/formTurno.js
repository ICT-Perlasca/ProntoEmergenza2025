//byprati: nel form x ins Turno ogni scelta dello slot modifica in autmatico i campi ora inizio effettiva ed ora fine effettiva
function aggiornaOra(form){
    let valIntervallo=form.fasciaOraria.value;
    let parti=valIntervallo.split('-');
    //alert("fascia letta dal form evento onChange -"+parti[0]+"-"+parti[1]+"-");
    form.oraInizioEffettiva.value=parti[0].trim();
    form.oraFineEffettiva.value=parti[1].trim();
}
function apriPopupTurno(data, nomeUtente) {
    $.ajax({
        url: './components/SimpleComponent/popupTurno.php',
        method: 'POST',
        async: false,
        dataType: 'json',
        data: { dataTurno: data, nomeUtente: nomeUtente },
        success: function(response) {
            $('#popupContainer').html(response.html);
            if(response.utenteIsAdmin) caricaUtenti();
            $('#popupTurno').modal('show');
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
        data: { idUtente: nomeUtente, dataTurno: dataTurno, fasciaOraria: fasciaOraria, oraInizioEffettiva: oraInizioEffettiva, oraFineEffettiva: oraFineEffettiva, ruolo: ruolo, note: note },
        dataType: "json", 
        success: function(risposta) {
            console.log("Risposta AJAX:", risposta);
            if (risposta.success) {
                alert(risposta.messaggio || "Turno salvato!");
                $('#popupTurno').modal('hide');
                $('##popupTurno').on("hidden", function() {
                    location.reload();;
                });
                $('#popupTurno').remove();
                //byprati calendar.dateclick??? a ggiornare pagina del turno inserito???
               
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

function caricaUtenti() {
    $.ajax({
        url: 'api/RitornaUtenti',
        method: 'POST',
        dataType: 'json',
        async: false,
        success: function(response) {
            const select = document.getElementById('selectUtenti');
            response.forEach(utente => {
                const option = document.createElement('option');
                option.value = utente.idUtente;
                option.textContent = `${utente.cognome} ${utente.nome}`;
                select.appendChild(option);
            });
        },
        error: function(xhr, status, error) {
            console.error('Errore durante il caricamento degli utenti:', error);
        }
    });
}