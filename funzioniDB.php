<?php
require_once "globals.php";
function api_query($strquery,$valori, $tipi){
    global $DSN,$USERDB,$PSWDB;
    $ris=[];
    try{
        $conn=new PDO($DSN,$USERDB,$PSWDB);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $stm=$conn->prepare($strquery);
        if (!empty($valori)) {
            for($i=0;$i<count($valori);$i++){
                $stm->bindParam($i+1,$valori[$i],$tipi[$i]);
            }
        }
        $stm->execute();
        if (stripos($strquery, "INSERT") === 0 || stripos($strquery, "UPDATE") === 0 || stripos($strquery, "DELETE") === 0) {
            $ris= $stm->rowCount();
        } elseif (stripos($strquery, "SELECT") === 0) {
            $ris= $stm->fetchAll(PDO::FETCH_NAMED);
        } else {
            // Tipo di query non riconosciuto (errrore di battitura ecc..)
            $ris['error']= "tipo di query non riconosciuto";
         }
        //ris=$stm->fetchAll(PDO::FETCH_NAMED);
        $conn=null;
    }
    catch(Exception $e){
        $ris['error']=$e->getMessage();
    }
    return $ris;
}
 
?>