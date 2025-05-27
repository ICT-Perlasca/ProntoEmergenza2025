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

- Orientamento: Orizzontale (Landscape)
- Formato: 397mm x 210mm (formato largo A4)
- Font: Courier
- Intestazione: data/ora generazione
- Colonne auto-adattive
- Testi lunghi distribuiti su più righe

  # 7. Sicurezza

- Le query **non sono eseguite** direttamente.
- La funzione API deve restituire **solo dati già validati e sicuri**.
- Nessuna elaborazione SQL interna al sistema.

---

# 8. Pseudocodice Funzioni Principali

```plaintext
// Funzione principale
generaPDFdaAPI(nomeAPI, titolo):
    se la funzione nomeAPI esiste:
        dati = nomeAPI(GET, POST, SESSION)
        se dati non vuoti:
            intestazioni = chiavi della prima riga
            righe = valori delle righe
            formattaDate(righe)
            larghezze = calcolaLarghezze(intestazioni, righe)
            creaPDF(intestazioni, righe, larghezze, titolo)
        altrimenti:
            mostra errore "Nessun dato"
    altrimenti:
        mostra errore "Funzione inesistente"

// Formattazione delle date
formattaDate(righe):
    per ogni riga:
        per ogni valore:
            se è una data ISO (YYYY-MM-DD):
                converti in formato italiano (DD-MM-YYYY)

// Calcolo larghezza colonne
calcolaLarghezze(intestazioni, righe):
    per ogni colonna:
        calcola la larghezza massima tra etichetta e dati
    se larghezza totale > 397mm:
        scala le larghezze

// Creazione PDF
creaPDF(intestazioni, righe, larghezze, titolo):
    inizializza PDF landscape
    aggiungi intestazione con data/ora
    se titolo presente:
        stampa titolo centrato
    stampa intestazioni in grassetto
    stampa righe con MultiCell per testi lunghi
    output PDF al browser
