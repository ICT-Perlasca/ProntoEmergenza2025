<?php
// Funzione per processare un singolo file
    function processFile(array $file, string $uploadDir, string $role, array $allowedTypes) {
		// Verifica se i dati del file sono presenti e se non ci sono errori
		if (!isset($file["name"], $file["tmp_name"]) || $file["error"] !== UPLOAD_ERR_OK) {
			return false;
		}

		// Estrai e normalizza l'estensione del file
		$extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

		// Verifica che il tipo di file sia consentito
		if (!in_array($extension, $allowedTypes, true)) {
			return false;
		}

		$timestamp = date("YmdHis");
		$safeRole = strtolower($role) === "fronte" ? "f" : "r";
		$originalName = $file["name"];
		$hashedName = md5($originalName);
		$fileName = "{$timestamp}_{$safeRole}_{$hashedName}.{$extension}";
		$destination = "$uploadDir/$fileName";

		// Sposta il file caricato nella destinazione desiderata
		if (!move_uploaded_file($file["tmp_name"], $destination)) {
			return false;
		}

		return $fileName;
	}
//vel vettore get vengono forniti i nomi dei campi dei form di tipo file che devono essere uploadati
function API_uploadDocument($get, $post, $session,$allowedTypes = ['jpg', 'jpeg', 'png', 'pdf']) {
    $errors = [];

    // Validazioni iniziali
    if (!isset($session["idUtente"])) {
        return ["Utente non registrato."];
    }

    if (!isset($_FILES["fronte"])) {
        $errors["fronte"] = "File 'fronte' mancante.";
    }

    if (!isset($post["descrizione"]) || empty($post["descrizione"])) {
        $errors["descrizione"] = "Descrizione mancante.";
    }

    if (!isset($post["dataScadenza"]) || empty($post["dataScadenza"])) {
        $errors["dataScadenza"] = "Data di scadenza mancante.";
    }
    
    if (!empty($errors)) {
        return $errors;
    }

    $dataScadenza = $post["dataScadenza"];
    $dataEmissione = $post["dataEmissione"] ?? null;
    $descrizione = $post["descrizione"] ?? null;
    $uploadDir = "uploads/documenti";
    $idUtente = $session["idUtente"];

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        return ["Impossibile creare la directory di upload."];
    }

    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    $uploadedFiles = [];

    

    // Fronte obbligatorio
    $fronteResult = processFile($_FILES["fronte"], $uploadDir, "fronte", $allowedTypes);
    if ($fronteResult === false) {
        $errors["fronte"] = "Errore nel caricamento del file 'fronte' o tipo non valido.";
        return $errors;
    }
    $uploadedFiles["fronte"] = $fronteResult;

    // Retro opzionale
    $retroResult = processFile($_FILES["retro"], $uploadDir, "retro", $allowedTypes);
    if ($retroResult === false) {
        $errors["retro"] = "Errore nel caricamento del file 'retro' o tipo non valido.";
        $uploadedFiles["retro"] = null;
    } else {
        $uploadedFiles["retro"] = $retroResult;
    }
    

    // Query di inserimento nel DB
    $query = "INSERT INTO 
				documenti 
					(descrizione, fronte, retro, dataEmissione, dataScadenza, idUtente) 
				VALUES 
					(?, ?, ?, ?, ?, ?)
    ";

    $values = [
        $descrizione,
        $uploadedFiles["fronte"],
        $uploadedFiles["retro"],
        $dataEmissione,
        $dataScadenza,
        $idUtente
    ];

    $types = [
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_STR,
        PDO::PARAM_INT
    ];

    $res = db_query($query, $values, $types);
    if ($res == 0) {
        $errors[] = "Errore nell'inserimento del documento";
    }

    return $errors;
}
?>
