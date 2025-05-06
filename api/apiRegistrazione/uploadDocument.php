<?php
function API_uploadDocument($get, $post, $session) {
    $errors = [];

    // Validazioni iniziali
    if (!isset($_FILES["fronte"])) {
        $errors[] = "File 'fronte' mancante nella richiesta.";
    }

    if (!isset($post["dataScadenza"]) || empty($post["dataScadenza"])) {
        $errors[] = "Campo 'dataScadenza' mancante o vuoto.";
    }

    if (!isset($session["idUtente"])) {
        $errors[] = "Utente non autenticato.";
    }

    if (!empty($errors)) {
        return $errors;
    }

    $dataScadenza   = $post["dataScadenza"];
    $dataEmissione  = $post["dataEmissione"] ?? null;
    $descrizione    = $post["descrizione"] ?? null;
    $uploadDir      = "uploads/documenti";
    $idUtente       = (int) $session["idUtente"];

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        return ["Impossibile creare la directory di upload."];
    }

    $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    $uploadedFiles = [];

    // Funzione per processare un singolo file
    function processFile(array $file, string $uploadDir, string $role, array $allowedTypes, int $idUtente) {
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
		$originalName = pathinfo($file["name"], PATHINFO_FILENAME);
		$hashedName = md5($originalName);
		$fileName = "{$timestamp}_{$safeRole}_{$hashedName}.{$extension}";
		$destination = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

		// Sposta il file caricato nella destinazione desiderata
		if (!move_uploaded_file($file["tmp_name"], $destination)) {
			return false;
		}

		return $fileName;
	}


    // Fronte obbligatorio
    $fronteResult = processFile($_FILES["fronte"], $uploadDir, "fronte", $allowedTypes, $idUtente);
    if ($fronteResult === false) {
        $errors[] = "Errore nel caricamento del file 'fronte' o tipo non valido.";
        return $errors;
    }
    $uploadedFiles["fronte"] = $fronteResult;

    // Retro opzionale
    if (isset($_FILES["retro"]) && $_FILES["retro"]["error"] === UPLOAD_ERR_OK) {
        $retroResult = processFile($_FILES["retro"], $uploadDir, "retro", $allowedTypes, $idUtente);
        if ($retroResult === false) {
            $errors[] = "Errore nel caricamento del file 'retro' o tipo non valido.";
            $uploadedFiles["retro"] = null;
        } else {
            $uploadedFiles["retro"] = $retroResult;
        }
    } else {
        $uploadedFiles["retro"] = null;
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
