<?php
require_once('./api/API_getUtente.php');
require_once('./components/SimpleComponent/COMP_Buttons.php');
require_once('./components/SimpleComponent/COMP_selectRuolo.php');
require_once('./components/SimpleComponent/COMP_passwordField.php');

function mostraErrore($campo, $errori) {
    if (is_array($errori) && isset($errori[$campo])) {
        return '<span class="text-danger d-block mt-1">' . htmlspecialchars($errori[$campo]) . '</span>';
    }
    return '';
}
function COMP_modificaUtente($idUtente,$errori,$post){
    //class = 'table-striped table-warning'
    //se mi passano POS è perchè visualizzo di nuovo dati modificati cn errori
    //altrimenti devo prelevare i dati dal DB per la prima visualizzazione
    if (isset($_POST['via']))
        $dati=$post;
    else{
        $utente = API_getUtenteById([], ["idUtente" => $idUtente], $_SESSION);
        //print_r($utente);
        $dati=$utente[0];
    }
    $hasError = !empty($errori);

    $msg = '
   <!--  <div class="row min-vh-100 justify-content-center align-items-center bg-primary text-white py-5" m-0>
        <div class="col-12 col-md-8 col-lg-6 bg-white text-dark p-5 rounded shadow">

            ' . ($hasError ? '<div class="alert alert-danger mb-4">Si sono verificati degli errori, correggi i campi evidenziati:<br>'.print_r($errori).'</div>' : '') . '
-->
            <form method="POST" enctype="multipart/form-data" name=schedaUtente>

            <!-- Dati Anagrafici -->
                <h5 class="mb-3">Dati anagrafici</h5>
                <hr class="mb-4">

                <div class="mb-3">
                    <label class="form-label">Cognome</label>
                    <input type="text" name="cognome" class="form-control" maxlength="30" readonly value="' . $dati['cognome'] . '">
                    ' . mostraErrore('cognome', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" maxlength="30" readonly value="' . $dati['nome'] . '">
                    ' . mostraErrore('nome', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Codice Fiscale</label>
                    <input type="text" name="codiceFiscale" class="form-control" maxlength="16" readonly value="' . $dati['codiceFiscale'] . '">
                    ' . mostraErrore('codiceFiscale', $errori) . '
                </div>

                <div class="mb-3">
                    <label class="form-label">Data di nascita</label>
                    <input type="date" name="dataNascita" class="form-control" readonly value="' . $dati['dataNascita'] . '">
                    ' . mostraErrore('dataNascita', $errori) . '
                </div>
                <div class=mb-3>
                    <label class="form-label">Nuova immagine profilo</label>
                    <input type="file" name="imageUp" class="form-control">
                    ' . mostraErrore('imageUp', $errori) . '
                </div>
        <!-- Indirizzo -->
                <h5 class="mt-4 mb-3">Indirizzo</h5>
                <hr class="mb-4">

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Via</label>
                        <input type="text" name="via" class="form-control " maxlength="20" value="' . $dati['via'] . '">
                        ' . mostraErrore('via', $errori) . '
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Numero civico</label>
                        <input type="text" name="numero" class="form-control" maxlength="4" value="' . $dati['numero'] . '">
                        ' . mostraErrore('numero', $errori) . '
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">CAP</label>
                        <input type="text" name="cap" class="form-control " maxlength="5" value="' . $dati['cap'] . '">
                        ' . mostraErrore('cap', $errori) . '
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Città</label>
                        <input type="text" name="citta" class="form-control" maxlength="20" value="' . $dati['citta'] . '">
                        ' . mostraErrore('citta', $errori) . '
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Provincia</label>
                        <input type="text" name="provincia" class="form-control" maxlength="2" value="' . $dati['provincia'] . '">
                        ' . mostraErrore('provincia', $errori) . '
                    </div>
                </div>

        <!--Contatti -->
                <h5 class="mt-4 mb-3">Contatti</h5>
                <hr class="mb-4">
                <div class="mb-3">
                    <label class="form-label">Telefono</label>
                    <input type="tel" name="telefono" class="form-control" maxlength="10" pattern="^\d{10}$" placeholder="1234567890" value="' . $dati['telefono'] . '">
                    ' . mostraErrore('telefono', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" maxlength="50" value="' . $dati['email'] . '">
                    ' . mostraErrore('email', $errori) . '
                </div>
        
        <!-- Credenziali -->
                <h5 class="mt-4 mb-3">Credenziali di accesso</h5>
                <hr class="mb-4">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control " maxlength="30" readonly value="' . $dati['username' ]. '">
                    ' . mostraErrore('username', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label><!-- la password vecchia NON può essere visualizzata!!!-->
                   <!-- <input type="password" name="password" id="password" class="form-control " maxlength="20">-->

                    ' . COMP_passwordField('password','password').mostraErrore('password', $errori) . '
                </div>
                <div class="mb-3">
                    <label class="form-label">Ripeti Password</label>
                    <!--<input type="password" name="confirmPassword" id="confirmPassword" class="form-control" maxlength="20" onblur=ControllaPsw(form.schedaUtente);>-->
                    ' . COMP_passwordCheckField('password','confirmPassword','confirmPassword'). mostraErrore('password', $errori) . '
                </div>
                
        <!-- Tipo di attività - ruolo e funzioni varie-->
                <h5 class="mt-4 mb-3">Tipo di attività e funzioni varie</h5>
                <hr class="mb-4">
                <!--<div class="mb-4 text-center">
                    <div class="row justify-content-center g-3">
                        <div class="col-md-5">-->
                 <div class="mb-3">
                            <label class="form-label">Tipo utente </label>
                            <select class="form-select rounded p-1 border-2" name="tipoUtente" '.(($_SESSION['tipoUtente']=='user')?"disabled":"").' > <!-- opppure readonly?????-->
                                <option value="user" ' . (($dati['tipoUtente']== 'user')?"selected":"") . '>User</option>
                                <option value="admin" ' . (($dati['tipoUtente']== 'admin')?"selected":""). '>Admin</option>
                            </select>
                </div>
                <div class="mb-3">        
                     <label class="form-label">Disponibilità per attività di 118 </label>
                            <select class="form-select rounded p-1 border-2 " name="indisponibilita">
                                <option value="0" ' . (($dati['indisponibilita']== 0)?"selected":""). '>Disponibile</option>
                                <option value="1" ' . (($dati['indisponibilita']== 1)?"selected":"") . '>Non disponibile</option>
                            </select>
                </div>
                <div class="mb-3">
                            <label class="form-label">Status </label>
                            <select class="form-select rounded p-1 border-2" id="status" name="status" '.(($_SESSION['tipoUtente']=='user')?"disabled":"").' > <!-- opppure readonly????-->
                                <option value="volontario">volontario</option>
                                <option value="dipendente">dipendente</option>
                                <option value="corsista">corsista</option>
                            </select>
                </div>
                 <div class="mb-3">
                            <label class="form-label">Ruoli attuali: </label><br>
                            <input type="text" name="ruoli" class="form-control " maxlength="30" readonly value="' . $dati['ruoli' ]. '">
                            <label class="form-label">Aggiunta ruolo: </label>
                            '.COMP_selectRuolo('idRuolo').'
                </div>
                <div class="mb-3">
                            <label class="form-label">Istruttore (si/no)</label>
                            <select class="form-select rounded p-1 border-2" id="istruttore" name="istruttore" onchange="controllaIstruttore();" required>
                                <option value="0" '.(($dati['istruttore']== 0)?"selected":""). '>No</option>
                                <option value="1" '.(($dati['istruttore']== 1)?"selected":""). '>Si</option>
                            </select>.
                </div>   
    <!--    </div></div>-->';
    return $msg;
}

?>