<?php


function API_elaboraExcel($get,$post,$session){
  // Se non esiste la sessione o non esistono i dati in POST non si procede
    if (!isset($session["idUtente"]) || !isset($post['json'])) {
        header('HTTP/1.1 403 Forbidden');
        return [];
    }
    //require_once __DIR__ . '/../funzioniDB.php';
    require_once __DIR__ . '/../components/SimpleComponent/COMP_DataToExel.php';
   // $dati = db_query($post['query'], $post['valori'], $post['tipi']);
    $dati=json_decode($post['json']);
    DataToExcel($dati, $post['tit'], 'xlsx');
    //$ret ['success']=true;
    //return $ret;
}
?>