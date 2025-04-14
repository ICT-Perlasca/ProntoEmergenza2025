<?php

// require_once $_SERVER['DOCUMENT_ROOT'].'/funzioniDB.php';
// require_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';

require_once '../funzioniDB.php';
require_once '../globals.php';

$data = $_POST['data'];

$ret = [
    'turni' => []
];

$query = "select  u.cognome as cognome, u.nome as nome, r.nome as ruolo, t118.oraInzio as oraInizio, t118.oraFine as oraFine, tu.testoNota as testoNota 
from utenti as u inner join turniutenti as tu on u.idUtente=tu.idUtente
inner join ruoli as r on r.idRuolo=tu.idRuolo 
inner join turni118 as t118 on t118.idTurno118=tu.idTurno118
where t118.data = ?";

$ret['turni'] = db_query($query, [$data], [PDO::PARAM_STR]);

return json_encode($turni);