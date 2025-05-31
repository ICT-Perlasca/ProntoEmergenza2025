<?php
require_once("funzioniDB.php");

    function API_segnareComunicazioneLetta($get, $post, $session){
        if(!isset($session['idUtente']) || !$post['idComunicazione']){
            header("HTTP/1.1 403 Forbidden");
            return [];
        }
        $sql = "SELECT * 
        FROM utentiComunicazioni 
        WHERE idComunicazione=? AND 
            dataLettura IS NULL AND 
            idUtente=?";


        $com = db_query($sql,
            [$post['idComunicazione'], $session['idUtente']], 
            [PDO::PARAM_INT,PDO::PARAM_INT]
        );

        if(count($com) == 1){
            $sql = "UPDATE utentiComunicazioni  
                SET dataLettura = CURDATE()  
                WHERE idComunicazione=? AND 
                    dataLettura IS NULL AND 
                    idUtente=?";
            $com = db_query($sql,
                [$post['idComunicazione'], $session['idUtente']], 
                [PDO::PARAM_INT,PDO::PARAM_INT]
            );
            return true;
        }        
        return false;
    }
?>