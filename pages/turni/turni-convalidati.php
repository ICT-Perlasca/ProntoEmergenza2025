<?php
// Pagina per la visualizzazione dei turni convalidati in un mese(completata)
//Percorso: ProntoEmergenza2025/pages/turni

	require_once("./components/Head/head.php");
	require_once("./components/Header/header.php");
	require_once("./components/Footer/footer.php");
	require_once("./components/SimpleComponent/COMP_form.php");
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
			 <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
			<center>
		
				<?php echo COMP_formContainerHeader('Elenco Turni Convalidati di un utente',false,'');?>

				<form method="POST" action="" class="needs-validation" onsubmit="GetTurniMese(this); return false;">
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
					<?php echo COMP_formFooter('Ricerca Turni','btnRicercaTurni',true);?>
					<input type=hidden id=hiddenJson value="">
				</form>
				<?php echo COMP_formContainerFooter();?>
<!--								</div>
							</div>
						</div>
					</div>
				</div>
	-->
				<div class="mb-3" id=tableTurni></div>
			</center>
			<?php
				echo COMP_Footer();
			?>
		</body>
	</html>
<?php
	}
?>