<?php
//session_start();
require_once "funzioniDB.php";
function API_modificaTurno($get, $post, $session) {
    $response = ['success' => false];

    // 1. Controlla che l'utente sia loggato
    if (!isset($_SESSION['idUtente'])) {
        $response['error'] = 'Utente non autenticato.';
    } else {
        // 2. Recupera dati POST
        $idTurnoUtente=$_POST['idTurnoUtente'];
        $data = $_POST['dataTurno'] ?? null;
        $fasciaOraria = $_POST['fasciaOraria'] ?? null;
        $splitFascia = explode(' - ', $fasciaOraria);
        $oraInizio = $splitFascia[0] ?? null;
        $oraFine = $splitFascia[1] ?? null;
        
        $oraInizioEffettiva = $_POST['oraInizioEffettiva'] ?? null; //da sistemare
        $oraFineEffettiva = $_POST['oraFineEffettiva'] ?? null;
        if ($oraInizioEffettiva == '') $oraInizioEffettiva = $oraInizio;
        if ($oraFineEffettiva == '') $oraFineEffettiva = $oraFine;
        
        // qui il ruolo non viene modificato!!!!n$ruolo = $_POST['ruolo'] ?? null; //nome del ruolo
        $note = $_POST['note'] ?? null;
        $idUtente = $_POST['idUtente'];
        //3. byprati: query di aggiornamento dell'npla del turno
        $strsql="update turniutenti set testoNota=?, oraInizioEffettiva=?, oraFineEffettiva=?, idUtente=? where idTurnoUtente=?";
        $resUpdate=db_query($strsql,[$note,$oraInizioEffettiva,$oraFineEffettiva,$idUtente,$idTurnoUtente],
                                    [PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_INT]);

        if (isset($resUpdate['error'])) {
            $response['error'] = "Errore nell'aggiornamento del turno-utente num.  $idTurnoUtente Errore dalla query:".$resUpdate['error'];
        } else {
            $response['success']=true;
        }
    }

    // 4. Risposta JSON
    header('Content-Type: application/json');
    return $response;
}
