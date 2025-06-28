<?php
    require_once("./funzioniDB.php");
function API_SlotTurni($get, $post, $session){
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else if(!isset($post)){
        header('HTTP/1.1 400 Bad Request');
        return [];
    }
    else{
        $anno = 2024;//anno della data attuale
        $mese = $post;

        $dataInizioMeseSel = (new DateTime("$anno-$mese-01"))->format('Y-m-01'); //data del primo giorno del mese selezionato
        $dataFineMeseSel = (new DateTime("$dataInizioMeseSel"))->format('Y-m-t'); //data dell'ultimo giorno del mese selezionato
        $dataInizioMeseSucc = (new DateTime("$dataInizioMeseSel"))->modify('+1 month')->format('Y-m-01'); //data del primo giorno del mese successivo
        $dataFineMeseSucc = (new DateTime("$dataInizioMeseSucc"))->format('Y-m-t'); //data dell'ultimo giorno del mese successivo
        
        $sqlControllaTurni = "SELECT COUNT(*) AS numTurni FROM turni118 WHERE data BETWEEN ? AND ?"; //conteggio turni
        $turniMeseSel = db_query($sqlControllaTurni, [$dataInizioMeseSel, $dataFineMeseSel], [PDO::PARAM_STR, PDO::PARAM_STR]); //numero turni del mese selezionato
        $turniMeseSucc = db_query($sqlControllaTurni, [$dataInizioMeseSucc, $dataFineMeseSucc], [PDO::PARAM_STR, PDO::PARAM_STR]); //numero turni del mese successivo
        
        if(isset($turniMeseSel[0]['numTurni']) && $turniMeseSel[0]['numTurni']>0 || isset($turniMeseSucc[0]['numTurni']) && $turniMeseSucc[0]['numTurni']>0) //se ci sono già dei turni in questo mese non verranno inseriti
            return [];
        else{
            $sqlFest = "SELECT data from festivita WHERE data BETWEEN ? AND ? ORDER BY data;"; //query per ricavare le festività
            $festivitaMeseSel = db_query($sqlFest, [$dataInizioMeseSel, $dataFineMeseSel], [PDO::PARAM_STR, PDO::PARAM_STR]); //festività del mese selezionato
            $festivitaMeseSucc = db_query($sqlFest, [$dataInizioMeseSucc, $dataFineMeseSucc], [PDO::PARAM_STR, PDO::PARAM_STR]); //festività del mese successivo
            $fest = [];
            foreach ($festivitaMeseSel as $f) {
                $fest[] = $f['data'];
            }
            foreach ($festivitaMeseSucc as $f) {
                $fest[] = $f['data'];
            }

            $turni = [
                ['07:00:00', '15:00:00'],
                ['15:00:00', '23:00:00'],
                ['23:00:00', '07:00:00']
            ]; //turni da inserire (mattina, pomeriggio e notte)
            

            if ($mese == 12) {  //se il mese è dicembre, bisogna passare all'anno successivo aggiungendo 1 alla variabile $anno
                $meseSucc = 1;
                $annoSucc = $anno + 1;
            } else {
                $meseSucc = $mese + 1;
                $annoSucc = $anno;
            }
            $dataCorrente = new DateTime("$anno-$mese-01");
            $ultimoGiornoMeseSucc = cal_days_in_month(CAL_GREGORIAN, $meseSucc, $annoSucc); //ultimo giorno del mese successivo
            $dataFine = (new DateTime("$annoSucc-$meseSucc-$ultimoGiornoMeseSucc"))->format('Y-m-d');
            while($dataCorrente <= $dataFine){  //inserimento dei turni nel mese selezionato e in quello successivo
                $dataCorrStr = $dataCorrente->format('Y-m-d');
                if (in_array($dataCorrStr, $fest)) //se è festivo, il campo 'festivo' viene settato a 1
                    $isFestivo = 1;
                else
                    $isFestivo = 0;

                if(!in_array($dataCorrStr, $fest)){ //se non è un giorno festivo, viene inserito il turno
                    foreach($turni as [$oraInizio, $oraFine]){
                        $sqlTurni = "INSERT INTO turni118 (data, oraInizio, oraFine, festivo)
                            VALUES (?, ?, ?, ?);";
                        $inserimentoTurni = db_query($sqlTurni, [$dataInizioMeseSel, $oraInizio, $oraFine, $isFestivo], [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT]);
                    }
                }
                $dataCorrente->modify('+1 day'); //passaggio al giorno successivo
            }
        }
    }
    return $inserimentoTurni;
}

?>