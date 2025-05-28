## README

---

# 1. Dati memorizzati in sessione

Dopo l'autenticazione, vengono memorizzati i seguenti dati all'interno della sessione:

- `$_SESSION['idUtente']` → ID univoco dell’utente
- `$_SESSION['username']` → Nome utente per login
- `$_SESSION['nome']` → Nome personale
- `$_SESSION['cognome']` → Cognome personale
- `$_SESSION['dataNascita']` → Data di nascita dell’utente
- `$_SESSION['email']` → Email dell’utente
- `$_SESSION['telefono']` → Numero di telefono
- `$_SESSION['istruttore']` → Flag per identificare l’istruttore
- `$_SESSION['status']` → Stato dell’account
- `$_SESSION['tipoUtente']` → Tipo (es. ADMIN, USER)
- `$_SESSION['immagine']` → Nome del file immagine profilo


---

# 3. Organizzazione della struttura di caricamento file

Tutti i file caricati dagli utenti vengono salvati nella cartella principale `/uploads`, che contiene tre sottocartelle:

## 3.1 `/uploads/documents`
- **Formato dei file**: `yyyymmddHHiiss_f_md5.pdf`
  - `yyyymmddHHiiss` → data e ora del caricamento
  - `_f_` o `_r_` → indica se il file è *fronte* o *retro*
  - `md5` → hash MD5 del nome originale del file

## 3.2 `/uploads/images`
- **Note**: I file sono legati al campo `immagine` presente nella sessione.

## 3.3 `/uploads/comunications`
- **Contenuto**: allegati delle comunicazioni.
- **Formato dei file**: `yyyymmddHHiiss.pdf`
  - Nessuna parte hash o descrittiva
  - Solo data e ora per garantire unicità




