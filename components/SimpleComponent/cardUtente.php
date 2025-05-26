<?php
function generaCardUtente($utente) {
    if (isset($utente['idUtente'])) {
        $idUtente = htmlspecialchars($utente['idUtente']);
    } else {
        $idUtente = 'n/a';
    }

    if (isset($utente['nome'])) {
        $nome = htmlspecialchars($utente['nome']);
    } else {
        $nome = 'Nome Sconosciuto';
    }

    if (isset($utente['cognome'])) {
        $cognome = htmlspecialchars($utente['cognome']);
    } else {
        $cognome = '';
    }

    if (isset($utente['email'])) {
        $email = htmlspecialchars($utente['email']);
    } else {
        $email = 'Nessuna email disponibile';
    }

    if (isset($utente['status'])) {
        $ruolo = htmlspecialchars($utente['status']);
    } else {
        $ruolo = 'Ruolo sconosciuto';
    }

    if (!empty($utente['immagine'])) {
        $img = './uploads/images/' . htmlspecialchars($utente['immagine']);
    } else {
        $img = './public/images/avatar.jpg';
    }

    return '
        <div class="card mb-3">
            <img src="' . $img . '" class="card-img-top rounded-circle mx-auto d-block" alt="Foto di ' . $nome . '" style="width: 100px; height: 100px; object-fit: cover;">
            <div class="card-body bg-white text-dark">
                <h5 class="card-title">
                    <span id="ricerca1">' . $nome . '</span>
                    <span id="ricerca2">' . $cognome . '</span>
                </h5>
                <p class="card-text">' . $email . '</p>
                <p class="card-text text-success">Ruolo: ' . $ruolo . '</p>
                <div class="text-center">
                    <a href="utenti/profiloUtente?emailUt=' . $email . '" class="text-decoration-none btn btn-primary">
                        Visualizza Dettagli
                    </a>
                </div>
            </div>
        </div>';
}
?>