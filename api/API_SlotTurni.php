<?php
    require_once("./funzioniDB.php");//implicito require di globals...
function API_SlotTurni($get, $post, $session){
    global $turni;

    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else if(!isset($post)){
        header('HTTP/1.1 400 Bad Request');
        return [];
    }
    else{
        /*byprati:
        calcolo data inizio e data fine (dal 1-mese-anno al 30 o 31-mese-anno)
        controllo se esistono già slot inseriti
        se nella tabella turni118 esiste gia almeno uno slot per tale mese-anno
        allora
            messaggio[status]='nok'
            messaggio[testo]= "Il mese è gia stato programmato. Puoi inserire i turni"
        altrimenti
            per ogni giorno tra data inizio e data fine
                 inserisco i 3 slot per la data nella tabella turni118
            fciclo
            messaggio[status]=ok
            messaggio[testo] "inserimento con successo dei turni dal xxxx(datainizio) al yyyy(datafine)"

        fse
        ritorno array messaggio
        */
        $anno = $post['anno'];//anno della data attuale
        $mese = $post['mese'];

        $dataInizioMeseSel = (new DateTime("$anno-$mese-01"))->format('Y-m-01'); //data del primo giorno del mese selezionato
        $dataFineMeseSel = (new DateTime("$dataInizioMeseSel"))->format('Y-m-t'); 
        //echo $dataInizioMeseSel."<br>".$dataFineMeseSel."<br>";//data dell'ultimo giorno del mese selezionato
     
        $sqlControllaTurni = "SELECT COUNT(*) AS numTurni FROM turni118 WHERE data BETWEEN ? AND ?"; //conteggio turni
        $turniMeseSel = db_query($sqlControllaTurni, [$dataInizioMeseSel, $dataFineMeseSel], [PDO::PARAM_STR, PDO::PARAM_STR]); //numero turni del mese selezionato
        
        if(isset($turniMeseSel[0]['numTurni']) && $turniMeseSel[0]['numTurni']>0){ //se ci sono già dei turni in questo mese non verranno inseriti
            $messaggio['status']='nok';
            $messaggio['testo']= "Il mese è gia stato programmato. Devi solo iniziare ad inserire i turni";
        }
        else{
            //echo"nn ho trovato slot <br>";          
            $dataCorrente=$dataInizioMeseSel;
            while($dataCorrente <= $dataFineMeseSel){  //inserimento dei turni nel mese selezionato e in quello successivo
                
                if (isFestivo($dataCorrente)) //se è festivo (ossia anche domenica), il campo 'festivo' viene settato a 1
                    $isFestivo = 1;
                else
                    $isFestivo = 0;

                foreach($turni as [$oraInizio, $oraFine]){
                    $sqlTurni = "INSERT INTO turni118 (data, oraInizio, oraFine, festivo) VALUES (?, ?, ?, ?);";
                    $insSlot= db_query($sqlTurni, [$dataCorrente, $oraInizio, $oraFine, $isFestivo], [PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_INT]);
                   //echo "npla - ".$dataCorrente."<br>".$oraInizio." ".$oraFine."<br>";

                }
                $dataCorrObj = new DateTime($dataCorrente);
                $dataCorrObj->modify('+1 day'); //passaggio al giorno successivo
                $dataCorrente=$dataCorrObj->format('Y-m-d');//trasforma in stringa
            }
            $messaggio['status']='ok';
            $messaggio['testo']= "Il mese in programmazione dal ".$dataInizioMeseSel." al ".$dataFineMeseSel. "è stato impostato con successo";

        }
        return $messaggio;
    }
   
}

?>