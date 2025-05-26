# Ripristino Password
## Pagine 
* Page: `pages/ripristino.php` Gestisce i form in base a quello che riceve in get
---
* Component: `components/Ripristino/formEmail.php` Componente form richiesta e-mail che richiede l'indirizzo e-mail e chiama la api `richiestaRipristino.php`
* Component: `components/Ripristino/formPassword.php` Componente form ripristino password che richiede la password e la sua conferma e chiama la api `resetPassword.php`
---
* Api: `api/richiestaRipristino.php` Php con funzioni:
  * `checkEmail($email)` Funzione che controlla se l'email è valida e se presente nel database:
    * Parametri: indirizzo dell'e-mail.
    * Valori di ritorno: Numero di email trovate o messaggio d'errore.
  * `API_richiestaRipristino($get, $post, $session)` Funzione che prepara l'email di richiesta e la invia:
    * Parametri: in $post è presente la chiave "email" e la relativa e-mail.
    * Valori di ritorno: Messaggio si successo o fallimento.
* Api: `api/resetPassword.php`Funzione che controlla se le password sono valide, combaciano e non siano state manomesse dall'utente.
  * Parametri: le due password.
  * Valori di ritorno: Una stringa che può contenere un messaggio di errore o successo
 ---
* Javascrpit: `public/js/ripristino.js` javascript con funzioni:
  * `checkEmail($email)` Funzione che controlla se l'email è valida
  * `checkPassword($psw, $confPsw)` Funzione che la validità delle password
  