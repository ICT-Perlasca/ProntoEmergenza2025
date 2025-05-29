# Pagina di validazione della registrazione tramite mail

Questa pagina viene richiamata solo tramite un link arrivato via mail.
Alla pagina viene inviato

In $get devono essere presenti i campi:

- idU che deve contenere l'id con cui viene salvato l'utente nel DB
- data che deve contenere la data e l'ora di quando è stata inviata la mail
- idUHash che deve contenere l'id utente hashato
- dataHash che deve contenere la data e l'ora di invio mail hashata

Viene fatto un controllo sui dati arrivati in $get:
Se md5($idU) è uguale a $idUHashato e md5($data) è uguale a $dataHashata
Allora
  Si fa il controllo sulla validazione
Altrimenti
  Viene mostrato un alert di errore

Nel controllo della validazione:
Se non è settato $dataInvio['error']
Allora
  Se le ore di differenza sono minori di 24
  Allora
    Se la risposta è uguale ad 1
    Allora
      L'email viene validata
    Altrimenti
      Stampo messaggio di errore
  Altrimenti
  Per tutti gli altri casi viene mostrato un messaggio di errore diverso
FINE SE