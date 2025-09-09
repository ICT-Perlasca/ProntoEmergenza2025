<?php
//require_once __DIR__ . '/../funzioniDB.php';
require_once __DIR__ . '/../components/SimpleComponent/COMP_DataToExel.php';
require_once __DIR__ . '/../components/SimpleComponent/COMP_DataToPDF.php';

//$dati = db_query("SELECT * FROM turni118", [], []);
if (isset($_POST['json'])){
    $dati=json_decode($_POST['json'],true);
    $titolo=$_POST['title'];
    //print_r($dati);
    if (isset($_POST['excel']))
        DataToExcel($dati, $titolo, 'xlsx');
    else if (isset($_POST['pdf']))
        DataToPdf();
}
?>