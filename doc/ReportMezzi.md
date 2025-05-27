## Documento di Manutenzione - Generatore PDF Mezzi da API
## ReportMezzi.php
---

# 1. Obiettivo

Creare dinamicamente un file PDF contenente l'elenco dei mezzi disponibili, ottenuto da una funzione API che restituisce dati sicuri in formato associativo.

---

# 2. Funzionamento

1. Avvio della sessione.
2. Richiamo della funzione `API_ElencoMezziDisponibili()` con i dati `$_GET`, `$_POST`, `$_SESSION`.
3. Conversione delle date dal formato `YYYY-MM-DD` a `DD-MM-YYYY`.
4. Calcolo dinamico delle larghezze delle colonne in base al contenuto.
5. Generazione del PDF:
   - Aggiunta intestazione con data e titolo.
   - Tabella con intestazioni e righe.
   - Output del file al browser.

---

# 3. Libreria FPDF

- Utilizzata per creare il PDF in modo flessibile.
- Funzioni chiave:
  - `AddPage()`: aggiunge una pagina.
  - `SetFont()`, `Cell()`, `MultiCell()`: per il testo e la tabella.
  - `Output('I', 'nome.pdf')`: invia il PDF al browser.
- Estensione: `PDF` con metodi personalizzati per la gestione di righe multi-linea.

---

# 4. Requisiti

- Libreria FPDF installata in `fpdf/`
- Funzione `API_ElencoMezziDisponibili` disponibile e funzionante
- Ambiente con sessione attiva

---

# 5. Struttura dei dati

- Array associativo: ogni riga rappresenta un mezzo.
- Colonne: ID, Modello, Targa, Date (immatricolazione, revisione, assicurazione, ecc.), Tipo mezzo.
- Le date vengono convertite nel formato italiano `DD-MM-YYYY`.

---

# 7. Layout PDF

- Orientamento: Landscape
- Formato: A3
- Font: Courier 10-16 pt
- Tabelle con larghezza dinamica (max 397mm)
- Colonne più ampie per descrizioni (es. Modello, Tipo)

---

# 8. Pseudocodice Funzioni Principali

```plaintext
// Funzione di conversione data
convertiData(data):
    se data ha formato YYYY-MM-DD:
        ritorna in formato DD-MM-YYYY
    altrimenti ritorna data originale

// Funzione principale di generazione PDF
generaPDFMezzi(dati):
    se vuoto:
        mostra messaggio e interrompi
    per ogni riga:
        estrai solo i valori (array numerico)
        converti le date (indici da 3 a 7)
    calcola larghezze dinamiche per ogni colonna
    scala larghezze se superano larghezza pagina
    inizializza PDF con orientamento orizzontale
    stampa titolo e data/ora
    stampa intestazioni
    per ogni riga:
        stampa usando MultiCell o Cell
    genera output PDF

// Chiamata iniziale
session_start()
dati = API_ElencoMezziDisponibili(GET, POST, SESSION)
generaPDFMezzi(dati)
