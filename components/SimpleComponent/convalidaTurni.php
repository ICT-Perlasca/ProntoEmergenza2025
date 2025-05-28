<?php
require_once "funzioniDB.php"; 

function convalidaMese($anno, $mese) {
    $dataInizio = "$anno-$mese-01";
    $dataFine = date("Y-m-t", strtotime($dataInizio));

    $queryCheck = "SELECT COUNT(*) as totale, SUM(convalidato) as convalidati
                   FROM turniutenti
                   WHERE idTurno118 IS NOT NULL AND DATE(oraInizioEffettiva) BETWEEN ? AND ?";
    $risultato = db_query($queryCheck, [$dataInizio, $dataFine], [PDO::PARAM_STR, PDO::PARAM_STR]);

    $totale = $risultato[0]['totale'];
    $convalidati = $risultato[0]['convalidati'];

    if ($totale > 0 && $convalidati == 0) {
        db_query("UPDATE turniutenti SET convalidato = 1 WHERE idTurno118 IS NOT NULL AND DATE(oraInizioEffettiva) BETWEEN ? AND ?", [$dataInizio, $dataFine], [PDO::PARAM_STR, PDO::PARAM_STR]);

        $dataEmissione = date("Y-m-d");
        $titolo = "Turni $mese/$anno";
        $testo = "I turni del mese $mese/$anno sono stati pubblicati. Ora puoi visualizzarli.";
        $dataScadenza = $dataFine;
        $idTipo = 4; // eventi
        $idUtente = 0; // ???????

        db_query(
            "INSERT INTO comunicazioni (dataEmissione, titolo, testo, dataScadenza, idTipo, idUtente) 
             VALUES (?, ?, ?, ?, ?, ?)",
            [$dataEmissione, $titolo, $testo, $dataScadenza, $idTipo, $idUtente],
            [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT, PDO::PARAM_INT]
        );

        return "Tutti i turni del mese sono stati convalidati e la comunicazione è stata inserita.";
    }

    return "Attenzione: alcuni turni sono già stati convalidati oppure non ci sono turni per questo mese.";
}
?>