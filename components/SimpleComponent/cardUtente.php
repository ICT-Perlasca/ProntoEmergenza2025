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
        $img = htmlspecialchars($utente['immagine']);
    } else {
        $img = 'default.jpg';
    }

    return '
    <a href="profiloUtenteSingolo.php?id=' . $idUtente . '" class="text-decoration-none">
        <div class="card mb-3" style="width: 18rem; background-color: white; color: black; border: 2px solid black; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <img src="' . $img . '" class="card-img-top rounded-circle mx-auto d-block" alt="Foto di ' . $nome . '" style="width: 100px; height: 100px; object-fit: cover;">
            <div class="card-body bg-white text-dark">
                <h5 class="card-title">
                    <span id="nome">' . $nome . '</span>
                    <span id="cognome">' . $cognome . '</span>
                </h5>
                <p class="card-text">Email: ' . $email . '</p>
                <p class="card-text text-success">Ruolo: ' . $ruolo . '</p>
                <div class="text-center">
                    <button class="btn text-white border-dark" style="background-color: #ff6700; background-image: linear-gradient(45deg, #ff8500, #ff4500);">Visualizza Dettagli</button>
                </div>
            </div>
        </div>
    </a>';
}
?>