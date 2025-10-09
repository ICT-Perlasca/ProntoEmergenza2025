<!DOCTYPE html>
<html>
    <head>
        <base href="./" />
        <link href="./public/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    </head>
<body>
<!-- byprati
 visualizza titolo "registrazione"
se esiste POST
allora
      apiinserimento utente con controll dei dati inseriti in post e restituzione vettore $errori (vettore vuoto se non ci sono errori ed ins effettuato nel db)
fse
se esiste POST ed errori è vettore Vuoto  (la seleizone precedente ha ins i dati nel DB)
allora
     visualizzazione messaggio  di successo (no form)
altrimenti
    visualizza form di registrazione passando vettore errori +POST
fse
-->

<div class="bg-white text-primary my-4 d-flex flex-row justify-content-center align-items-center">
    <a href="./"  class="col-2">
        <img src="./public/images/logo-ambulanza.png" class="w-100"/>   
    </a>
    <span class="col-8 text-center">
        <h1>Registrazione</h1>
    </span>
    <div class="col-2"></div>
</div>

<?php
//byprati: non testo la sessione !!!! session_start();

require_once "./api/apiRegistrazione/API_inserimentoUtente.php";
require_once "./components/formRegistrazione/formRegistrazione.php";

$errori = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errori = API_inserimentoUtente([], $_POST, []);
}
if(isset($_POST['nome']) && empty($errori)){
?>
    <div class="alert alert-success" role="alert">
    Sei stato registrato con successo!! Attendi che un amministratore convalidi la tua registrazione.
    </div>
<?php
}
else{
?>

<h1 class="text-center text-primary my-4">
</h1>
<?php 
    echo COMP_formRegistrazione($errori, $_POST); ?>

<?php
} 
    require_once ("./components/Footer/footer.php");
    echo COMP_Footer(); 
?>

</body>
<?php

?>
</html>