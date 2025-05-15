<?php
session_start();
if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{
	
    if (isset($_GET['emailUt']) || isset($_SESSION['email'])){
        
?>
<html>
<?php
require_once ("./components/Head/head.php");

echo COMP_head();
?>
    <body>
<?php
require_once ("./components/Header/header.php");
require_once ("./components/SimpleComponent/comp.php");
require_once ("./components/Footer/footer.php");
require_once ("./components/profiloUtenteSingolo/COMP_profiloUtenteSingolo.php");

echo COMP_header($_SESSION);


/*if(isset($_GET['emailUt']))
	echo CMP_profiloUtenteSingolo($_GET['emailUt']);
else*/
	echo CMP_profiloUtenteSingolo($_SESSION['email']);

echo COMP_Footer();
?>
    </body>
</html>
<?php
    }/*else
        header('HTTP/1.1 403 Forbidden');*/
    
}
?>