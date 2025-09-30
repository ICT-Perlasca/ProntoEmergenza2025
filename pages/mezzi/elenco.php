<?php
    require_once("./funzioniDB.php");

    session_start();

    if(!isset($_SESSION['idUtente']) || $_SESSION['tipoUtente'] != 'admin'){
        header("Location: ../login");
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
    require_once ("./components/Cards/cardVeicolo.php");
    require_once ("./components/Footer/footer.php");
    require_once ("./api/API_elencoMezziDisponibili.php");
    require_once ("./components/SimpleComponent/searchBar.php");

echo COMP_header($_SESSION);
echo CMP_SearchBar("mezzi");

echo '<div class="container my-4">';
echo '<div class="row g-4">';
foreach(API_elencoMezziDisponibili([],[], $_SESSION) as $m) {
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