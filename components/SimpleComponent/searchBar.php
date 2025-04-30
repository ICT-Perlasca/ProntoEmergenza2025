<?php
	function CMP_SearchBar(){
		return "
		<input class=form-control type=text name='cognomeNome' placeholder='Inserisci Nome e Cognome' onInput='filtraUtenti(this)'>
		<script src='.\public\js\searchBar.js'></script>";
	}
?>

		
