## README
## Documentazione

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

# 2. Organizzazione della struttura del progetto

La struttura delle cartelle è organizzata come segue:

## 2.1 `/api`
- Contiene tutte le API disponibili per il sistema.
- Le funzioni sono modulari e vengono richiamate dalle varie pagine.

## 2.2 `/components`
- Include componenti riutilizzabili, divisi in sottocartelle:
  - `Footer/`
  - `Head/`
  - `Header/`
  - `SimpleComponent/`

## 2.3 `/doc`
- Contiene i file di documentazione tecnica e manuali operativi.

## 2.4 `/pages`
- Contiene tutte le pagine dell'applicazione (es. login, dashboard, gestione utenti).

## 2.5 `/public`
- Raccoglie le risorse accessibili pubblicamente:
  - `css/` → fogli di stile
  - `image/` → immagini statiche
  - `js/` → file JavaScript

## 2.6 `/uploads`
  - Cartella principale per il caricamento dei file.
  - Vedi dettaglio nel punto successivo.
