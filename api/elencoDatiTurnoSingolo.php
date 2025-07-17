<?php
require_once ('funzioniDB.php');
//byprati: questa API vene rihiamata quando avendo idTurno singolo 118 voglio permettere all'utente admin di modificare dati (utente oppure orari, o di cancellare il turno stesso!!)
function API_elencoDatiTurnoSingolo($get, $post, $session){
    $idT = $post['idTurno'];

    $ret = [];
//byprati: mi faccio restituire del turno l'id dell'utente ed l'id del turno stesso per poterlo usare quando admin vuole modificarlo (funzione richiamata al clink su matita se utente è admin apriPopupModificaTurno (calendar.js)!!!!
    $query = "select t118.idTurno118 as idT, u.idUtente as idUtente, u.cognome as cognome, u.nome as nome, r.nome as ruolo, t118.oraInizio as oraInizio, t118.oraFine as oraFine, tu.testoNota as testoNota, tu.oraInizioEffettiva as oraInizioEffettiva, tu.oraFineEffettiva as oraFineEffettiva
    from utenti as u inner join turniutenti as tu on u.idUtente=tu.idUtente
    inner join ruoli as r on r.idRuolo=tu.idRuolo 
    inner join turni118 as t118 on t118.idTurno118=tu.idTurno118
    where t118.idTurno118 = ?";

    $ret = db_query($query, [$idT], [PDO::PARAM_STR]);

    return $ret;
}
/*

require_once $_SERVER['DOCUMENT_ROOT'].'/funzioniDB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';

// require_once '/funzioniDB.php';
// require_once '/globals.php';

$data = $_POST['data'];

$ret = [
    'turni' => []
];

$query = "select  u.cognome as cognome, u.nome as nome, r.nome as ruolo, t118.oraInizio as oraInizio, t118.oraFine as oraFine, tu.testoNota as testoNota, tu.oraInizioEffettiva as oraInizioEffettiva, tu.oraFineEffettiva as oraFineEffettiva
from utenti as u inner join turniutenti as tu on u.idUtente=tu.idUtente
inner join ruoli as r on r.idRuolo=tu.idRuolo 
inner join turni118 as t118 on t118.idTurno118=tu.idTurno118
where t118.data = ?";

$ret['turni'] = db_query($query, [$data], [PDO::PARAM_STR]);

echo json_encode($ret);

*/