function apriPopupTurno(data, nomeUtente) {
    $.ajax({
        url: './components/SimpleComponent/popupTurno.php',
        method: 'POST',
        async: false,
        data: { dataTurno: data, nomeUtente: nomeUtente },
        success: function(response) {
            $('body').append(response);
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

    $.ajax({
        url: 'api/salvaTurno',
        method: 'POST',
        data: { nomeUtente: nomeUtente, dataTurno: dataTurno, fasciaOraria: fasciaOraria, oraInizioEffettiva: oraInizioEffettiva, oraFineEffettiva: oraFineEffettiva, ruolo: ruolo, note: note },
        dataType: "json", // <-- assicura che venga interpretato come JSON
        success: function(risposta) {
            alert(risposta.messaggio || "Turno salvato!");
            $('#popupTurno').modal('hide');
            $('#popupTurno').remove();
        },
        error: function(xhr, status, error) {
            console.error("Errore AJAX:", xhr.responseText);
            console.error("Errore AJAX:", status);
            console.error("Errore AJAX:", error);
            alert("Errore durante il salvataggio del turno.");
        }
    });
}
