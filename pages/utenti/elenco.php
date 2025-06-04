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
    require_once ("./components/Cards/cardUtente.php");
    require_once ("./components/SimpleComponent/searchBar.php");
    require_once ("./components/Footer/footer.php");
    require_once ("./api/RitornaUtenti.php");

echo COMP_header($_SESSION);
echo CMP_SearchBar("utenti");

echo '<div class="container my-4">';
echo '<div class="row g-4">';
foreach(API_RitornaUtenti([],[], $_SESSION) as $u) {
    echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 p-3">';
    echo generaCardUtente($u);
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