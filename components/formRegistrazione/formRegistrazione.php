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
                <div class="mb-3">
                    <label class="form-label">Cognome</label>
                    <input type="text" name="cognome" class="form-control" maxlength="30" required>
                    ' . mostraErrore("cognome", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" maxlength="30" required>
                    ' . mostraErrore("nome", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Codice Fiscale</label>
                    <input type="text" name="codiceFiscale" class="form-control" maxlength="16" required>
                    ' . mostraErrore("codiceFiscale", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Data di nascita</label>
                    <input type="date" name="dataNascita" class="form-control" required>
                    ' . mostraErrore("dataNascita", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Via</label>
                    <input type="text" name="via" class="form-control" maxlength="20" required>
                    ' . mostraErrore("via", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Numero civico</label>
                    <input type="text" name="numero" class="form-control" maxlength="4" required>
                    ' . mostraErrore("numero", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">CAP</label>
                    <input type="text" name="cap" class="form-control" maxlength="5" required>
                    ' . mostraErrore("cap", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Città</label>
                    <input type="text" name="citta" class="form-control" maxlength="20" required>
                    ' . mostraErrore("citta", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Provincia</label>
                    <input type="text" name="provincia" class="form-control" maxlength="2" required>
                    ' . mostraErrore("provincia", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" maxlength="30" required>
                    ' . mostraErrore("username", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" maxlength="30" required>
                    ' . mostraErrore("password", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" maxlength="30" required>
                    ' . mostraErrore("email", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefono</label>
                    <input type="text" name="telefono" class="form-control" maxlength="13" required>
                    ' . mostraErrore("telefono", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Disponibilità</label>
                    <select name="indisponibilita" class="form-select" required>
                        <option value="0">Disponibile</option>
                        <option value="1">Non disponibile</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Istruttore</label>
                    <select name="istruttore" class="form-select" required>
                        <option value="0">No</option>
                        <option value="1">Sì</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrizione</label>
                    <input type="text" name="descrizione" class="form-control" required>
                    ' . mostraErrore("descrizione", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto del fronte del documento</label>
                    <input type="file" name="fronte" class="form-control" required>
                    ' . mostraErrore("fronte", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto del retro del documento</label>
                    <input type="file" name="retro" class="form-control">
                    ' . mostraErrore("retro", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Data di emissione</label>
                    <input type="date" name="dataEmissione" class="form-control" required>
                    ' . mostraErrore("dataEmissione", $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Data di scadenza</label>
                    <input type="date" name="dataScadenza" class="form-control">
                    ' . mostraErrore("dataScadenza", $errori) . '
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Registrati</button>
                </div>
            </form>
        </div>
    </div>';
}
?>
