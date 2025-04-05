<?php

function API_RitornaUtenti($get, $post, $session){
    if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
    $sql = "SELECT * from utenti ORDER BY cognome,nome;";
    $valori = [];
    $tipi = [];
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

?>
