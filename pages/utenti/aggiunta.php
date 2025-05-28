<?php
session_start();

require_once "./components/Footer/footer.php";
require_once "./components/Header/header.php";
require_once "./components/Head/head.php";
require_once "./api/apiRegistrazione/inserimentoUtente.php";
require_once "./components/formRegistrazione/formRegistrazione.php";

if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{
    echo COMP_head();
    echo COMP_header($_SESSION);

    $errori = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errori = API_inserimentoUtente([], $_POST, []);

    if (empty($errori)) {
        echo '<div class="alert alert-success mb-4" style="font-weight: bold; font-size: 1.1rem;">Utente registrato con successo.</div>';
    }
?>
<?php
} 
?>

<body>

<?php 
    echo COMP_formRegistrazione($errori, $_POST);
    echo COMP_Footer();
?>

</body>

</html>

<?php
}
?>