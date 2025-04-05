<?php
function API_GetUtente($get, $post, $session){
    if(!isset($post['idUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
        $sql = "SELECT * from utenti WHERE idUtente=?;";
        $valori = [$post['idUtente']];
        $tipi = [PDO::PARAM_INT];
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
