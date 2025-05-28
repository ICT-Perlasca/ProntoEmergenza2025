# Pagina di validazione della registrazione tramite mail

Questa pagina viene richiamata solo da una mail tramite un link.
Alla pagina viene inviato

In $post devono essere presenti i campi:

- idU che deve contenere l'id 

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