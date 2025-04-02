<?php
function API_ElencoMezziDisponibli($get, $post, $session){
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 forbidden");
        return [];
    }else{
        $sql = "SELECT * from mezzi ORDER BY tipoMezzo DESC;";
        $valori = [];
        $tipi = [];
        $risposta = ElaboraQuery($sql, $valori, $tipi);
        return $risposta;
    }
}

function ElaboraQuery($strquery, $valori, $tipi) {
    include ("dsn.php"); 
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


?>