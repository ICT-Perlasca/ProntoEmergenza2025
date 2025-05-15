function turniData(dataStr) {
    let ret;

    console.log("Fetching shifts for date:", dataStr); // Log the date being fetched

    $.ajax({
        url: "api/elencoTurniData",
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
    let tableHTML = `
        <div class="table-responsive" style="height: 100%; display: flex; flex-direction: column;">
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
                    <tr style="height: 33%;">
                        <th class="text-center align-middle" style="font-size: 1.5rem;">07:00-13:00</th>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "07:00:00", "13:00:00", "Soccorritore", 0)}</td>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "07:00:00", "13:00:00", "Soccorritore", 1)}</td>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "07:00:00", "13:00:00", "Autista", 0)}</td>
                    </tr>
                    <tr style="height: 33%;">
                        <th class="text-center align-middle" style="font-size: 1.5rem;">13:00-19:00</th>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "13:00:00", "19:00:00", "Soccorritore", 0)}</td>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "13:00:00", "19:00:00", "Soccorritore", 1)}</td>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "13:00:00", "19:00:00", "Autista", 0)}</td>
                    </tr>
                    <tr style="height: 33%;">
                        <th class="text-center align-middle" style="font-size: 1.5rem;">19:00-07:00</th>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "19:00:00", "07:00:00", "Soccorritore", 0)}</td>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "19:00:00", "07:00:00", "Soccorritore", 1)}</td>
                        <td class="text-center align-middle" style="font-size: 1.5rem;">${getTurni(turni, "19:00:00", "07:00:00", "Autista", 0)}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    `;

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

    return tableHTML;
}

function getDateFormatted(dateStr) {
    return dateStr.slice(0, 10);
}