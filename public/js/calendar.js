function turniData(dataStr) {
    let ret;

    console.log("Fetching shifts for date:", dataStr); // Log the date being fetched

    $.ajax({
        url: "api/elencoTurniData",
        type: "POST",
        data: { data: dataStr },
        dataType: "json",
        async: false,       // SINCRONO PER RISPETTARE L'ORDINE DELLE ISTRUZIONI
        success: function (response) {
            console.log("Response from server:", response);
            ret = response.turni; // Assuming the server returns a JSON object with a "turni" property
        },
        error: function (error) {
            console.error("Error fetching shifts:", error);
            $("#dayCal").html("<p>Errore caricamento turni</p>");
        }
    });

    return ret; // Return the response from the server
};



function generaTabella(dataStr, turni, tipoUtenteLoggato) {

    let tableHTML = `
        <div id='tabellaOrari' class="table-responsive" style="height: 75vh; display: flex; flex-direction: column; overflow: visible;">
            <h3 class="text-center mb-4">Schedule for ${dataStr}</h3>
            <table class="table table-bordered table-hover table-striped" style="height: 100%; table-layout: fixed;">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center align-middle" style="font-size: 1.5rem; width: 20%;">Time</th>
                        <th class="text-center align-middle" colspan="2" style="font-size: 1.5rem;">Soccorritore</th>
                        <th class="text-center align-middle" style="font-size: 1.5rem;">Autista</th>
                        <th class="text-center align-middle" style="font-size: 1.5rem;">Corsista</th>
                    </tr>
                </thead>
                <tbody style="height: 100%;">
                `;
    
    for (let ora = 0; ora < 24; ora++) {
        tableHTML += `<tr id="row-${(ora+7)%24}">`;
        tableHTML+=`<td class="text-center align-middle time" style="font-size: 1.5rem;"></td>
            <td class="text-center align-middle soccorritore-1" style="height: 25px; font-size: 1.5rem;"></td>
            <td class="text-center align-middle soccorritore-2" style="height: 25px; font-size: 1.5rem;"></td>
            <td class="text-center align-middle autista" style="height: 25px; font-size: 1.5rem;"></td>
            <td class="text-center align-middle corsista" style="height: 25px; font-size: 1.5rem;"></td>
        </tr>`;
    }

    tableHTML += `</tbody>
            </table>
        </div>
    `;

    let table = $.parseHTML(tableHTML);
    $("#dayCal").html(table);

    let fascia1 = $.parseHTML(`<th rowspan='6' class="text-center align-middle table-primary" style="font-size: 1.5rem;">07:00-13:00</th>`);
    let fascia2 = $.parseHTML(`<th rowspan='6' class="text-center align-middle table-secondary" style="font-size: 1.5rem;">13:00-19:00</th>`);
    let fascia3 = $.parseHTML(`<th rowspan='12' class="text-center align-middle table-primary" style="font-size: 1.5rem;">19:00-07:00</th>`);

    $("#row-7 .time").replaceWith(fascia1);
    $("#row-13 .time").replaceWith(fascia2);
    $("#row-19 .time").replaceWith(fascia3);

    for (let ora = 0; ora < 24; ora++) {
        $(`#row-${(ora+7)%24} .time`).remove();
    }
    
    let turniBase = {
        "07:00:00-13:00:00": {
            "soccorritore-1": false,
            "soccorritore-2": false,
            "autista": false,
            "corsista":false
        },
        "13:00:00-19:00:00": {
            "soccorritore-1": false,
            "soccorritore-2": false,
            "autista": false,
            "corsista":false
        },
        "19:00:00-07:00:00": {
            "soccorritore-1": false,
            "soccorritore-2": false,
            "autista": false,
            "corsista":false
        }
    };
    for (let turno of turni) {
        let oraInizio = parseInt(turno.oraInizioEffettiva.split(":")[0]);
        let oraFine = parseInt(turno.oraFineEffettiva.split(":")[0]);
        let fascia = `${turno.oraInizio}-${turno.oraFine}`; // Shift time range
        /* byprati   determino colore fascia 1^fascia table-primary, 2^fascia table-secondary, 3^fascia table-primary
        */
        let bgColor="";
        if(fascia==="07:00:00-13:00:00" || fascia==="19:00:00-07:00:00")
            bgColor="table-primary"
        else if (fascia==="13:00:00-19:00:00")
                bgColor="table-secondary";

        if (oraFine === 0) oraFine = 24; // Treat midnight as 24

        // If the shift ends before it starts (overnight), limit to 24 (end of table)
        // let actualOraFine = oraFine > oraInizio ? oraFine : 24;
        let actualOraFine = fascia === "19:00:00-07:00:00" ? 6 : oraFine; // Handle overnight shifts
        let durata = Math.abs(actualOraFine - oraInizio); // Calculate the duration of the shift
        let rowspan = durata; // Use the duration as the rowspan

        // Determine the role column
        let columnClass = ""; // Class for the column

        if (turno.ruolo.toLowerCase() === "soccorritore") {
            // Check if the first Soccorritore column has already been replaced
            if (turniBase[fascia][`soccorritore-1`] == false) {
                turniBase[fascia][`soccorritore-1`] = true; // Mark the first column as filled
                columnClass = "soccorritore-1";
            } else {
                turniBase[fascia][`soccorritore-2`] = true; // Mark the second column as filled
                columnClass = "soccorritore-2";
            }
        } else if (turno.ruolo.toLowerCase() == "autista") {
            // Always place Autista in the last column
            turniBase[fascia][`autista`] = true;
            columnClass = "autista";
        }
        else if (turno.ruolo.toLowerCase() == "corsista") {
            turniBase[fascia][`corsista`] = true;
            columnClass = "corsista";
        }

        // Create the shift cell with rowspan
        let shiftCell = `
            <td class="text-center ${bgColor} align-middle ${columnClass}" rowspan="${rowspan}" style="font-size: 1.5rem;">
                <p ${ turno.testoNota ? `
                    data-bs-toggle="popover" 
                    data-bs-trigger="hover" 
                    title="Nota aggiuntiva:" 
                    data-bs-placement="right" 
                    data-bs-content="${turno.testoNota}"
                    ` : ""
                }
                >
                    ${turno.nome} ${turno.cognome}

                    ${
                        (turno.testoNota && tipoUtenteLoggato==='admin')? `
                            <i class="bi bi-info-circle-fill text-info" style="cursor: pointer;"></i>
                        ` : ""
                    
                    }
   
                    ${
                         //se utente è admin allora compare la X per poter cancellare utente dal turno
                        /*
                        <i class="bi bi-pencil-square" on click=funzione a cui passo idUtente del turno, dataTurno, orainizioeffettiva ed ora fine effettiva e ruolo per chedere se vuole cancellare></i>
                        */
                        tipoUtenteLoggato==='admin'?
                        `<i class="bi bi-pencil-square" onclick="apriPopupModificaTurno( ${turno.idT});"></i>`
                        :""
                    }
                </p>
            </td>
        `;

        // Append the shift cell to the correct row
        $(`#row-${oraInizio} .${columnClass}`).replaceWith(shiftCell);

        // Remove cells in between, but do not wrap after 23
        /*
        for (let i = oraInizio + 1; i < actualOraFine || (i < 24); i++) {
            $(`#row-${i} .${columnClass}`).remove();
        }
            */
        let prev = 0;
        for (let i = 1; i < durata && (prev != 6); i++) {
            let nextRow = (oraInizio + i) % 24; // Wrap around after 23
            $(`#row-${nextRow} .${columnClass}`).remove();
            prev = nextRow;
        }

            // Inizializza i popover
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

            /*
    function getTurni(turni, oraInizio, oraFine, ruolo, index) {
        const turniFiltrati = turni.filter(
            (turno) =>
                turno.oraInizio === oraInizio &&
                turno.oraFine === oraFine &&
                turno.ruolo.toUpperCase() === ruolo.toUpperCase()
        );

        const turno = turniFiltrati[index];
        return turno
            ? `${turno.nome} ${turno.cognome}`
            : `<button class="btn btn-primary btn-sm" onclick="aggiungiTurno('${oraInizio}', '${oraFine}', '${ruolo}', ${index + 1})">Aggiungi Turno</button>`;
    }

    */
    // // Ritorna la tabella come stringa HTML
    // let prova = $("#tabellaOrari").clone().wrap('<div/>').parent().html();
    // return prova;
    }
}

function generaBtnTurno(dataStr, nomeUtente) {
    let btnHTML = `
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="apriPopupTurno('${dataStr}', '${nomeUtente}')">
            Inserisci turno
        </button>
    `;
    $("#btnInserisci").html(btnHTML);
}

function getDateFormatted(dateStr) {
    return dateStr.slice(0, 10);
}
//byprati: funzione richiamata sul click sulla matita se utente che insersce i turni è admin e vuole modiifcare orario turno o cancellare turno
function apriPopupModificaTurno(idTurnoDaModificare) {
    alert('sono in popupModificaTurno');
    $.ajax({
        url: './components/SimpleComponent/popupModificaTurno.php',
        method: 'POST',
        async: false,
        dataType: 'json',
        data: { idTurno118: idTurnoDaModificare },
        success: function(response) {
            $('#popupContainer').html(response.html);
            // da fare dentro al php if(response.utenteIsAdmin) caricaUtenti();
            $('#popupModificaTurno').modal('show');
        }
    });

    }

