# Documentazione sul funzionamento dell'inserimento di un turno

## File coinvolti

1. **/public/js/calendar.js**
    - Gestisce la visualizzazione del calendario e l'interazione dell'utente con le date.
    - Quando l'utente seleziona una data, può aprire un popup per inserire un nuovo turno.

2. **/public/js/formTurno.js**
    - Contiene la logica per la gestione del form di inserimento turno.
    - Valida i dati inseriti e invia la richiesta AJAX all'API per salvare il turno.

3. **/pages/turni/inserimento.php**
    - Pagina PHP che mostra l'interfaccia per l'inserimento dei turni.
    - Include il calendario e il form per l'inserimento.

4. **/components/SimpleComponent/popupTurno.php**
    - Componente PHP che genera il markup HTML del popup/modal per l'inserimento/modifica di un turno.
    - Viene richiamato da `calendar.js` quando necessario.

5. **/api/salvaTurno.php**
    - Endpoint API che riceve i dati del turno tramite POST.
    - Esegue i controlli di validità e salva il turno nel database.

6. **/api/elencoTurniData.php**
    - Endpoint API che restituisce l'elenco dei turni per una data specifica.
    - Utilizzato per aggiornare la vista del calendario dopo l'inserimento di un turno.

## Flusso di inserimento turno

1. L'utente seleziona una data dal calendario (`calendar.js`).
2. Si apre un popup/modal per l'inserimento del turno (`popupTurno.php`).
3. L'utente compila il form e invia i dati (`formTurno.js`).
4. I dati vengono inviati tramite AJAX a `/api/salvaTurno.php`.
5. Se il salvataggio va a buon fine, viene aggiornata la lista dei turni tramite `/api/elencoTurniData.php`.
6. Il calendario viene aggiornato per riflettere il nuovo turno.