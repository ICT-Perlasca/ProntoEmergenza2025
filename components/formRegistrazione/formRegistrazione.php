<?php
function mostraErrore($campo, $errori) {
    if (is_array($errori) && isset($errori[$campo])) {
        return '<span class="text-danger d-block mt-1">' . htmlspecialchars($errori[$campo]) . '</span>';
    }
    return '';
}

function COMP_formRegistrazione(array $errori = []) {
    return '
    <div class="row min-vh-100 justify-content-center align-items-center bg-primary text-white py-5">
        <div class="col-12 col-md-8 col-lg-6 bg-white text-dark p-5 rounded shadow">
        <form method="POST" enctype="multipart/form-data">

            <!-- Dati Anagrafici -->
            <h5 class="mb-3">Dati anagrafici</h5>
            <hr class="mb-4">

            <div class="mb-3">
                <label class="form-label">Cognome</label>
                <input type="text" name="cognome" class="form-control border-primary" maxlength="30" required>
                <?= mostraErrore(\'cognome\', $errori) ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control border-primary" maxlength="30" required>
                <?= mostraErrore(\'nome\', $errori) ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Codice Fiscale</label>
                <input type="text" name="codiceFiscale" class="form-control border-primary" maxlength="16" required>
                <?= mostraErrore(\'codiceFiscale\', $errori) ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Data di nascita</label>
                <input type="date" name="dataNascita" class="form-control border-primary" required>
                <?= mostraErrore(\'dataNascita\', $errori) ?>
            </div>

            <!-- Indirizzo -->
            <h5 class="mt-4 mb-3">Indirizzo</h5>
            <hr class="mb-4">

            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Via</label>
                    <input type="text" name="via" class="form-control border-primary" maxlength="20" required>
                    <?= mostraErrore(\'via\', $errori) ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Numero civico</label>
                    <input type="text" name="numero" class="form-control border-primary" maxlength="4" required>
                    <?= mostraErrore(\'numero\', $errori) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">CAP</label>
                    <input type="text" name="cap" class="form-control border-primary" maxlength="5" required>
                    <?= mostraErrore(\'cap\', $errori) ?>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Città</label>
                    <input type="text" name="citta" class="form-control border-primary" maxlength="20" required>
                    <?= mostraErrore(\'citta\', $errori) ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Provincia</label>
                    <input type="text" name="provincia" class="form-control border-primary" maxlength="2" required>
                    <?= mostraErrore(\'provincia\', $errori) ?>
                </div>
            </div>

            <!-- Disponibilità & Ruolo -->
            <h5 class="mt-4 mb-3">Disponibilità e ruolo</h5>
            <hr class="mb-4">

            <div class="mb-4 text-center">
                <div class="row justify-content-center g-3">
                    <div class="col-md-5">
                        <label class="form-label">Disponibilità</label>
                        <select class="form-select rounded-pill border-2 border-primary bg-light text-dark shadow-sm" name="indisponibilita" required>
                            <option value="0">Disponibile</option>
                            <option value="1">Non disponibile</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Ruolo</label>
                        <select class="form-select rounded-pill border-2 border-primary bg-light text-dark shadow-sm" name="istruttore" required>
                            <option value="0">Non Istruttore</option>
                            <option value="1">Istruttore</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Documento -->
            <h5 class="mt-4 mb-3">Documento </h5>
            <hr class="mb-4">

            <div class="mb-4">
                <label class="form-label" for="fronte">Foto del fronte del documento</label>
                <div class="input-group">
                    <input type="file" id="fronte" name="fronte" class="d-none" required onchange="document.getElementById(\'fronte-label\').innerText = this.files[0].name">
                    <label for="fronte" class="btn btn-outline-primary rounded-3 border-2">Scegli file</label>
                    <span id="fronte-label" class="ms-3">Nessun file selezionato</span>
                </div>
                <?= mostraErrore(\'fronte\', $errori) ?>
            </div>

            <div class="mb-4">
                <label class="form-label" for="retro">Foto del retro del documento</label>
                <div class="input-group">
                    <input type="file" id="retro" name="retro" class="d-none" onchange="document.getElementById(\'retro-label\').innerText = this.files[0].name">
                    <label for="retro" class="btn btn-outline-primary rounded-3 border-2">Scegli file</label>
                    <span id="retro-label" class="ms-3">Nessun file selezionato</span>
                </div>
                <?= mostraErrore(\'retro\', $errori) ?>
            </div>

            <div class="mb-4">
                <label class="form-label">Data di emissione</label>
                <input type="date" name="dataEmissione" class="form-control rounded-3 border-2 border-primary" required>
                <?= mostraErrore(\'dataEmissione\', $errori) ?>
            </div>

            <div class="mb-4">
                <label class="form-label">Data di scadenza</label>
                <input type="date" name="dataScadenza" class="form-control rounded-3 border-2 border-primary">
                <?= mostraErrore(\'dataScadenza\', $errori) ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrizione</label>
                <input type="text" name="descrizione" class="form-control border-primary" required>
                <?= mostraErrore(\'descrizione\', $errori) ?>
            </div>

            <!-- Account -->
            <h5 class="mt-4 mb-3">Credenziali di accesso</h5>
            <hr class="mb-4">

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control border-primary" maxlength="30" required>
                <?= mostraErrore(\'username\', $errori) ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control border-primary" maxlength="30" required>
                <?= mostraErrore(\'password\', $errori) ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control border-primary" maxlength="30" required>
                <?= mostraErrore(\'email\', $errori) ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Telefono</label>
                <input type="text" name="telefono" class="form-control border-primary" maxlength="13" required>
                <?= mostraErrore(\'telefono\', $errori) ?>
            </div>

            <!-- Submit -->
            <div class="d-flex justify-content-center mt-4">
                <div class="px-2">
                    <button type="submit" class="btn btn-primary">Registrati</button>
                </div>
                <div class="px-2">
                    <a href="login.php" class="btn btn-secondary">Login</a>
                </div>
            </div>

        </form>
    </div>
</div>';
}
?>
