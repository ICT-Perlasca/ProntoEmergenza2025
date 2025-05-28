<?php
    function API_segnareComunicazioneLetta($get, $post, $session){
        if(!isset($session['idUtente']) || !$post['idComunicazione']){
            header("HTTP/1.1 403 Forbidden");
            return [];
        }
        $strsql1 = "SELECT * FROM utentiComunicazioni 
        WHERE idComunicazione=? AND dataLettura IS null AND idComunicazione=?";
        //$com = funzione($strsql1,[$post['idComunicazione'],$post['idUtente']], [PDO::PARAM_INT,PDO::PARAM_INT]);
                if(count($com) == 1){
            $strsql2 = "UPDATE utentiComunicazioni  
            SET dataLettura = CURDATE()  
            WHERE idComunicazione = ?";
            //$com = funzione ($strsql2, [$post['idComunicazione']], [PDO::PARAM_INT]);
        }        
        return $com;
    }
?>