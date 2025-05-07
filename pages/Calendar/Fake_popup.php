<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Test Popup Bootstrap</title>
    <base href="./" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">

<?php
require_once("./../../components/Popup/popup.php");

// Stampa il popup nella pagina
echo COMP_Popup(
    'popupConferma',
    'Sei sicuro?',
    'Vuoi davvero procedere con questa azione?',
    "alert('Hai confermato!')"
);
?>

<!-- Bottone per aprire il popup -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#popupConferma">
    Mostra popup
</button>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
