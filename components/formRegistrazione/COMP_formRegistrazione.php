<?php
require_once "./components/SimpleComponent/COMP_selectRuolo.php";
require_once "./components/SimpleComponent/COMP_selectTipiDocumenti.php";
require_once "./components/SimpleComponent/COMP_passwordField.php";

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
    $selectedUser = function($field, $value) { //seleiozna opzione user e blocca la scelta dell'opzione admin se si è in Registrazione
        if (isset($_SESSION[$field]))
            return (string)$_SESSION[$field] === (string)$value ? 'selected' : '';
        else // la sessione non è settata quindi sono in Registrazione
            return $value == 'user' ? 'selected' : 'disabled';
    };
    /*$enableSetUser = function($field) {//permette di disabilitare combo di scelta se utente non loggato (ossia per registrazione)
        if (isset($_SESSION[$field]))
            return  'required';
        else 
            return 'disabled';
    };*/
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
    function cambiaRuolo(){
    //alert("sono in cambiaRuolo");
        statusValue=document.getElementById("status").value;
        ruoloObj=document.getElementById("idRuolo");
        if(statusValue=="corsista"){
            ruoloObj.value="2";//valore di "corsista" su DB. Si dovrebbe fare ricerca tramite API sul server
            ruoloObj.disabled=true;
        }
        else{
            ruoloObj.value="1";//valore della prima scelta ("autista")
            ruoloObj.disabled=false;
        }
    }
    function controllaIstruttore(){
        ruoloObj==document.getElementById("idRuolo");
        istruttoreObj=document.getElementById("istruttore");
        if (istruttoreObj.value=="0" && ruoloObj.value=="3"){
            alert("ruolo non compatibile !!!!");
            istruttoreObj.value="1";
        }
    }
    </script>
    <div class="row min-vh-100 justify-content-center align-items-center bg-primary text-white py-5" m-0>
        <div class="col-12 col-md-8 col-lg-6 bg-white text-dark p-5 rounded shadow">

            ' . ($hasError ? '<div class="alert alert-danger mb-4">Si sono verificati degli errori, correggi i campi evidenziati:<br>'.print_r($errori).'</div>' : '') . '

            <form method="POST" enctype="multipart/form-data" name=schedaUtente>

            <!-- Dati Anagrafici -->
                <h5 class="mb-3">Dati anagrafici</h5>
                <hr class="mb-4">

                <div class="mb-3">
                    <label class="form-label">*Cognome</label>
                    <input type="text" name="cognome" class="form-control" maxlength="30" required value="' . $val('cognome') . '">
                    ' . mostraErrore('cognome', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">*Nome</label>
                    <input type="text" name="nome" class="form-control" maxlength="30" required value="' . $val('nome') . '">
                    ' . mostraErrore('nome', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">*Codice Fiscale</label>
                    <input type="text" name="codiceFiscale" class="form-control" maxlength="16" required value="' . $val('codiceFiscale') . '">
                    ' . mostraErrore('codiceFiscale', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">*Data di nascita</label>
                    <input type="date" name="dataNascita" class="form-control" required value="' . $val('dataNascita') . '">
                    ' . mostraErrore('dataNascita', $errori) . '
                </div>
                <div class=mb-3>
                    <label class="form-label">Immagine profilo</label>
                    <input type="file" name="imageUp" class="form-control" value="' . $val('immagine') . '">
                </div>
        <!-- Indirizzo -->
                <h5 class="mt-4 mb-3">*Indirizzo</h5>
                <hr class="mb-4">

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">*Via</label>
                        <input type="text" name="via" class="form-control " maxlength="20" required value="' . $val('via') . '">
                        ' . mostraErrore('via', $errori) . '
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">*Numero civico</label>
                        <input type="text" name="numero" class="form-control" maxlength="4" required value="' . $val('numero') . '">
                        ' . mostraErrore('numero', $errori) . '
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">*CAP</label>
                        <input type="text" name="cap" class="form-control " maxlength="5" required value="' . $val('cap') . '">
                        ' . mostraErrore('cap', $errori) . '
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">*Città</label>
                        <input type="text" name="citta" class="form-control" maxlength="20" required value="' . $val('citta') . '">
                        ' . mostraErrore('citta', $errori) . '
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">*Provincia</label>
                        <input type="text" name="provincia" class="form-control" maxlength="2" required value="' . $val('provincia') . '">
                        ' . mostraErrore('provincia', $errori) . '
                    </div>
                </div>

        <!--Contatti -->
                <h5 class="mt-4 mb-3">Contatti</h5>
                <hr class="mb-4">
                <div class="mb-3">
                    <label class="form-label">*Telefono</label>
                    <input type="tel" name="telefono" class="form-control" maxlength="10" pattern="^\d{10}$" placeholder="1234567890" required value="' . $val('telefono') . '">
                    ' . mostraErrore('telefono', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">*Email</label>
                    <input type="email" name="email" class="form-control" maxlength="50" required value="' . $val('email') . '">
                    ' . mostraErrore('email', $errori) . '
                </div>
        
        <!-- Credenziali -->
                <h5 class="mt-4 mb-3">Credenziali di accesso</h5>
                <hr class="mb-4">

                <div class="mb-3">
                    <label class="form-label">*Username</label>
                    <input type="text" name="username" class="form-control " maxlength="30" required value="' . $val('username') . '">
                    ' . mostraErrore('username', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">*Password</label>
                    <!--<input type="password" name="password" id="password" class="form-control " maxlength="20" required>-->
                    ' . COMP_passwordField('password','password'). mostraErrore('password', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">*Ripeti Password</label>
                    <!--<input type="password" name="confirmPassword" id="confirmPassword" class="form-control" maxlength="20" required onblur=ControllaPsw(form.schedaUtente);>-->
                    ' . COMP_passwordCheckField('password','confirmPassword','confirmPassword'). mostraErrore('password', $errori) . '
                </div>
                
        <!-- Tipo di attività - ruolo e funzioni varie-->
                <h5 class="mt-4 mb-3">Tipo di attività e funzioni varie</h5>
                <hr class="mb-4">
                <!--<div class="mb-4 text-center">
                    <div class="row justify-content-center g-3">
                        <div class="col-md-5">-->
                 <div class="mb-3">
                            <label class="form-label">*Tipo utente </label>
                            <select class="form-select rounded p-1 border-2" name="tipoUtente" >
                                <option value="user" ' . $selectedUser('tipoUtente', 'user') . '>User</option>
                                <option value="admin" ' . $selectedUser('tipoUtente', 'admin') . '>Admin</option>
                            </select>
                </div>
                <div class="mb-3">        
                            <label class="form-label">*Disponibilità per attività di 118 </label>
                            <select class="form-select rounded p-1 border-2 " name="indisponibilita" required>
                                <option value="0" ' . $selected('indisponibilita', '0') . '>Disponibile</option>
                                <option value="1" ' . $selected('indisponibilita', '1') . '>Non disponibile</option>
                            </select>
                </div>
                 <div class="mb-3">
                            <label class="form-label">*Status </label>
                            <select class="form-select rounded p-1 border-2" id="status" name="status" onchange="cambiaRuolo();" required>
                                <option value="volontario">volontario</option>
                                <option value="dipendente">dipendente</option>
                                <option value="corsista">corsista</option>
                            </select>
                </div>
                 <div class="mb-3">
                            <label class="form-label">*Ruolo </label>
                            '.COMP_selectRuolo('idRuolo').'
                </div>
                <div class="mb-3">
                            <label class="form-label">*Istruttore (si/no)</label>
                            <select class="form-select rounded p-1 border-2" id="istruttore" name="istruttore" onchange="controllaIstruttore();" required>
                                <option value="0" ' . $selected('istruttore', '0') . '>No</option>
                                <option value="1" ' . $selected('istruttore', '1') . '>Si</option>
                            </select>
                </div>
                
                <!--    </div>
                </div>-->

        <!-- Documento -->
                <h5 class="mt-4 mb-3">Documento </h5>
                <hr class="mb-4">
                <div class="mb-3">
                            <label class="form-label">*Tipo documento </label>
                            '.COMP_selectTipiDocumenti('idTipoDocumento').'
                </div>
                 <div class="mb-3">
                    <label class="form-label">*Numero documento</label>
                    <input type="text" name="numerodocumento" class="form-control" value="' . $val('numerodocumento') . '">
                    ' . mostraErrore('numerodocumento', $errori) . '
                </div>                
               <div class="mb-4">
                    <label class="form-label" for="fronte">Foto del fronte del documento</label>
                     <input type="file" name="fronte" id="fronte" class="form-control">
                    ' . mostraErrore('fronte', $errori) . '
                </div>

                <div class="mb-4">
                    <label class="form-label" for="retro">Foto del retro del documento</label>
                     <input type="file" name="retro" id "retro" class="form-control">
                    ' . mostraErrore('retro', $errori) . '
                </div>

                <div class="mb-4">
                    <label class="form-label">*Data di emissione</label>
                    <input type="date" name="dataEmissione" class="form-control rounded-3 border-2" required value="' . $val('dataEmissione') . '" >
                    ' . mostraErrore('dataEmissione', $errori) . '
                </div>

                <div class="mb-4">
                    <label class="form-label">*Data di scadenza</label>
                    <input type="date" name="dataScadenza" class="form-control rounded-3 border-2" required value="' . $val('dataScadenza') . '">
                    ' . mostraErrore('dataScadenza', $errori) . '
                </div>

                ' . $regbtn . '
            </form>

            ' . $logbtn . '
        </div>
    </div>';
}
?>
