<?php
function COMP_header() {
    /*
    if (isset($_SESSION['immagine_profilo']))
        $immagineProfilo = $_SESSION['immagine_profilo'];
    else    
        header('location : login.php');
    */    
    return '
        <link rel="stylesheet" href="./public/css/header.css" type="text/css"/>
        <script type="text/javascript" src="./public/js/header.js"></script>
    
        <div>
            HEADER
        </div> 
    ';
}
?>