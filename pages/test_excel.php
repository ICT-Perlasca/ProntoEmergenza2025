<?php
require_once __DIR__ . '/../funzioniDB.php';
require_once __DIR__ . '/../components/SimpleComponent/COMP_DataToExel.php';

$dati = db_query("SELECT * FROM turni118", [], []);

DataToExcel($dati, 'report_emergenza', 'xlsx');
