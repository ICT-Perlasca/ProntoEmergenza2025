<?php
    require_once("./funzioniDB.php");

    session_start();

    if(!isset($_SESSION['idUtente']) || $_SESSION['tipoUtente'] != 'admin'){
        header("Location: /ProntoEmergenza2025/login");
    }else{
?>
<html>
<?php
require_once ("./components/Head/head.php");

echo COMP_head("mezzi");

?>
<body>
<?php
    require_once ("./components/Header/header.php");
    require_once ("./components/SimpleComponent/cardVeicolo.php");
    require_once ("./components/SimpleComponent/comp.php");
    require_once ("./components/Footer/footer.php");
    require_once ("./api/ElencoMezziDisponibili.php");

echo COMP_header($_SESSION);

echo '<div class="container my-4">';
echo '<div class="row g-4">';
foreach(API_ElencoMezziDisponibili([],[], $_SESSION) as $m) {
    echo generaCardMezzo($m);
}
echo '</div>';
echo '</div>';

echo COMP_Footer();
?>
</body>
</html>
<?php
    }
?>