<?php
//session_start();
require_once "funzioniDB.php";
function API_salvaTurno($get, $post, $session) {
    $response = ['success' => false];

    // 1. Controlla che l'utente sia loggato
    if (!isset($_SESSION['idUtente'])) {
        $response['error'] = 'Utente non autenticato.';
    } else {
        // 2. Recupera dati POST
        $data = $_POST['dataTurno'] ?? null;
        $fasciaOraria = $_POST['fasciaOraria'] ?? null;
        $splitFascia = explode(' - ', $fasciaOraria);
        $oraInizio = $splitFascia[0] ?? null;
        $oraFine = $splitFascia[1] ?? null;
        
        $oraInizioEffettiva = $_POST['oraInizioEffettiva'] ?? null; //da sistemare
        $oraFineEffettiva = $_POST['oraFineEffettiva'] ?? null;
        if ($oraInizioEffettiva == '') $oraInizioEffettiva = $oraInizio;
        if ($oraFineEffettiva == '') $oraFineEffettiva = $oraFine;
        
        $idRuolo = $_POST['ruolo'] ?? null; //byprati: qui arriva id del ruolo
        $note = $_POST['note'] ?? null;
        $idUtente = $_POST['idUtente'];

        // 3. Trova idTurno118 da data e orari
        $resTurno = db_query(
            "SELECT idTurno118 FROM turni118 WHERE data = ? AND oraInizio = ? AND oraFine = ?",
            [$data, $oraInizio, $oraFine],
            [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR]
        );

        if (isset($resTurno['error']) || empty($resTurno)) {
            $response['error'] = 'Turno118 non trovato per la data e fascia oraria fornita.';
        } else {
            $idTurno118 = $resTurno[0]['idTurno118'];

            // 4. Verifica che il turno non sia già occupato per quel ruolo e turno118
            $resCheck = db_query(
                    "SELECT idTurnoUtente FROM turniutenti WHERE idTurno118 = ? AND idRuolo = ?",
                    [$idTurno118, $idRuolo],
                    [PDO::PARAM_INT, PDO::PARAM_INT]
            );

            if (!empty($resCheck) && count($resCheck) >= 2) {
                    $response['error'] = 'Turno già occupato per questo ruolo.';
            } else {
                    //5. verifica se sto inserendo corsista e NON esiste già istruttore
                    $insert=false;
                    //ritrova idRuolo associato a corsista
                    $idCorsista=db_query("select idRuolo from ruoli where nome='corsista'",[],[]);
                    if ($idCorsista[0]['idRuolo']==$idRuolo){
                        //se esiste un instruttore nel turno OK altrimenti NON si può inserire il turno
                        $checkIstruttore=db_query(
                            "select * from (((turni118 as t118 inner join turniutenti as tu on t118.idTurno118=tu.idTurno118) 
                                             inner join utenti as u on tu.idUtente=u.idUtente) 
                                             inner join utentiruoli as ur on u.idUtente=ur.idUtente)
                                             inner join ruoli as r on ur.idRuolo=r.idRuolo
                                        where r.nome='istruttore' and t118.idTurno118=?",
                            [ $idTurno118],
                            [PDO::PARAM_INT]
                        );
                        if (!empty($checkIstruttore) && count($checkIstruttore) >= 1) 
                            $insert=true;
                        else
                            $insert=false; //errore causa mancanza di un istruttore!!
                    } else {
                        $insert=true;//posso inserire perchè non è un corsista ed ho già superato gli altri controlli
                    }
                   if ($insert==false) {//manca istruttore nel turno
                        $response['error'] = 'Errore durante inserimento: non è possibile inserire il corsista perchè manca un istruttore nel turno!!';
                   }
                   else{ //esiste istruttore se corsista, oppure non si sta inserendo un corsista
                    // 6. Inserisci il turno utente
                    $resInsert = db_query(
                        "INSERT INTO turniutenti 
                            (testoNota, oraInizioEffettiva, oraFineEffettiva, convalidato, idTurno118, idEventoProgrammato, idAssistenza, idRuolo, idUtente)
                        VALUES (?, ?, ?, 0, ?, NULL, NULL, ?, ?)",
                        [$note, $oraInizioEffettiva, $oraFineEffettiva, $idTurno118, $idRuolo, $idUtente],
                        [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_INT]
                    );

                    if (isset($resInsert['error'])) {
                        $response['error'] = 'Errore durante l\'inserimento: ' . $resInsert['error'];
                    } else {
                        $response['success'] = true;
                        $response['messaggio'] = 'Turno inserito correttamente.';
                    }
                   }
                }
            //}
        }
    }

    // 7. Risposta JSON
    header('Content-Type: application/json');
    return $response;
}
