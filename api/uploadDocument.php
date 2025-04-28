<?php
function API_uploadDocument($get, $post, $session) {
    $conn = new PDO("mysql:host=localhost;dbname=pronto_emergenza", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica la presenza dei dati obbligatori
    if (
        !isset($_FILES["fronte"]) || !isset($post["dataScadenza"]) || empty($post["dataScadenza"])
    ) {
        return json_encode([
            "status" => "error",
            "message" => "Data di scadenza e file fronte sono richiesti"
        ]);
    }

    $dataScadenza = $post["dataScadenza"];
    $dataEmissione = $post["dataEmissione"] ?? null;
    $descrizione = $post["descrizione"] ?? null;

    // Il file fronte è obbligatorio: controlla che esista e che non abbia errori
    if ($_FILES["fronte"]["error"] !== 0) {
        return json_encode([
            "status" => "error",
            "message" => "Errore nel caricamento del file fronte"
        ]);
    }

    $uploadDir = "uploads/"; // Assicurati che la cartella esista ed sia scrivibile
    $uploadedFiles = [];

    // Funzione per processare l'upload di un file
    function processFile($file, $uploadDir, $type) {
        $allowedExtensions = ["jpg", "jpeg", "png", "pdf"];
        $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            return [
                "status" => "error",
                "message" => "Formato file non valido per $type. Sono ammessi solo: JPG, JPEG, PNG, PDF."
            ];
        }

        $uniqueFileName = uniqid($type . "_", true) . "." . $fileExtension;

        if (!move_uploaded_file($file["tmp_name"], $uploadDir . $uniqueFileName)) {
            return [
                "status" => "error",
                "message" => "Errore nel salvataggio del file $type."
            ];
        }

        return [
            "status" => "success",
            "filename" => $uniqueFileName
        ];
    }

    // Processa il file fronte
    $resultFronte = processFile($_FILES["fronte"], $uploadDir, "fronte");
    if ($resultFronte["status"] !== "success") {
        return json_encode($resultFronte);
    }

    $uploadedFiles["fronte"] = $resultFronte["filename"];

    // Processa il file retro, se presente e valido
    if (isset($_FILES["retro"]) && $_FILES["retro"]["error"] === 0) {
        $resultRetro = processFile($_FILES["retro"], $uploadDir, "retro");
        if ($resultRetro["status"] !== "success") {
            error_log($resultRetro["message"]);
            $uploadedFiles["retro"] = null;
        } else {
            $uploadedFiles["retro"] = $resultRetro["filename"];
        }
    } else {
        $uploadedFiles["retro"] = null;
    }

    // Query per l'inserimento nel database (es. con PDO)
    $query = "
        INSERT INTO documenti (fronte, retro, data_scadenza, data_emissione, descrizione) 
        VALUES (:fronte, :retro, :dataScadenza, :dataEmissione, :descrizione)
    ";
    $conn = $conn->prepare($query);
    $conn->execute([
        ':fronte' => $uploadedFiles["fronte"],
        ':retro' => $uploadedFiles["retro"],
        ':dataScadenza' => $dataScadenza,
        ':dataEmissione' => $dataEmissione,
        ':descrizione' => $descrizione
    ]);

    return json_encode([
        "status" => "success",
        "message" => "File caricati con successo.",
        "files" => $uploadedFiles
    ]);
}

// Chiamata dell'API con stampa JSON
header('Content-Type: application/json');
echo API_uploadDocument($_GET, $_POST, []);
