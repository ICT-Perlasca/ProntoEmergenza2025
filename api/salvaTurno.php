<?php
//session_start();
require_once "funzioniDB.php";
function API_SalvaTurno($get, $post, $session) {
    $response = ['success' => false];

    // 1. Controlla che l'utente sia loggato
    if (!isset($_SESSION['idUtente'])) {
        $response['errore'] = 'Utente non autenticato.';
    } else {
        // 2. Recupera dati POST
        $data = $_POST['dataTurno'] ?? null;
        $fasciaOraria = $_POST['fasciaOraria'] ?? null;
        $splitFascia = explode(' - ', $fasciaOraria); //non funge
        $oraInizio = $splitFascia[0] ?? null;
        $oraFine = $splitFascia[1] ?? null;
        $oraInizioEffettiva = $_POST['oraInizioEffettiva'] ?? null; //da sistemare
        $oraFineEffettiva = $_POST['oraFineEffettiva'] ?? null;
        if ($oraInizioEffettiva == '') $oraInizioEffettiva = $oraInizio;
        if ($oraFineEffettiva == '') $oraFineEffettiva = $oraFine;
        $ruolo = $_POST['ruolo'] ?? null;
        $note = $_POST['note'] ?? null;
        $idUtente = $_SESSION['idUtente'];

        // 3. Trova idTurno118 da data e orari
        $resTurno = db_query(
            "SELECT idTurno118 FROM turni118 WHERE data = ? AND oraInizio = ? AND oraFine = ?",
            [$data, $oraInizio, $oraFine],
            [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR]
        );

        if (isset($resTurno['error']) || empty($resTurno)) {
            $response['errore'] = 'Turno118 non trovato per la data e fascia oraria fornita.';
        } else {
            $idTurno118 = $resTurno[0]['idTurno118'];

            // 4. Trova idRuolo dal nome
            $resRuolo = db_query(
                "SELECT idRuolo FROM ruoli WHERE LOWER(nome) = LOWER(?)",
                [$ruolo],
                [PDO::PARAM_STR]
            );

            if (isset($resRuolo['error']) || empty($resRuolo)) {
                $response['errore'] = 'Ruolo non valido.';
            } else {
                $idRuolo = $resRuolo[0]['idRuolo'];

                // 5. Verifica che il turno non sia già occupato per quel ruolo e turno118
                $resCheck = db_query(
                    "SELECT idTurnoUtente FROM turniutenti WHERE idTurno118 = ? AND idRuolo = ?",
                    [$idTurno118, $idRuolo],
                    [PDO::PARAM_INT, PDO::PARAM_INT]
                );

                if (!empty($resCheck)) {
                    $response['errore'] = 'Turno già occupato per questo ruolo.';
                } else {
                    // 6. Inserisci il turno utente
                    $resInsert = db_query(
                        "INSERT INTO turniutenti 
                            (testoNota, oraInizioEffettiva, oraFineEffettiva, convalidato, idTurno118, idEventoProgrammato, idAssistenza, idRuolo, idUtente)
                        VALUES (?, ?, ?, 0, ?, NULL, NULL, ?, ?)",
                        [$note, $oraInizioEffettiva, $oraFineEffettiva, $idTurno118, $idRuolo, $idUtente],
                        [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_INT]
                    );

                    if (isset($resInsert['error'])) {
                        $response['errore'] = 'Errore durante l\'inserimento: ' . $resInsert['error'];
                    } else {
                        $response['success'] = true;
                        $response['messaggio'] = 'Turno inserito correttamente.';
                    }
                }
            }
        }
    }

    // 7. Risposta JSON
    header('Content-Type: application/json');
    return $response;
}
