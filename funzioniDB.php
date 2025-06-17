<?php
require_once "globals.php";
function db_query($strquery,$valori, $tipi){
    global $DSN,$USERDB,$PSWDB;
    $ris=[];
    try{
        $conn=new PDO($DSN,$USERDB,$PSWDB);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        //byprati aggiunto try catch x gestioni transazioni
        try {
                $conn->beginTransaction();
                $stm=$conn->prepare($strquery);
                if (!empty($valori)) {
                    for($i=0;$i<count($valori);$i++){
                        $stm->bindParam($i+1,$valori[$i],$tipi[$i]);
                    }
                }
                $stm->execute();

                
                //recupero ultimo id inserito nel caso di insert
                if (stripos($strquery, "INSERT") === 0)
                    $ris['lastId']=$conn->lastInsertId();

                $conn->commit();
        } catch(PDOExecption $e) {
                $conn->rollback();
                $ris['error']= "errore transazione su db_query: " . $e->getMessage() . "</br>";
        }
        if (stripos($strquery, "INSERT") === 0 || stripos($strquery, "UPDATE") === 0 || stripos($strquery, "DELETE") === 0) {
            $ris['numRow']= $stm->rowCount();
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
        $ris['error']="<br>errore connessione al database: ".$e->getMessage()."</br>";
    }
    return $ris;
}
 
?>