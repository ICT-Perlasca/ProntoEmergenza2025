<?php
//API che restituisce i turni convalidati di un determinato mese(Completata) 
//Percorso: ProntoEmergenza2025/api
require_once("funzioniDB.php");
function API_elencoTurniConvalidatiMensile($get, $post, $session){
    if(!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
		$sql="";
        if($post['tipo']=="turni118"){
			$sql="SELECT t.data, t.oraInizio, t.oraFine, u.nome, u.cognome, r.nome as m from
			 turniutenti as tu inner join turni118 as t on tu.idTurno118=t.idTurno118 inner join utenti as u on tu.idUtente=u.idUtente inner join Ruoli as r on tu.idRuolo=r.idRuolo
			 where YEAR(t.data) = ? AND MONTH(t.data) = ?
			 order by t.data;";
		}else if($post['tipo']=="programmati"){
			$sql="SELECT t.data, t.oraInizio, t.oraFine, u.nome, u.cognome, r.nome as m from
			 turniutenti as tu inner join eventiprogrammati as t on tu.idEventoProgrammato=t.idEventoProgrammato inner join utenti as u on tu.idUtente=u.idUtente inner join Ruoli as r on tu.idRuolo=r.idRuolo
			 where YEAR(t.data) = ? AND MONTH(t.data) = ?
			 order by t.data;";
		}else if($post['tipo']=="assistenza"){
			$sql="SELECT t.data, t.oraInizio, t.oraFine, u.nome, u.cognome, r.nome as m from
			 turniutenti as tu inner join assistenze as t on tu.idAssistenza=t.idAssistenza inner join utenti as u on tu.idUtente=u.idUtente inner join Ruoli as r on tu.idRuolo=r.idRuolo
			 where YEAR(t.data) = ? AND MONTH(t.data) = ?
			 order by t.data;";
		}
        $valori = [$post['year'], $post['month']];
        $tipi = [PDO::PARAM_STR,PDO::PARAM_STR];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}
?>
 