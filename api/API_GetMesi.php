<?php
//API che restituisce i mesi un cui sono presenti dei turni convalidati di un certo tipo(completata)
//Percorso: ProntoEmergenza2025/api

	require_once("./funzioniDB.php");
	function API_getMesi($get, $post, $session){
		if (!isset($session['tipoUtente']) || $session['tipoUtente'] != "admin"){
			header("HTTP/1_.1 403 Forbidden");
			return [];
		}else{
			$tipo=$post["tipo"];
			if($tipo=="turni118"){
				$query="SELECT MONTH(data) AS mese,YEAR(data) AS year FROM turni118 as t118 inner join turniutenti as tu on t118.idTurno118=tu.idTurno118 WHERE tu.convalidato=1 GROUP BY mese, year;";
			}else if($tipo=="programmati"){
				$query="SELECT MONTH(data) AS mese,YEAR(data) AS year FROM eventiprogrammati as e inner join turniutenti as tu on e.idEventoProgrammato=tu.idEventoProgrammato WHERE tu.convalidato=1 GROUP BY mese, year;";
			}else if($tipo=="assistenza"){
				$query="SELECT MONTH(data) AS mese,YEAR(data) AS year FROM assistenze as a inner join turniutenti as tu on a.idAssistenza=tu.idAssistenza WHERE convalidato=1 GROUP BY mese, year;";
			}
			$valori=[];
			$tipi=[];
			$risposta=db_query($query, $valori, $tipi);
			return $risposta;
		}
	}
?>	