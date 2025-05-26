# Pagina di Registrazione

La pagina di registrazione presenta al suo interno un **modulo form** diviso in 3 sezioni:

1. **Dati anagrafici**
2. **Ruolo e disponibilità**
3. **Credenziali**

Il form prevede la possibilità di allegare una foto **fronte e retro** di un documento di autenticazione/qualifica nei seguenti formati: `.jpg`, `.jpeg`, `.png`, `.pdf`.

---

## Funzionamento del modulo

Il modulo è implementato come **una funzione** che prende in input:

- due array:
  - `$errori`
  - `$_POST`

e restituisce il form correttamente formattato.

---

## Comportamento del form

- Una volta compilato e inviato:
  - **Se non ci sono errori**, viene restituito un messaggio di conferma.
  - **Se ci sono errori**, il form viene ricaricato mostrando i messaggi di errore **sotto ogni campo input errato**.
- Grazie all'array `$_POST`, il form **mantiene i dati inseriti** nei campi anche dopo l'invio.

---

## Gestione degli errori

L'array `$errori` viene popolato in seguito alla chiamata di **entrambe le API**:

- API di inserimento utente
- API di inserimento documento

---

## Limitazioni attuali

- L'**API di inserimento utente** **non** implementa l'invio di una **email ad un admin** per la verifica e approvazione della registrazione.
- Il form **non permette** l'inserimento di **più di un documento**.
