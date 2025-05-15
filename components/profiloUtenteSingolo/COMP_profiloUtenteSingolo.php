<?php
require_once('./api/GetUtenteByEmail.php');
function CMP_profiloUtenteSingolo($emailUt){
	$utente = API_GetUtente([], array("emailUt" => $emailUt), $_SESSION);
	
	if ($utente == []){
		$msg = "Tipo di utente non valido";
	}else{
		$msg = "
			<div class = 'container'>

				<div class = 'row'>

					<div class = ' col-6 col-sm-12 col-md-6 col d-flex flex-column justify-content-center align-items-center'>
						<img src = 'montagne3.jpeg'></td>
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