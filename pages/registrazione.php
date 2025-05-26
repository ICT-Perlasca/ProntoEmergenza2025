<!DOCTYPE html>
<html>
    <head>
        <base href="./" />
        <link href="./public/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    </head>

<?php
session_start();

require_once "api/apiRegistrazione/inserimentoUtente.php";
require_once "components/formRegistrazione/formRegistrazione.php";

$errori = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errori = API_inserimentoUtente([], $_POST, []);

?>
Successo, attendere che un amministratore convaliti la tua registrazione
<?php
}else{
?>

<body>

<div class="bg-white text-primary my-4 d-flex flex-row justify-content-center align-items-center">
    <a href="./"  class="col-2">
        <img src="./public/images/logo-ambulanza.png" class="w-100"/>   
    </a>
    <span class="col-8 text-center">
        <h1>Registrazione</h1>
    </span>
    <div class="col-2"></div>
</div>

<h1 class="text-center text-primary my-4">
</h1>
<?php echo COMP_formRegistrazione($errori, $_POST); ?>

<?php 
    require_once ("./components/Footer/footer.php");
    echo COMP_Footer(); 
?>

</body>
<?php
}
?>
</html>