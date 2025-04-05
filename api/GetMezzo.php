<?php

function API_GetMezzo($get, $post, $session){
    if(!isset($_POST['idMezzo']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT * from mezzi WHERE idMezzo=?;";
        $valori = [$_GET['idMezzo']];
        $tipi = [PDO::PARAM_STR];
        $risposta = ElaboraQuery($sql, $valori, $tipi);
        return $risposta;
    }
}


function ElaboraQuery($strquery, $valori, $tipi) {
    include ("dsn.php"); /*file temp per provare le query, serve per settare la classe PDO*/
    $ris=[]; 
    try{ 
        $conn=new PDO($dsn,$username,$password); 
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
        $stm=$conn->prepare($strquery); 
        for($i=0;$i<count($valori);$i++){ 
            $stm->bindParam($i+1,$valori[$i],$tipi[$i]); 
        } 
        $stm->execute(); 
        $ris = $stm->fetchAll();

        $conn=null; 
    }catch(Exception $e){ 
        $ris['error']=$e->getMessage(); 
    } 
    return $ris; 
}