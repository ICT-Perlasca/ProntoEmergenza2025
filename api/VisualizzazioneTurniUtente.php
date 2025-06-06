<?php
    function API_VisualizzaTurniUtente($get, $post, $session){
        if(isset($post['utente'])){
            require "funzioni.php";
            $strSql = "     ";
            $valori = [];
            $tipi = [];
            $ris = db_query($strSql, $valori, $tipi);
            return $risposta;
        }
        else{
            header('HTTP/1.1 403 Forbidden');
            return [];
        }    
    }
?>