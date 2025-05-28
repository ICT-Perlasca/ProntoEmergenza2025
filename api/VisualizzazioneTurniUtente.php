<?php
    function API_VisualizzaTurniUtente($get, $post, $session){
        if(isset()){
            require "funzioni.php";
            $strSql = "     ";
            $ris = elaboraDati();
            return $risposta;
        }
        else{
            header('HTTP/1.1 403 Forbidden');
            return [];
        }    
    }
?>