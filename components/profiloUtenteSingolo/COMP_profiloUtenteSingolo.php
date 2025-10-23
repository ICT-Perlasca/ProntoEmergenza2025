<?php
//require_once('./api/API_getUtente.php');
require_once('./components/SimpleComponent/COMP_Buttons.php');
require_once ("./globals.php");
function COMP_profiloUtenteSingolo($utente){
	//API richiamata in ambiete chiamate profiloUtente.php
	//$utente = API_getUtenteByEmail([], array("emailUt" => $emailUt), $_SESSION);
	
	if ($utente == []){
		$msg = "Tipo di utente non valido";
	}else{
		$img = ritornaImmagine($utente[0]['immagine']); //ritornaImmagine("bici.jpg");
		$msg = "
			<div class = 'container'>

				<div class = 'row'>

					<div class = ' col-6 col-sm-12 col-md-6 col d-flex flex-column justify-content-center align-items-center'>
						<img src = ".$img." width='200' height=200 class='rounded-circle '></td>
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
									<th>Data nascita</th>
								</tr>
								<tr>
									<th>Indirizzo</th>
								</tr>
								<tr>
									<th>Ruoli</th>
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
									<td>".date_format(date_create($utente[0]['dataNascita']),"d/m/Y")."</td>
								</tr>
								<tr>
									<td>Via ". $utente[0]['via'] . " " . $utente[0]['numero'] . " " . $utente[0]['citta']." (".$utente[0]['provincia'].")</td>
								</tr>
								<tr>
									<td>". $utente[0]['ruoli'] ."</td>
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
						".COMP_Button("", "MODIFICA", "./utenti/modificaUtente")."
					</div>
				</div>

			</div>
        ";
	}
	return $msg;
}


