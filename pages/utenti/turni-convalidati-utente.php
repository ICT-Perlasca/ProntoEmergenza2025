<?php
//Pagina che mostra i turni convalidati in un mese di un determinato utente(completata)
//Percorso: ProntoEmergenza2025/pages/turni

	require_once("./components/Head/head.php");
	require_once("./components/Header/header.php");
	require_once("./components/Footer/footer.php");
	require_once("./components/SimpleComponent/COMP_form.php");
	require_once("./components/SimpleComponent/COMP_selectUtenti.php");
	require_once("./api/API_getMesi.php");
	session_start();
	if(!isset($_SESSION["idUtente"])){
		header("Location: ./pages/login.php");
	}else{
?>
	<html>
	<?php 
		echo COMP_head();	
	?>
		<body>
<?php
	
	echo COMP_Header($_SESSION);
?>	
	<script type="text/javascript" src="./public/js/scriptTurniConvalidati.js"></script>
	<center>
			<!--	<div class="container py-5">
					<div class="row justify-content-center align-items-center min-vh-40">
						<div class="col-md-8 col-lg-6">
							<div class="card shadow-lg animate__animated animate__fadeInDown">
								<div class="card-body p-4">
									<h3 class="text-center text-primary mb-4">
										 Elenco Turni Convalidati di un utente
									</h3>
	-->
		<?php echo COMP_formContainerHeader('Elenco Turni Convalidati di un utente',false,'');?>
		<form method="POST" action="" class="needs-validation" onsubmit="getTurniMeseUtente(this); return false;">
			<div class="mb-3">
				<label for="tipo" class="form-label">Tipo di turno</label>
				<select name="tipo" onChange="GetMesi(this)">
					<option>-</option>
					<option value=turni118>Turni 118</option>
					<option value=programmati>Eventi Programmati</option>
					<option value=assistenza>Assistenza</option>
				</select>
			</div>
			<div class="mb-3" id=selectMeseAnno></div>
			<div class="mb-3">
				<label for="utente">Inserisci l'utente</label>
<!--				<input type=text name=utente placeholder="Nome e Cognome">
	-->
					<?php echo COMP_selectUtenti("idUtente");?>
			</div>
<!--		<input name="inserisciComunicazione" value="Ricerca Turni" type="submit" class="btn btn-primary w-50">
-->
				<?php echo COMP_formFooter('Ricerca Turni','btnRicercaTurni',true);?>
			<input type=hidden id=hiddenJson value="">
		</form>
		<?php echo COMP_formContainerFooter();?>
				<!--		</div>
							</div>
						</div>
					</div>
				</div>-->
		<div id=tableTurni></div>
	</center>
	<?php
		echo COMP_Footer();
	?>
		</body>
	</html>
<?php
	}
?>