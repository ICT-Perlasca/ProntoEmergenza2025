<?php
require_once("funzioniDB.php");
require_once("API_upload.php");
require_once("./globals.php");
function API_AggiuntaComunicazione($get, $post, $session){
    global $cartellaBacheca;
   
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }

    if (!isset($post['titolo'], $post['descrizione'], $post['data_scadenza'], $post['tipo'])) {
        //header('HTTP/1.1 400 Bad Request');
        $res["errore"] = "Dati mancanti";
        return $res;
    }
/*
se esiste file trasferito 
    allora
       si fa upload
       se errore nell'upload
           si esce
        altrimenti
            siimposta il nome del file uploadato da inserire nell'npla
        fse
    altirmenti
       il nome del file uploadato="" da inserire nell'npla
fse

*/
    if ($_FILES['fileUp']['error']!=4){// se vero esiste allegato
        $ctrlImg = API_upload("./$cartellaBacheca/",$_FILES['fileUp'],[],[], $session);
        if(isset($ctrlImg['error'])){
        //da sistemare
        //$res['error']="file non compatibile";
//        echo json_encode(["errore" => "file non compatibile"]);
            return $ctrlImg; //ritorn lo stesso errore fornito da API_upload       
        }
        else 
            $nomeFile=(isset($ctrlImg['nomeFile']))?$ctrlImg['nomeFile']:"nessun file";
    }
    else//UPLOAD_ERR_NO_FILE  => ossia non esiste allegato
        $nomeFile="";
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
/*                $strsql = "SELECT idUtente FROM utenti WHERE cognome = ? AND nome = ?";
                $elencoUtenti = db_query($strsql, [$_POST['cognome'], $_POST['nome']], [PDO::PARAM_STR, PDO::PARAM_STR]);
                */
                $elencoUtenti[0]['idUtente']=$_POST['idUtente'];
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
        else{
            $risposta['success']=true;
            if ($nomeFile !=""){
                $risposta['nomeFile']=$nomeFile;
                $risposta['msgio']="Comunicazione inserita con successo con trasferimento del file";
            }
            else
                $risposta['msgio']="Comunicazione inserita con successo senza trasferimento di file";

            return $risposta;
        }
    }
}
?>