<?php
	function CMP_SearchBar(){
		return "
		<div class='col-9 m-auto pt-3'><input class='form-control' type=text name='cognomeNome' placeholder='Inserisci Nome e Cognome' onInput='filtraUtenti(this)'></div>
		<script src='.\public\js\searchBar.js'></script>";
	}
?>	
