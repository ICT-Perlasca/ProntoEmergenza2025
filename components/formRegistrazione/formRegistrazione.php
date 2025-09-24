<?php
function mostraErrore($campo, $errori) {
    if (is_array($errori) && isset($errori[$campo])) {
        return '<span class="text-danger d-block mt-1">' . htmlspecialchars($errori[$campo]) . '</span>';
    }
    return '';
}

function COMP_formRegistrazione(array $errori = [], array $valori = [], bool $selfReg = true) {
    $val = function($field) use ($valori) {
        return htmlspecialchars($valori[$field] ?? '');
    };

    $selected = function($field, $value) use ($valori) {
        if (isset($valori[$field]))
            return (string)$valori[$field] === (string)$value ? 'selected' : '';
        else 
            return $value == '0' ? 'selected' : '';
    };
    $selectedUser = function($field, $value) {//xxxxxx da sistemare
        if (isset($_SESSION[$field]))
            return (string)$_SESSION[$field] === (string)$value ? 'selected' : '';
        else 
            return $value == 'user' ? 'selected' : '';
    };
    $enableSetUser = function($field) {//permette di disabilitare combo di scelta se utente non loggato (ossia per registrazione)
        if (isset($_SESSION[$field]))
            return  'required';
        else 
            return 'disabled';
    };
    $hasError = !empty($errori);

    $regbtn = '<div class="d-flex justify-content-center mt-4">
                    <div class="px-2">';
    if ($selfReg)
        $regbtn.='<button type="submit" class="btn btn-primary">Registrati</button>';
    else
        $regbtn .= '<button type="submit" class="btn btn-primary">Inserisci utente</button>';
    $regbtn.='</div> </div>';

    $logbtn = '';
    if ($selfReg) {
        $logbtn = '<div class="text-center mt-3">
                    <a href="login.php" class="text-primary text-decoration-none">Hai già un account? Accedi qui</a>
                </div>';
    }


    return '
    <script>
    function ControllaPsw(form){
      psw1=document.getElementById("password");
      pswchk=document.getElementById("confirmPassword");
      if (psw1.value!=pswchk.value){
        alert("le due password indicate non corrispondono");
        psw1.value="";
        pswchk.value="";
        psw1.focus();
        return false;
      }
    else
        return true;
    }
    </script>
    <div class="row min-vh-100 justify-content-center align-items-center bg-primary text-white py-5" m-0>
        <div class="col-12 col-md-8 col-lg-6 bg-white text-dark p-5 rounded shadow">

            ' . ($hasError ? '<div class="alert alert-danger mb-4">Si sono verificati degli errori, correggi i campi evidenziati.</div>' : '') . '

            <form method="POST" enctype="multipart/form-data" name=schedaUtente>

            <!-- Dati Anagrafici -->
                <h5 class="mb-3">Dati anagrafici</h5>
                <hr class="mb-4">

                <div class="mb-3">
                    <label class="form-label">*Cognome</label>
                    <input type="text" name="cognome" class="form-control border-primary" maxlength="30" required value="' . $val('cognome') . '">
                    ' . mostraErrore('cognome', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">*Nome</label>
                    <input type="text" name="nome" class="form-control border-primary" maxlength="30" required value="' . $val('nome') . '">
                    ' . mostraErrore('nome', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">*Codice Fiscale</label>
                    <input type="text" name="codiceFiscale" class="form-control border-primary" maxlength="16" required value="' . $val('codiceFiscale') . '">
                    ' . mostraErrore('codiceFiscale', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">*Data di nascita</label>
                    <input type="date" name="dataNascita" class="form-control border-primary" required value="' . $val('dataNascita') . '">
                    ' . mostraErrore('dataNascita', $errori) . '
                </div>
                <div class=mb-3>
                    <label class="form-label">Immagine</label>
                    <input type="file" name="fileUp[]" class="form-control border-primary" value="' . $val('immagine') . '">
                </div>
        <!-- Indirizzo -->
                <h5 class="mt-4 mb-3">*Indirizzo</h5>
                <hr class="mb-4">

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">*Via</label>
                        <input type="text" name="via" class="form-control border-primary" maxlength="20" required value="' . $val('via') . '">
                        ' . mostraErrore('via', $errori) . '
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">*Numero civico</label>
                        <input type="text" name="numero" class="form-control border-primary" maxlength="4" required value="' . $val('numero') . '">
                        ' . mostraErrore('numero', $errori) . '
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">*CAP</label>
                        <input type="text" name="cap" class="form-control border-primary" maxlength="5" required value="' . $val('cap') . '">
                        ' . mostraErrore('cap', $errori) . '
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">*Città</label>
                        <input type="text" name="citta" class="form-control border-primary" maxlength="20" required value="' . $val('citta') . '">
                        ' . mostraErrore('citta', $errori) . '
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">*Provincia</label>
                        <input type="text" name="provincia" class="form-control border-primary" maxlength="2" required value="' . $val('provincia') . '">
                        ' . mostraErrore('provincia', $errori) . '
                    </div>
                </div>

        <!--Contatti -->
                <h5 class="mt-4 mb-3">Contatti</h5>
                <hr class="mb-4">
                <div class="mb-3">
                    <label class="form-label">*Telefono</label>
                    <input type="tel" name="telefono" class="form-control border-primary" maxlength="10" pattern="^\d{10}$" placeholder="1234567890" required value="' . $val('telefono') . '">
                    ' . mostraErrore('telefono', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">*Email</label>
                    <input type="email" name="email" class="form-control border-primary" maxlength="50" required value="' . $val('email') . '">
                    ' . mostraErrore('email', $errori) . '
                </div>
        
        <!-- Credenziali -->
                <h5 class="mt-4 mb-3">Credenziali di accesso</h5>
                <hr class="mb-4">

                <div class="mb-3">
                    <label class="form-label">*Username</label>
                    <input type="text" name="username" class="form-control border-primary" maxlength="30" required value="' . $val('username') . '">
                    ' . mostraErrore('username', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">*Password</label>
                    <input type="password" name="password" id="password" class="form-control border-primary" maxlength="20" required>
                    ' . mostraErrore('password', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">*Ripeti Password</label>
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control border-primary" maxlength="20" required onblur=ControllaPsw(form.schedaUtente);>
                    ' . mostraErrore('password', $errori) . '
                </div>
                
        <!-- Tipo di attività e funzioni varie-->
                <h5 class="mt-4 mb-3">Tipo di attività e funzioni varie</h5>
                <hr class="mb-4">
                <!--<div class="mb-4 text-center">
                    <div class="row justify-content-center g-3">
                        <div class="col-md-5">-->
                <div class="mb-3">        
                            <label class="form-label">Disponibilità per attività di 118 </label>
                            <select class="form-select rounded p-1 border-2 border-primary bg-light text-dark shadow-sm" name="indisponibilita" required>
                                <option value="0" ' . $selected('indisponibilita', '0') . '>Disponibile</option>
                                <option value="1" ' . $selected('indisponibilita', '1') . '>Non disponibile</option>
                            </select>
                </div>
                <div class="mb-3">
                            <label class="form-label">Istruttore (si/no)</label>
                            <select class="form-select rounded p-1 border-2 border-primary bg-light text-dark shadow-sm" name="istruttore" required>
                                <option value="0" ' . $selected('istruttore', '0') . '>No</option>
                                <option value="1" ' . $selected('istruttore', '1') . '>Si</option>
                            </select>
                </div>
                 <div class="mb-3">
                            <label class="form-label">Tipo utente </label>
                            <select class="form-select rounded p-1 border-2 border-primary bg-light text-dark shadow-sm" name="tipoUtente"'.$enableSetUser('tipoUtente').'>
                                <option value="user" ' . $selectedUser('tipoUtente', 'user') . '>User</option>
                                <option value="admin" ' . $selectedUser('tipoUtente', 'admin') . '>Admin</option>
                            </select>
                </div>
                <!--    </div>
                </div>-->

                <!-- Documento -->
                <h5 class="mt-4 mb-3">Documento </h5>
                <hr class="mb-4">

                <div class="mb-4">
                    <label class="form-label" for="fronte">*Foto del fronte del documento</label>
                    <div class="input-group">
                        <input type="file" id="fronte" name="fronte" class="d-none" required onchange="document.getElementById(\'fronte-label\').innerText = this.files[0].name">
                        <label for="fronte" class="btn btn-outline-primary rounded-3 border-2">Scegli file</label>
                        <span id="fronte-label" class="ms-3">Nessun file selezionato</span>
                    </div>
                    ' . mostraErrore('fronte', $errori) . '
                </div>

                <div class="mb-4">
                    <label class="form-label" for="retro">*Foto del retro del documento</label>
                    <div class="input-group">
                        <input type="file" id="retro" name="retro" class="d-none" required onchange="document.getElementById(\'retro-label\').innerText = this.files[0].name">
                        <label for="retro" class="btn btn-outline-primary rounded-3 border-2">Scegli file</label>
                        <span id="retro-label" class="ms-3">Nessun file selezionato</span>
                    </div>
                    ' . mostraErrore('retro', $errori) . '
                </div>

                <div class="mb-4">
                    <label class="form-label">*Data di emissione</label>
                    <input type="date" name="dataEmissione" class="form-control rounded-3 border-2 border-primary" required value="' . $val('dataEmissione') . '" >
                    ' . mostraErrore('dataEmissione', $errori) . '
                </div>

                <div class="mb-4">
                    <label class="form-label">*Data di scadenza</label>
                    <input type="date" name="dataScadenza" class="form-control rounded-3 border-2 border-primary" required value="' . $val('dataScadenza') . '">
                    ' . mostraErrore('dataScadenza', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">*Descrizione</label>
                    <input type="text" name="descrizione" class="form-control border-primary" required value="' . $val('descrizione') . '">
                    ' . mostraErrore('descrizione', $errori) . '
                </div>

                
                ' . $regbtn . '
            </form>

            ' . $logbtn . '
        </div>
    </div>';
}
?>
