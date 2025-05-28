# Pagina di Creazione del link da mandare via mail per la validazione del profilo utente

La funzione di creazione del link da mandare via mail richiede che vengano passati gli array associativi: $_GET, $_POST, $_SESSION

In $post devono essere presenti i campi:

- idU che deve contenere l'id 
- data che deve contenere la data e l'ora in cui l'utente ha completato la registrazione

Restituisce un link con all'interno: l'id dell'utente, la data e ora del completamento della registrazione, l'id dell'utente hashato, la data e ora hashata dentro a $ris["link"]