<?php
require_once("funzioniDB.php");

function API_elencoTurniUtente($get, $post, $session){
    if(!isset($post['idUtente']) || !isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
        header("HTTP/1.1 403 Forbidden");
        return [];
    }else{
       $sql="";
        if($post['tipo']=="turni118"){
			$sql="SELECT t.data, t.oraInizio, t.oraFine, u.nome, u.cognome, r.nome as nomeruolo, tu.convalidato as m from
			 turniutenti as tu inner join turni118 as t on tu.idTurno118=t.idTurno118 inner join utenti as u on tu.idUtente=u.idUtente inner join Ruoli as r on tu.idRuolo=r.idRuolo
			 where u.idUtente=?
			 order by t.data;";
		}else if($post['tipo']=="programmati"){
			$sql="SELECT t.data, t.oraInizio, t.oraFine, u.nome, u.cognome, r.nome as nomeruolo, tu.convalidato as m from
			 turniutenti as tu inner join eventiprogrammati as t on tu.idEventoProgrammato=t.idEventoProgrammato inner join utenti as u on tu.idUtente=u.idUtente inner join Ruoli as r on tu.idRuolo=r.idRuolo
			 where  u.idUtente=?
			 order by t.data;";
		}else if($post['tipo']=="assistenza"){
			$sql="SELECT t.data, t.oraInizio, t.oraFine, u.nome, u.cognome, r.nome as nomeruolo, tu.convalidato as m from
			 turniutenti as tu inner join assistenze as t on tu.idAssistenza=t.idAssistenza inner join utenti as u on tu.idUtente=u.idUtente inner join Ruoli as r on tu.idRuolo=r.idRuolo
			 where  u.idUtente=?
			 order by t.data;";
		}
        $valori = [$post['idUtente']];
        $tipi = [PDO::PARAM_INT];
        $risposta = db_query($sql, $valori, $tipi);
        return $risposta;
    }
}