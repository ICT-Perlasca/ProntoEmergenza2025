<?php
//session_start();
require_once "funzioniDB.php";
require_once "./api/API_upload.php";
require_once"./globals.php";

function API_modificaUtente($get, $post, $session) {
    global $cartellaImmagini;
    $response = ['success' => false];

    // 1. Controlla che l'utente sia loggato
    if (!isset($_SESSION['idUtente'])) {
        $response['error'] = 'Utente non autenticato.';
    } else {
        //2. recupera idUtente da GET
        $idUtente=$get['idUtente'];

        // 3. Recupera dati POST
      //readonly  $cognome=$post['cognome'];
      //readonly  $nome=$post['nome'];
        $via=$post['via'];
        $numero=$post['numero'];
        $citta=$post['citta'];
        $tipoUtente=$post['tipoUtente'];
        $status=$post['status'];
        
        if (isset($_FILES['imageUp'])){
            $response=API_upload($cartellaImmagini,$mgProfilo,$_FILES['imageUp'],$get,$post,$session);
            if (isset($response['success']))
                $nomeFileProfilo=$respone['nomeFile'];
            else
                unset($nomeFileProfilo);
        }
        if (isset($post['idRuolo']))
            $idRuolo=$post['idRuolo'];
        else
            unset($idRuolo);

        
    //tutti questi controlli ripetuti anche in API_inserimento Utente=>funzione??
  // Convalida dei valori input
    // Verifica la lunghezza e il formato del codice fiscale (16 caratteri alfanumerici)
    //cod fiscale readonly
/*    if (strlen($post['codiceFiscale']) !== 16 || !preg_match("/^[A-Z0-9]+$/i", $post['codiceFiscale'])) {
        $errori['codiceFiscale'] = "Codice Fiscale non valido.";
    }
    else 
        $codiceFiscale=$post['codiceFiscale'];
  */  
    // Verifica correttezza delle date
    //readonly
/*    $dataNascita = DateTime::createFromFormat('Y-m-d', $post['dataNascita']);
    if (!$dataNascita) {
        $errori['dataNascita'] = "Formato data di nascita non valido.";
    }
  */     
   /* $dataEmissione = DateTime::createFromFormat('Y-m-d', $post['dataEmissione']);
    if (!$dataEmissione) {
        $errori['dataEmissione'] = "Formato data di emissione non valido.";
    }
*/
  /*  $dataScadenza = DateTime::createFromFormat('Y-m-d', $post['dataScadenza']);
    if (!$dataScadenza) {
        $errori['dataScadenza'] = "Formato data di scadenza non valido.";
    }
*/
        // Verifica la validità dell'email
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errori['email'] = "Email non valida.";
        }
        else
            $email=$post['email'];

        // Verifica la validità del numero di telefono (solo numeri, massimo 13 caratteri)
        if (!preg_match("/^\d{10}$/", $post['telefono'])) {
            $errori['telefono'] = "Numero di telefono non valido.";
        }
        else
            $telefono=$post['telefono'];
        
        // Verifica che il CAP sia numerico e di 5 cifre
        if (!preg_match("/^\d{5}$/", $post['cap'])) {
            $errori['cap'] = "CAP non valido (deve essere numerico e lungo 5 cifre).";
        }
        else
            $cap=$post['cap'];
        
        // Verifica che la provincia sia una sigla di 2 lettere
        if (strlen($post['provincia']) !== 2 || !ctype_alpha($post['provincia'])) {
            $errori['provincia'] = "Provincia non valida (deve essere una sigla di 2 lettere).";
        }
        else
            $provincia=$post['provincia'];

        
        // Verifica complessità della password (almeno 8 caratteri, una maiuscola, una minuscola, un numero e almeno un carattere speciale tra ?!*#)
        if (
            strlen($post['password']) < 8 ||
            !preg_match('/[A-Z]/', $post['password']) ||         
            !preg_match('/[a-z]/', $post['password']) ||         
            !preg_match('/[0-9]/', $post['password']) ||         
            !preg_match('/[?!*#]/', $post['password'])        
        ) {
            $errori['password'] = "La password deve contenere almeno 8 caratteri, una maiuscola, una minuscola, un numero e un carattere speciale tra ?!*#";
        }
        else {
            if ($post['password']!='')
                $password=$post['password'];
            //else $password non  è settata
        }

        
        // Verifica che il valore di indisponibilita sia 0 o 1
        if (!in_array($post['indisponibilita'], ['0', '1'], true)) {
            $errori['indisponibilita'] = "Il valore del campo indisponibilita deve essere 0 o 1.";
        }
        else 
            $indisponibilita=$post['indisponibilita'];
        
        // Verifica che il valore di istruttore sia 0 o 1
        if (!in_array($post['istruttore'], ['0', '1'], true)) {
            $errori['istruttore'] = "Il valore del campo istruttore deve essere 0 o 1.";
        }
        else         
            $indisponibilita=$post['indisponibilita'];

        // Verifica che l'email non sia già presente nel database
        $query = "SELECT COUNT(*) as n FROM utenti WHERE email=?";
        $valori = [$post['email']];
        $tipi = [PDO::PARAM_STR];
        $n = db_query($query, $valori, $tipi);
        if ($n[0]['n'] > 0) {
            $errori["email"] = "Email già registrata.";
        }
        // Se ci sono errori, restituisci l'array di errori
        if (count($errori) > 0) {
            return $errori;
        }
        else{


            //4. byprati: query di aggiornamento dell'npla dell'utente
            //potrebbe non essere stata inserita la nuova immagine => quindi non si deve aggiornare l'attributo
            //potrebbe non essere inserita una nuova password => quindi non si deve aggiornare l'attributo

            
            $strsql="update utenti set ";
            $strsql.="via=?, numero=?, cap=?, citta=? provincia=?, email=?, telefono=?, indisponibilita=?,
                    istruttore=?, tipoUtente=?, status=? ";
            $valori=[$via,$numero,$cap,$citta,$provincia,$email,$telefono,$indisponibilita,$istruttore,$tipoUtente,$status];
            $tipi=[PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT,PDO::PARAM_INT,PDO::PARAM_STR,PDO::PARAM_STR];
            if(isset($nomeFileProfilo)){
                $strsql.=",immagine=?";
                $valori[]=$nomeFileProfilo;
                $tipi[]=PDO::PARAM_STR;
            }
            if(isset($password)){
                $strsql.=",password=?";
                $valori[]=$password;
                $tipi[]=PDO::PARAM_STR;
            }

            $strsql.=" where idUtente=?";
            $valori[]=$idUtente;
            $tipi[]=PDO::PARAM_INT;
            $resUpdate=db_query($strsql,$valori,$tipi);

            if (isset($resUpdate['error'])) {
                $response['error'] = "Errore nell'aggiornamento dell'utente num.  $idUtente Errore dalla query:".$resUpdate['error'];
            } else {
                $response['success']=true;
            }
                    // 5.se è stato inserito un nuovo ruolo $post[idRuolo]!=""//id del ruolo
            //  aggiunta ruolo in utentiruoli

        }
        }

    //header('Content-Type: application/json');
    return $response;
}
