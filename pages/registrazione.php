<!DOCTYPE html>
<html>
    <head>
        <base href="./" />
        <base href="./" />
        <link href="./public/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    </head>

<?php
session_start();

require_once "api/apiRegistrazione/inserimentoUtente.php";
require_once "components/formRegistrazione/formRegistrazione.php";

if (isset($_POST["invia"])) {

    $errori = API_inserimentoUtente([], $_POST, []);
    var_dump($errori);

}

?>

<body>

<?php
    echo COMP_formRegistrazione("form");
?>

</body>
</html>