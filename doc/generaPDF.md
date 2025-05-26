## Documentazione - Generatore PDF
## Autori
Tonoli Nicola, Zanolini Giacomo, Sulmina Adelfio

## Oggetto
Creazione di una API PHP che riceve una query SQL già elaborata (tramite funzione API esterna) e genera dinamicamente un file PDF con tabella, utilizzando la libreria FPDF.

---

# 1. Obiettivo
Creare un PDF tabellare a partire dai dati restituiti da una funzione API che esegue una query SQL sicura e già elaborata.

---

# 2. Funzionamento

- Viene richiamata una funzione API specificata come parametro.
- La funzione riceve `$_GET`, `$_POST`, `$_SESSION` e restituisce un array di righe associative.
- Il PDF viene generato in landscape, con intestazione data/ora e un titolo opzionale.
- Le intestazioni vengono derivate dalle chiavi del primo elemento.
- Le righe vengono formattate in celle, con gestione del testo lungo e date in `dd-mm-yyyy`.

---

# 3. Libreria FPDF

- Usata per generare il PDF (`fpdf.php`).
- Funzioni principali: `AddPage`, `SetFont`, `Cell`, `MultiCell`, `Output`.
- Classe personalizzata `PDF` gestisce righe multilinea, adattamento pagina e larghezza colonne.

---

# 4. Requisiti

- Libreria `fpdf` nella cartella `fpdf/`
- Sessioni attive
- Funzione API già esistente e sicura

---

# 5. Struttura dati

- Array PHP multidimensionale: ogni riga è un array associativo con le stesse chiavi.
- Le date nel formato `YYYY-MM-DD` sono convertite in `DD-MM-YYYY`.

---

# 6. Layout PDF

- Orientamento orizzontale (L)
- Carattere Courier
- Intestazione: data/ora e titolo
- Colonne adattive, con supporto a testo lungo su più righe
