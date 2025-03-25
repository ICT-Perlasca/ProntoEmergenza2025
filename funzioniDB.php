<?php
require_once ""
function api_querySelect($strquery,$valori, $tipi){
    global $DSN,$USERDB,$PSWDB;
    $ris=[];
    try{
        $conn=new PDO($DSN,$USERDB,$PSWDB);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $stm=$conn->prepare($strquery);
        for($i=0;$i<count($valori);$i++){
            $stm->bindParam($i+1,$valori[$i],$tipi[$i]);
        }
        $stm->execute();

        $ris=$stm->fetchAll(PDO::FETCH_NAMED);
        $conn=null;
    }
    catch(Exception $e){
        $ris['error']=$e->getMessage();
    }
    return $ris;
}
?>