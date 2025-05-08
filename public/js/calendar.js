function turniData(dataStr) {
    let ret;

    console.log("Fetching shifts for date:", dataStr); // Log the date being fetched

    $.ajax({
        url: "/pages/Calendar/elencoTurniData.php",
        type: "POST",
        data: { data: dataStr },
        dataType: "json",
        async: false,       // SINCRONO PER RISPETTARE L'ORDINE DELLE RICHIESTE
        success: function (response) {
            console.log("Response from server:", response);
            ret = response.turni; // Assuming the server returns a JSON object with a "turni" property
        },
        error: function (error) {
            console.error("Error fetching shifts:", error);
            $("#dayCal").html("<p>Error loading shifts.</p>");
        }
    });

    return ret; // Return the response from the server
};



function generaTabella(dataStr, turni) {

    // Create a Bootstrap responsive table

    // Creare una tabella con 24 righe vuote, 
    // aggiungere i td con javascript in un secondo momento

    let tableHTML = `
        <div id='tabellaOrari' class="table-responsive" style="height: 75vh; display: flex; flex-direction: column;">
            <h3 class="text-center mb-4">Schedule for ${dataStr}</h3>
            <table class="table table-bordered table-hover" style="height: 100%; table-layout: fixed;">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center align-middle" style="font-size: 1.5rem; width: 20%;">Time</th>
                        <th class="text-center align-middle" colspan="2" style="font-size: 1.5rem;">Soccorritore</th>
                        <th class="text-center align-middle" style="font-size: 1.5rem;">Autista</th>
                    </tr>
                </thead>
                <tbody style="height: 100%;">
                `;
    
    for (let ora = 0; ora < 24; ora++) {
        tableHTML += `<tr id="row-${(ora+7)%24}">
            <td class="text-center align-middle time" style="font-size: 1.5rem;"></td>
            <td class="text-center align-middle soccorritore-1" style="font-size: 1.5rem;"></td>
            <td class="text-center align-middle soccorritore-2" style="font-size: 1.5rem;"></td>
            <td class="text-center align-middle autista" style="font-size: 1.5rem;"></td>
        </tr>`;
    }

    tableHTML += `</tbody>
            </table>
        </div>
    `;

    let table = $.parseHTML(tableHTML);
    $("#dayCal").html(table);

    let fascia1 = $.parseHTML(`<th rowspan='6' class="text-center align-middle" style="font-size: 1.5rem;">07:00-13:00</th>`);
    let fascia2 = $.parseHTML(`<th rowspan='6' class="text-center align-middle" style="font-size: 1.5rem;">13:00-19:00</th>`);
    let fascia3 = $.parseHTML(`<th rowspan='12' class="text-center align-middle" style="font-size: 1.5rem;">19:00-07:00</th>`);

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
            "autista": false
        },
        "13:00:00-19:00:00": {
            "soccorritore-1": false,
            "soccorritore-2": false,
            "autista": false
        },
        "19:00:00-07:00:00": {
            "soccorritore-1": false,
            "soccorritore-2": false,
            "autista": false
        }
    };
    for (let turno of turni) {
        let oraInizio = parseInt(turno.oraInizioEffettiva.split(":")[0]); // Extract starting hour
        let oraFine = parseInt(turno.oraFineEffettiva.split(":")[0]); // Extract ending hour
        let fascia = `${turno.oraInizio}-${turno.oraFine}`; // Shift time range

        if (oraFine === 0) oraFine = 24; // Handle shifts ending at midnight (e.g., 19:00-00:00)

        let durata = oraFine - oraInizio; // Calculate the duration of the shift
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

        // Create the shift cell with rowspan
        let shiftCell = `
            <td class="text-center align-middle ${columnClass}" rowspan="${rowspan}" style="font-size: 1.5rem;">
                ${turno.nome} ${turno.cognome}
            </td>
        `;

        // Append the shift cell to the correct row
        $(`#row-${oraInizio} .${columnClass}`).replaceWith(shiftCell);
        for (let i = oraInizio + 1; i < oraFine; i++) {
            $(`#row-${i} .${columnClass}`).remove(); // Remove the cells in between
        }
    }

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

    
    // // Ritorna la tabella come stringa HTML
    // let prova = $("#tabellaOrari").clone().wrap('<div/>').parent().html();
    // return prova;
}

function getDateFormatted(dateStr) {
    return dateStr.slice(0, 10);
}
