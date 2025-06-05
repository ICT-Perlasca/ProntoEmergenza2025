<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="generator" content="AlterVista - Editor HTML"/>
  <title></title>
</head>
<body>

 <?php
 require_once("../api/email_handler.php");
 

//invio email per conferma cambio password
 //  $cambioPsw['titolo']=str_replace("{nomeUtente}", "Claudia", $cambioPsw['titolo']);
 // if (inviaEmail($cambioPsw["titolo"], $cambioPsw["testo"], "prati.cld@gmail.com",$cambioPsw["oggetto"],"profprati@altervista.org")) {
    
    //invio email per validazione email in caso di nuovo utente
  $validazioneEmail['titolo']=str_replace("{nomeUtente}", "Claudia", $validazioneEmail['titolo']);
  $validazioneEmail['testo']=str_replace("{link}", "<a href='https://localhost/prontoemergenza2025/api/valida'>https://localhost/prontoemergenza2025/api/valida</a>", $validazioneEmail['testo']);
 if (inviaEmail($validazioneEmail["titolo"], $validazioneEmail["testo"], "prati.cld@gmail.com",$validazioneEmail["oggetto"],"profprati@altervista.org")) {
        echo "Email inviata con successo!";
    } else {
        echo "Errore nell'invio dell'email.";
    }
   print_r($validazioneEmail);
?>

</body>
</html>
