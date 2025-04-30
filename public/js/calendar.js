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
                        <th class=}"text-center align-middle" style="font-size: 1.5rem; width: 20%;">Time</th>
                        <th class="text-center align-middle" colspan="2" style="font-size: 1.5rem;">Soccorritore</th>
                        <th class="text-center align-middle" style="font-size: 1.5rem;">Autista</th>
                    </tr>
                </thead>
                <tbody style="height: 100%;">
                `;
    
    for (let ora = 0; ora < 24; ora++) {
        tableHTML += `<tr id="row-${(ora+7)%24}"></tr>`;
    }

    tableHTML += `</tbody>
            </table>
        </div>
    `;

    let table = $.parseHTML(tableHTML);
    $("#dayCal").html(table); // Replace the content of the dayCal div with the new table

    let turno1 = $.parseHTML(`<th rowspan='6' class="text-center align-middle" style="font-size: 1.5rem;">07:00-13:00</th>`);
    let turno2 = $.parseHTML(`<th rowspan='6' class="text-center align-middle" style="font-size: 1.5rem;">13:00-19:00</th>`);
    let turno3 = $.parseHTML(`<th rowspan='12' class="text-center align-middle" style="font-size: 1.5rem;">19:00-07:00</th>`);

    $("#row-7").append(turno1);
    $("#row-13").append(turno2);
    $("#row-19").append(turno3);

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

// function generaTabella(dataStr, turni) {
//     // Le fasce orarie fisse
//     const fasceOrarie = [
//         { start: "07:00", end: "13:00" },
//         { start: "13:00", end: "19:00" },
//         { start: "19:00", end: "07:00" }  // Turno notturno, 19:00-07:00
//     ];

//     // Inizializzazione della tabella
//     let tableHTML = `
//         <div class="table-responsive" style="height: 100%; display: flex; flex-direction: column;">
//             <h3 class="text-center mb-4">Schedule for ${dataStr}</h3>
//             <table class="table table-bordered table-hover" style="height: 100%; table-layout: fixed;">
//                 <thead class="thead-dark">
//                     <tr>
//                         <th class="text-center align-middle" style="font-size: 1.5rem; width: 20%;">Time</th>
//                         <th class="text-center align-middle" colspan="2" style="font-size: 1.5rem;">Soccorritore</th>
//                         <th class="text-center align-middle" style="font-size: 1.5rem;">Autista</th>
//                     </tr>
//                 </thead>
//                 <tbody style="height: 100%;">`;

//     // Creazione delle 24 righe per le ore
//     for (let ora = 7; ora <= 24; ora++) {
//         let oraStr = `${ora.toString().padStart(2, '0')}:00`;  // Formato orario es. 07:00, 08:00...
//         let nextOra = (ora + 1) % 24;
//         let nextOraStr = `${nextOra.toString().padStart(2, '0')}:00`;
        
//         tableHTML += `<tr>`;
//         tableHTML += `<th class="text-center align-middle" style="font-size: 1.5rem;">${oraStr}-${nextOraStr}</th>`;

//         // Aggiungi turnisti (Soccorritore 1, Soccorritore 2, Autista)
//         tableHTML += `${generaTurno("Soccorritore", oraStr, nextOraStr, turni, 0)}`;
//         tableHTML += `${generaTurno("Soccorritore", oraStr, nextOraStr, turni, 1)}`;
//         tableHTML += `${generaTurno("Autista", oraStr, nextOraStr, turni, 0)}`;

//         tableHTML += `</tr>`;
//     }

//     // Chiusura della tabella
//     tableHTML += `</tbody></table></div>`;

//     return tableHTML;
// }

// // Funzione per generare i turni dei vari ruoli
// function generaTurno(ruolo, oraInizio, oraFine, turni, index) {
//     let turno = turni.find(t => t.ruolo.toUpperCase() === ruolo.toUpperCase() &&
//                                 t.oraInizio === oraInizio && t.oraFine === oraFine);
//     if (turno) {
//         // Verifica per rowSpan (se il turno copre più ore consecutive)
//         let rowspan = calcolaRowSpan(turno, oraInizio, oraFine);
//         return `<td class="text-center align-middle" style="font-size: 1.5rem;" rowspan="${rowspan}">
//                     ${turno.nome} ${turno.cognome}
//                 </td>`;
//     } else {
//         return `<td class="text-center align-middle" style="font-size: 1.5rem;">
//                     <button class="btn btn-primary btn-sm" onclick="aggiungiTurno('${oraInizio}', '${oraFine}', '${ruolo}', ${index + 1})">Aggiungi Turno</button>
//                 </td>`;
//     }
// }

// // Funzione per calcolare il "rowspan" di un turno
// function calcolaRowSpan(turno, oraInizio, oraFine) {
//     const oreLavoro = getOreLavoro(turno.oraInizio, turno.oraFine);
//     return oreLavoro;
// }

// // Funzione per ottenere le ore di lavoro per un turno
// function getOreLavoro(oraInizio, oraFine) {
//     let start = parseInt(oraInizio.split(":")[0]);
//     let end = parseInt(oraFine.split(":")[0]);

//     if (end <= start) {
//         end += 24; // Gestione del turnover che va oltre la mezzanotte
//     }

//     return end - start;  // Calcola quante ore copre il turno
// }