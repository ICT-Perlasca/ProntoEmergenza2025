<?php
require_once('./api/API_getUtenteByEmail.php');
require_once('./components/SimpleComponent/COMP_Buttons.php');
require_once ("./globals.php");
function CMP_profiloUtenteSingolo($emailUt){
	$utente = API_getUtente([], array("emailUt" => $emailUt), $_SESSION);
	
	if ($utente == []){
		$msg = "Tipo di utente non valido";
	}else{
		$img = ritornaImmagine($utente[0]['immagine']); //ritornaImmagine("bici.jpg");
		$msg = "
			<div class = 'container'>

				<div class = 'row'>

					<div class = ' col-6 col-sm-12 col-md-6 col d-flex flex-column justify-content-center align-items-center'>
						<img src = ".$img." width='200'></td>
						<div>".$utente[0]['nome']. " " . $utente[0]['cognome'] ."</div>
						
					</div>

					<div class = 'col-3 col-sm-6 col-md-3 col'>
						<table class = 'table table'>
							<thead>
								<tr>
									<th>Telefono</th>
								</tr>
								<tr>
									<th>E-mail</th>
								</tr>
								<tr>
									<th>Età</th>
								</tr>
								<tr>
									<th>Indirizzo</th>
								</tr>
								<tr>
									<th>Qualifiche</th>
								</tr>
							</thead>
						</table>
					</div>
					
					<div class = 'col-3 col-sm-6 col-md-3 col'>
						<table class = 'table table'>
							<tbody>
								<tr>
									<td>". $utente[0]['telefono'] ."</td>
								</tr>
								<tr>
									<td>". $utente[0]['email'] ."</td>
								</tr>
								<tr>
									<td>".calcolaEta( $utente[0]['dataNascita'] )."</td>
								</tr>
								<tr>
									<td>". $utente[0]['via'] . " " . $utente[0]['numero'] . " " . $utente[0]['citta']. "</td>
								</tr>
								<tr>
									<td>". $utente[0]['tipoUtente'] ."</td>
								</tr>
							</tbody>
						</table>
						
					</div>

				</div>
				<br>
				<div class='d-flex flex-wrap justify-content-center gap-2'>
					<div class='col-sm-6 col-md-3 text-center'>
						".COMP_Button("	", "HOME", "./home")."
					</div>
					<div class='col-sm-6 col-md-3 text-center'>
						".COMP_Button("", "MODIFICA", "./modificaUtente")."
					</div>
				</div>

			</div>
        ";
	}
	return $msg;
}


function calcolaEta($dataN){
	$oggi = new DateTime();
	$dn = new DateTime($dataN);
	$diff = $dn->diff($oggi);
	return $diff->y;
}

function ritornaImmagine($immagine){  

	global $imgAvatar, $cartellaImmagini;

	$path = "./$cartellaImmagini/";
	$img = "";
	
	if ($immagine!="" && file_exists($path.$immagine))
		$img = $path.$immagine;
	else
		$img = "./public/images/$imgAvatar";
	return $img;
}