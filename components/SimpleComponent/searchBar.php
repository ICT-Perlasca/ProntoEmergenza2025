<?php
	function CMP_SearchBar($page){
		$nome="";
		$place="";
		if($page=="utenti"){
			$nome="cognomeNome";
			$place="Inserisci Nome o Cognome";
		}else{
			$nome="targaNome";
			$place="Inserisci la Targa o il Nome del mezzo";
		}
		return "
			<div class='col-9 m-auto pt-3'><input class='form-control' type=text name='$nome' placeholder='$place' onInput='filtra(this)'></div>
			<script src='.\public\js\searchBar.js'></script>";
	}
?>

		
