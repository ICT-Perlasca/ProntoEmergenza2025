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
		return '
			<div class="input-group col-6 m-auto pt-3">
				<input class="form-control" type=text name="'.$nome.'" placeholder="'.$place.'" onInput="filtra(this)">
				<span class="input-group-text rounded-right" style="border-radius:0px"><i class="bi bi-search"></i></span>
			</div>
			<script src=".\public\js\searchBar.js"></script>';
	}
?>

		
