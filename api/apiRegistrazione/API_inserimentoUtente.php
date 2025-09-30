<?php
require_once "funzioniDB.php";
require_once "globals.php";
require_once "./api/API_upload.php";

function API_inserimentoUtente($get, $post, $session) {
globals $cartellaImmagini, $cartellaDocumenti;
    $campiObbligatori = [
        "cognome", "nome", "codiceFiscale", "dataNascita",
        "via", "numero", "cap", "citta", "provincia","telefono",
        "emil","username", "password",
        "indisponibilita", "istruttore","dataEmissione",
        "dataScadenza","tipoUtente", "status"
    ];
    
    $errori = [];

    // Verifica che tutti i campi obbligatori siano presenti
    foreach ($campiObbligatori as $campo) {
        if (!isset($post[$campo]) || trim($post[$campo]) === "") {
            $errori[$campo] = "Campo obbligatorio mancante o vuoto: $campo";
        }
    }

    // Convalida dei valori input
    // Verifica la lunghezza e il formato del codice fiscale (16 caratteri alfanumerici)
    if (strlen($post['codiceFiscale']) !== 16 || !preg_match("/^[A-Z0-9]+$/i", $post['codiceFiscale'])) {
        $errori['codiceFiscale'] = "Codice Fiscale non valido.";
    }
    
    // Verifica correttezza delle date
    $dataNascita = DateTime::createFromFormat('Y-m-d', $post['dataNascita']);
    if (!$dataNascita) {
        $errori['dataNascita'] = "Formato data di nascita non valido.";
    }
    $dataEmissione = DateTime::createFromFormat('Y-m-d', $post['dataEmissione']);
    if (!$dataEmissione) {
        $errori['dataEmissione'] = "Formato data di emissione non valido.";
    }
    $dataScandenza = DateTime::createFromFormat('Y-m-d', $post['dataScadenza']);
    if (!$dataScadenza) {
        $errori['dataScadenza'] = "Formato data di scadenza non valido.";
    }

    // Verifica la validità dell'email
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        $errori['email'] = "Email non valida.";
    }

    // Verifica la validità del numero di telefono (solo numeri, massimo 13 caratteri)
    if (!preg_match("/^\d{10}$/", $post['telefono'])) {
        $errori['telefono'] = "Numero di telefono non valido.";
    }
    
    // Verifica che il CAP sia numerico e di 5 cifre
    if (!preg_match("/^\d{5}$/", $post['cap'])) {
        $errori['cap'] = "CAP non valido (deve essere numerico e lungo 5 cifre).";
    }
    
    // Verifica che la provincia sia una sigla di 2 lettere
    if (strlen($post['provincia']) !== 2 || !ctype_alpha($post['provincia'])) {
        $errori['provincia'] = "Provincia non valida (deve essere una sigla di 2 lettere).";
    }
    
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

    
    // Verifica che il valore di indisponibilita sia 0 o 1
    if (!in_array($post['indisponibilita'], ['0', '1'], true)) {
        $errori['indisponibilita'] = "Il valore del campo indisponibilita deve essere 0 o 1.";
    }
    
    // Verifica che il valore di istruttore sia 0 o 1
    if (!in_array($post['istruttore'], ['0', '1'], true)) {
        $errori['istruttore'] = "Il valore del campo istruttore deve essere 0 o 1.";
    }

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
        // Procedi con l'inserimento dell'utente nel database
        $query = "INSERT INTO utenti (
                    cognome, nome, codiceFiscale, dataNascita,
                    via, numero, cap, citta, provincia,
                    username, password, email, telefono,
                    indisponibilita, istruttore, status, tipoUtente, dataoraInvioEmail
                ) VALUES (
                    ?, ?, ?, ?,
                    ?, ?, ?, ?, ?,
                    ?, ?, ?, ?,
                    ?, ?, ?, ?,?
                )
        ";

        $valori = [
            trim($post['cognome']),
            trim($post['nome']),
            strtoupper(trim($post['codiceFiscale'])),
            $post['dataNascita'],
            trim($post['via']),
            trim($post['numero']),
            trim($post['cap']),
            trim($post['citta']),
            strtoupper(trim($post['provincia'])),
            trim($post['username']),
            trim($post['password']),
            trim($post['email']),
            trim($post['telefono']),
            (int)$post['indisponibilita'],
            (int)$post['istruttore'],
            $post['status'],
            $post['tipoUtente'],
            date("Y-m-d H:i:s")
        ];

        $tipi = [
            PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR,
            PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR,
            PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR,
            PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR
        ];

        $rows = db_query($query, $valori, $tipi);
        if (isset($rows["error"])) {
            $errori['insgenerale'] = "Errore nell'inserimento dell'utente: " . $rows["error"];
            return $errori;
        }
        else{
            //$q = "SELECT idUtente FROM utenti WHERE email=?";
            //$valori = [$post['email']];
            //$tipi = [PDO::PARAM_STR];
            //$idUtente = db_query($q, $valori, $tipi);
            $idUtente=$rows['lastId'];

            //inserimento del ruolo selezionato in tabella utentiruoli
            $query="insert into utentiruoli(idUtente,idRuolo) values(?,?)";
            $valori=[$idUtente,$post['idRuolo']];
            $tipi=[PDO::PARAM_INT,PDO::PARAM_INT];
            $rowdoc=db_query($query,$valori,$tipi);
            if (isset($rows["error"])) {
                $errori['errorIns'] = "Errore nell'inserimento del ruolo dell'utente: " . $rows["error"];
                return $errori;
            }
            else{
            /* immaginedel profilo
            se esiste immagineprofilo
                 upload immagine profilo
                se esistono errori
                allora
                     ritorna con errore
                altrimenti
                    update npla utente con idUtente x aggiornare campo immagine con nome file caricato
                    se errori in update allora ritorna con errori fse
                fse
              fse
              */
              /* documento inserito
             se esiste immagine fronte o retro
             allora
                 se esiste fronte upload immagine fronte fse
                 se esiste retro upload immagine retro fse
                se ci sono errori
                allora
                    ritorna con errori
                altrimenti
                    inserisci npla ni documenti con nome file fronte, retro, descrizione(se esiste) dataEmissione, dataScandeza, tipoDocumento ed idUtente   
                    se errore in insert allora ritorna con errori fse
                fse
              fse
  

            */
            if (isset($_FILES['imgUp'])){
                $ret=API_upload($cartellaImmagini,$_FILE['imgUp'],$get,$post,$session);
                if (isset($ret['error']))
                    $errori['errorImg']='utente inserito ma immagine profilo non caricata';
                else{
                    $query="update utenti set immagine=? where idUtente=?;";
                    $valori=[$ret['nomeFile'],$idUtente];
                    $tipi=[PDO::PARAM_STR,PDO::PARAM_INT];
                    $rowdoc=db_query($query,$valori,$tipi);
                    if (isset($rowdoc['error']))
                        $errori['error']='errore in aggiornamento utente per nome file immagine-'.$rowdoc['error'];
                }

            }
            if (isset($_FILES['fronte']) || isset ($_FILES['retro'])){
                if (isset($_FILES['fronte'])){
                    $retfronte=API_upload($cartellaDocumenti,$_FILE['fronte'],$get,$post,$session);
                    if (isset($ret['error'])){
                        $errori['errorDoc'].='utente inserito ma fronte documento non caricato';
                        $fronte='';
                    }
                    else
                        $fronte=$retfronte['nomeFile'];
                }
                if (isset($_FILES['retro'])){
                    $retretro=API_upload($cartellaDocumenti,$_FILE['retro'],$get,$post,$session);
                    if (isset($ret['error'])){
                        $errori['errorDoc'].='utente inserito ma retro documento non caricato';
                        $retro='';
                    }
                    else
                        $retro=$retretro['nomeFile'];
                }
                if (!isset($ret['errorDoc'])){ //quindi tutto OK
                    if (isset($post['descrizione']))
                        $descr=$post['descrizione'];
                    else
                        $desc='';
                    $query="insert into documenti(idTipoDocumento, descrizione, fronte, retro,
                        dataEmissione,dataScadenza, idUtente) 
                        values(?,?,?,?,
                        ?,?,?)";
                    $valori=[$post['idTipoDocumento'],$desc,$fronte,$retro,
                        $post['dataEmissione'],$post['dataScadenza'],$idUtente];
                    $tipi=[PDO::PARAM_INT,PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_STR,
                           PDO::PARAM_STR,PDO::PARAM_STR,PDO::PARAM_INT];
                    $rowdoc=db_query($query,$valori,$tipi);
                    if (isset($rowdoc['error']))
                        $errori['error']='errore in inserimento documento per utente -'.$rowdoc['error'];                       
                }
            }
            

    // TODO: Invio notifica via email agli admin
    
                return [];
            }
        }
    }
}
?>
