<?php
function COMP_formRegistrazione($title) {
    return '
      <form method="POST" enctype="multipart/form-data">
        <label>Cognome: <input type="text" name="cognome" maxlength="30" required></label>
        <br>
        <label>Nome: <input type="text" name="nome" maxlength="30" required></label>
        <br>
        <label>Codice Fiscale: <input type="text" name="codiceFiscale" maxlength="16" required></label>
        <br>
        <label>Data di nascita: <input type="date" name="dataNascita" required></label>
        <br>

        <label>Via: <input type="text" name="via" maxlength="20" required></label>
        <br>
        <label>Numero civico: <input type="text" name="numero" maxlength="4" required></label>
        <br>
        <label>CAP: <input type="text" name="cap" maxlength="5" required></label>
        <br>
        <label>Città: <input type="text" name="citta" maxlength="20" required></label>
        <br>
        <label>Provincia: <input type="text" name="provincia" maxlength="2" required></label>
        <br>

        <label>Username: <input type="text" name="username" maxlength="30" required></label>
        <br>
        <label>Password: <input type="password" name="password" maxlength="30" required></label>
        <br>
        <label>Email: <input type="email" name="email" maxlength="30" required></label>
        <br>
        <label>Telefono: <input type="text" name="telefono" maxlength="13" required></label>
        <br>

        <label>disponibilità:
          <select name="indisponibilita" required>
            <option value="0">Disponibile</option>
            <option value="1">Non disponibile</option>
          </select>
        </label>
        <br>

        <label>Istruttore:
          <select name="istruttore" required>
            <option value="0">No</option>
            <option value="1">Sì</option>
          </select>
        </label>
        <br>

        <label for="descrizione">Identificativo del certificato:</label>
        <input type="text" id="descrizione" name="descrizione" required>
        <br>

        <label for="fronte">Foto del fronte del documento:</label>
        <input type="file" id="fronte" name="fronte" required>
        <br>

        <label for="retro">Foto del retro del documento:</label>
        <input type="file" id="retro" name="retro">
        <br>

        <label for="dataEmissione">Data di emissione del documento:</label>
        <input type="date" id="dataEmissione" name="dataEmissione" required><br>

        <label for="dataScadenza">Data di scadenza del documento:</label>
        <input type="date" id="dataScadenza" name="dataScadenza" required>
        <br>

        <input type="submit" value="invia" name="invia">
    </form>
    ';
}
?>
