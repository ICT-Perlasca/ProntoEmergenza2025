<?php
function generaCardUtente($utente){
    $idUtente = htmlspecialchars($utente['idUtente'] ?? 'n/a');
    $nome = htmlspecialchars($utente['nome'] ?? 'Nome Sconosciuto');
    $cognome = htmlspecialchars($utente['cognome'] ?? '');
    $email = htmlspecialchars($utente['email'] ?? 'Nessuna email disponibile');
    $img = !empty($utente['foto']) ? htmlspecialchars($utente['foto']) : 'default.jpg';
    
    return '
    <div class="card" style="width: 18rem;" id="'.$idUtente.'">
        <img src="' . $img . '" class="card-img-top" alt="Foto di ' . $nome . '">
        <div class="card-body">
            <h5 class="card-title">
                <span id="nome">' . $nome . '</span>
                <span id="cognome">' . $cognome . '</span>
            </h5>
            <p class="card-text">Email: ' . $email . '</p>
            <a href="mailto:' . $email . '" class="btn btn-primary">Contatta</a>
        </div>
    </div>';
}
?>