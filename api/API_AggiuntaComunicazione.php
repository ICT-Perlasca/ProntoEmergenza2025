<?php
require_once("funzioniDB.php");
require_once("API_upload.php");
//require_once("./globals.php");
function API_AggiuntaComunicazione($get, $post, $session){
    //global $cartellaImmagini;
   
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }
    $ctrlImg = API_upload([],[], $session,$_FILES);
    if(isset($ctrlImg['error']))
    {
        //da sistemare
        //$res['errore']="file non compatibile";
//        echo json_encode(["errore" => "file non compatibile"]);
        return $ctrlImg; //ritorn lo stesso errore fornito da API_upload       
    }
    else
        $nomeFile=(isset($ctrlImg['nomeFile']))?$ctrlImg['nomeFile']:"nessun file";

    if (!isset($post['titolo'], $post['descrizione'], $post['data_scadenza'], $post['tipo'])) {
        //header('HTTP/1.1 400 Bad Request');
        $res["errore"] = "Dati mancanti";
        return $res;
    }

/*
arrivo qui se non ci sono errori che mi fanno uscire.
inserisci comunicazione in DB e preleva dal risultato lastId (id ultima counicazione inserita)
se esci on errore allora esci con errore dalla procedura
altrimenti
    switch su destinatari in POST 
        se="tutti": metto in $elencoUtenti gli id di tutti gli utenti
        se="tutti_admin": metto in $elencoUtenti gli id di tutti gli utenti con tipoUtente="admin"
        se="tutti_user": metto in $elencoUtenti gli id di tutti gli utenti con tipoUtente="user"
        se="utente_specifico": metto in $elencoUtenti gli id di tutti gli utenti con nome e cgnome= ai dati in POST
    fswitch
    per ogni elemento (id) di $elencoUtenti
        crea query di insert in utenticomunicazioni
        esegui query
    fciclo
    se esci con errore 
    allora esci con errore dalla procedura
    altrimenti esci con success=true
    fse
fse
    */
    $sql = "INSERT INTO comunicazioni (titolo, testo, dataScadenza, idTipo, dataEmissione, nomeFileAllegato, idUtente) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $valori = [
        $post['titolo'],
        $post['descrizione'],
        $post['data_scadenza'],
        $post['tipo'],
        date("Y-m-d"),
        $nomeFile,
        $session['idUtente']
    ];

    $tipi = [
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_INT,
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_INT
    ];

    $risposta = db_query($sql, $valori, $tipi);
    if (isset($risposta['error']))
        return $risposta;
    else{
        $idLastComunicazione=$risposta['lastId'];
        switch($_POST["destinatario"]){
            case 'tutti':
                $strsql = "SELECT * FROM utenti;";
                $elencoUtenti = db_query($strsql, [], []);
                break;
            case 'tutti_admin':
                $strsql = "SELECT idUtente FROM utenti WHERE tipoUtente = 'admin'";
                $elencoUtenti = db_query($strsql, [], []);
                break;
            case 'tutti_user':
                $strsql = "SELECT idUtente FROM utenti WHERE tipoUtente = 'user'";
                $elencoUtenti = db_query($strsql, [], []);
                break;
            case 'utente_specifico':
                $strsql = "SELECT idUtente FROM utenti WHERE cognome = ? AND nome = ?";
                $elencoUtenti = db_query($strsql, [$_POST['cognome'], $_POST['nome']], [PDO::PARAM_STR, PDO::PARAM_STR]);
                break;
        }
        
        for($i = 0; $i < count($elencoUtenti); $i++)
        {
            $strsql = "INSERT INTO utenticomunicazioni (idComunicazione, idUtente) VALUES (?, ?)";
            $valori = [$idLastComunicazione, $elencoUtenti[$i]['idUtente']];
            $tipi = [PDO::PARAM_INT,PDO::PARAM_INT];
            $risposta = db_query($strsql, $valori, $tipi);
        }
         if (isset($risposta['error']))
            return $risposta;
        else
            return(['success'=>true]);
    }
        /*    $sql2 = "SELECT comunicazioni.idComunicazione FROM comunicazioni WHERE comunicazioni.dataEmissione = ? AND comunicazioni.titolo = ?";
    $risposta2 = db_query($sql2, [date("Y-m-d"), $post['titolo']], [PDO::PARAM_STR, PDO::PARAM_STR]);
    if($_POST["destinatario"] == "tutti")
    {
        $sql1 = "SELECT * FROM utenti;";
        $risposta1 = db_query($sql1, [], []);
    
        for($i = 0; $i < count($risposta1); $i++)
        {
            $sql3 = "INSERT INTO utenticomunicazioni (idComunicazione, idUtente) VALUES (?, ?)";
            $valori3 = [
                $risposta2[0]['idComunicazione'],
                $risposta1[$i]['idUtente']
            ];
            $tipi3 = [
                PDO::PARAM_INT,
                PDO::PARAM_INT
            ];
            $risposta3 = db_query($sql3, $valori3, $tipi3);
        }
    } 
     elseif($_POST["destinatario"] == "tutti_admin")
    {
        $sql6 = "SELECT idUtente FROM utenti WHERE tipoUtente = 'admin'";
        $risposta6 = db_query($sql6, [], []);
        for($i = 0; $i < count($risposta6); $i++)
        {
            $sql7 = "INSERT INTO utenticomunicazioni (idComunicazione, idUtente) VALUES (?, ?)";
            $valori7 = [
                $risposta2[0]['idComunicazione'],
                $risposta6[$i]['idUtente']
            ];
            $tipi7 = [
                PDO::PARAM_INT,
                PDO::PARAM_INT
            ];
            $risposta7 = db_query($sql7, $valori7, $tipi7);
        }
    } elseif($_POST["destinatario"] == "tutti_user")
    {
        $sql6 = "SELECT idUtente FROM utenti WHERE tipoUtente = 'user'";
        $risposta6 = db_query($sql6, [], []);
        for($i = 0; $i < count($risposta6); $i++)
        {
            $sql7 = "INSERT INTO utenticomunicazioni (idComunicazione, idUtente) VALUES (?, ?)";
            $valori7 = [
                $risposta2[0]['idComunicazione'],
                $risposta6[$i]['idUtente']
            ];
            $tipi7 = [
                PDO::PARAM_INT,
                PDO::PARAM_INT
            ];
            $risposta7 = db_query($sql7, $valori7, $tipi7);
        }
    } elseif($_POST["destinatario"] == "utente_specifico")
    {
        $sql7 = "SELECT idUtente FROM utenti WHERE cognome = ? AND nome = ?";
        $risposta6 = db_query($sql7, [$_POST['cognome'], $_POST['nome']], [PDO::PARAM_STR, PDO::PARAM_STR]);
        if (count($risposta6) == 0) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(["errore" => "Utente non trovato"]);
            return;
        }
        for($i = 0; $i < count($risposta6); $i++)
        {
            $sql8 = "INSERT INTO utenticomunicazioni (idComunicazione, idUtente) VALUES (?, ?)";
            $valori8 = [
                $risposta2[0]['idComunicazione'],
                $risposta6[$i]['idUtente']
            ];
            $tipi8 = [
                PDO::PARAM_INT,
                PDO::PARAM_INT
            ];
            $risposta8 = db_query($sql8, $valori8, $tipi8);

    }
    }
    if ($risposta) {
        echo json_encode(["successo" => true]);
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(["errore" => "Errore nel database"]);
    }
        */
}
?>