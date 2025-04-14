function turniData(dataStr) {
    // oraInizio -> ora di inizio di un turno
    // oraFine -> ora di fine di un turno
    // nome -> nome dell'utente
    // cognome -> cognome dell'utente
    // turni -> array che contiene tutti i turni di questa data come oggetti javascript
    // un turno è un oggetto con le seguenti proprietà:
    // oraInizio, oraFine, nome, cognome
    // dataStr -> An ISO8601 string representation of the date
    // ogni giorno contiene 3 fasce orarie, ognuna con al massimo 3 turni
    
    $ajax({
        url: "/turni",
        type: "POST",
        data: { data: dataStr },
        success: function (response) {
            const turni = response.turni; // Assuming the server returns an array of shifts for the date
            const tableHTML = generaTabella(dataStr, turni);
            $("#turniTable").html(tableHTML); // Update the table with the new HTML
        },
        error: function (error) {
            console.error("Error fetching shifts:", error);
            $("#turniTable").html("<p>Error loading shifts.</p>");
        }
    });

    
};


function generaTabella(dataStr, turni) {

    // Create a Bootstrap responsive table
    let tableHTML = `
        <div class="table-responsive">
            <h3>Schedule for ${dataStr}</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center" colspan="2">Soccorritore</th>
                        <th class="text-center">Autista</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>07:00-13:00</th>
                        <td>${getTurni(turni, "07:00:00", "13:00:00", "Soccorritore", 0)}</td>
                        <td>${getTurni(turni, "07:00:00", "13:00:00", "Soccorritore", 1)}</td>
                        <td>${getTurni(turni, "07:00:00", "13:00:00", "Autista", 0)}</td>
                    </tr>
                    <tr>
                        <th>13:00-19:00</th>
                        <td>${getTurni(turni, "13:00:00", "19:00:00", "Soccorritore", 0)}</td>
                        <td>${getTurni(turni, "13:00:00", "19:00:00", "Soccorritore", 1)}</td>
                        <td>${getTurni(turni, "13:00:00", "19:00:00", "Autista", 0)}</td>
                    </tr>
                    <tr>
                        <th>19:00-07:00</th>
                        <td>${getTurni(turni, "19:00:00", "07:00:00", "Soccorritore", 0)}</td>
                        <td>${getTurni(turni, "19:00:00", "07:00:00", "Soccorritore", 1)}</td>
                        <td>${getTurni(turni, "19:00:00", "07:00:00", "Autista", 0)}</td>
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
                turno.ruolo === ruolo
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