<?php

 /*
    dalla tabella giornaliera prendo la data e la passo con il bottone al popup
    nel popup ho 
    - il campo per il nome utente (Non modificabile dallo user)
    - il campo select per le tre fasce orarie con il quale poi vado a cercare il turno 118 insieme alla data per prelevare l'idTurno118 e collegarlo al tunro utenet
    - un campo per modificare la data di inizio e fine effettiva
    - un campo per scegliere lo slot soccorrritore o autista
    - un campo textarea per aggiungere le note facoltative
    caricati questi dati chiamo la query di insert per inserire il nuovo turno utente

    il popup deve essere richiamato nella pagina con ajax, anche la funzione per inviare i dati quando preme conferma deve essere in ajax (funzione javascript)
 */

function COMP_turniBottone($data, $nomeUtente) {
    return '
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="apriPopupTurno(\''. $data .' \', \''. $nomeUtente .'\')">
            Inserisci turno
        </button>
    ';
}