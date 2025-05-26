<?php
require_once "funzioniDB.php";
require_once "api/apiRegistrazione/uploadDocument.php";

function API_inserimentoUtente($get, $post, $session) {

    $campiObbligatori = [
        "cognome", "nome", "codiceFiscale", "dataNascita",
        "via", "numero", "cap", "citta", "provincia",
        "username", "password", "email", "telefono",
        "indisponibilita", "istruttore"
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
    
    // Verifica la data di nascita
    
    $dataNascita = DateTime::createFromFormat('Y-m-d', $post['dataNascita']);
    if (!$dataNascita) {
        $errori['dataNascita'] = "Formato data di nascita non valido.";
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
    
    // Procedi con l'inserimento dell'utente nel database
    $query = "INSERT INTO utenti (
                cognome, nome, codiceFiscale, dataNascita,
                via, numero, cap, citta, provincia,
                username, password, email, telefono,
                indisponibilita, istruttore, status, tipoUtente 
            ) VALUES (
                ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?
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
        "volontario",
        "user",
    ];

    $tipi = [
        PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR,
        PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR,
        PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR, PDO::PARAM_STR,
        PDO::PARAM_INT, PDO::PARAM_INT, PDO::PARAM_STR, PDO::PARAM_STR
    ];

    $rows = db_query($query, $valori, $tipi);
    if (isset($rows["error"])) {
        $errori[] = "Errore nell'inserimento dell'utente: " . $rows["error"];
        return $errori;
    }
	$q = "SELECT idUtente FROM utenti WHERE email=?";
	$valori = [$post['email']];
	$tipi = [PDO::PARAM_STR];
	$idUtente = db_query($q, $valori, $tipi);
    
    $res["doc"] = API_uploadDocument([], $post, ["idUtente" => $idUtente]);

    if (count($res["doc"]) > 0) {
		$errori[] = $res["doc"];
        return $errori;
	}
		
    // TODO: Invio notifica via email agli admin
    
    return [];
}
?>
