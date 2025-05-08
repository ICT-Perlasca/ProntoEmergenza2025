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

echo COMP_head();

?>
        <body>
<?php
    require_once ("./components/Header/header.php");
    require_once ("./components/SimpleComponent/cardVeicolo.php");
    require_once ("./components/SimpleComponent/comp.php");
    require_once ("./components/Footer/footer.php");
    require_once ("./api/ElencoMezziDisponibili.php");
    require_once ("./components/SimpleComponent/searchBar.php");

echo COMP_header($_SESSION);
echo CMP_SearchBar("mezzi");

echo '<div class="container my-4">';
echo '<div class="row g-4">';
foreach(API_ElencoMezziDisponibili([],[], $_SESSION) as $m) {
    echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 p-3">';
    echo generaCardMezzo($m);
    echo '</div>';
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