<?php
require_once('./api/GetUtenteByEmail.php');
require_once('./components/SimpleComponent/COMP_Buttons.php');

function COMP_ModificaProfilo($emailUt){
    //class = 'table-striped table-warning'
    $utente = API_getUtente([], array("emailUt" => $emailUt), $_SESSION);

    $msg = "
    <div class = ' col-6 col-sm-12 col-md-6 col container pt-5 pb-5 justify-content-center align-items-center'>
        <form method = 'POST' name = 'modificaUtente'>
            <table style='width:100%;text-align: center;' >
                <tbody>
                    
                    <tr>
                        <td><label for = 'via'>Modifica la via</label></td>
                        <td><input type = 'text' name = 'via'></td>
                        <td>".$utente[0]['via']."</td>
                    </tr>

                    <tr>
                        <td><label for = 'numero'>Modifica il numero civico</label></td>
                        <td><input type = 'text' name = 'numero'></td>
                        <td>".$utente[0]['numero']."</td>
                    </tr>

                    <tr>
                        <td><label for = 'citta'>Modifica la città</label></td>
                        <td><input type = 'text' name = 'citta'></td>
                        <td>".$utente[0]['citta']."</td>
                    </tr>

                    <tr>
                        <td><label for = 'tel'>Modifica il numero di telefono</label></td>
                        <td><input type = 'text' name = 'tel'></td>
                        <td>".$utente[0]['telefono']."</td>
                    </tr>

                    <tr>
                        <td><label for = 'psw'>Modifica la password</label></td>
                        <td><input type = 'text' name = 'psw'></td>
                        <td>---</td>
                    </tr>

                    <tr>
                        <td><label for = 'img'>Modifica la foto profilo</label></td>
                        <td ><input type = 'file' name = 'img'></td>
                        <td><img src = ".ritornaImmagine($utente[0]['immagine'])." width = '50'></td>
                    </tr>

                    <tr>
                        <td><label for = 'doc'>Modifica il documento di identità</label></td>
                        <td><input type = 'file' name = 'doc'></td>
                        <td></td>
                    </tr>

                </tbody>
            </table>
            <div style ='text-align: center; padding-top: 15px;' >
                <input type = 'submit' name = 'invia' value = 'MODIFICA'>
            </div>
        </form>
    </div>
    ";

    return $msg;

}

function ritornaImmagine($immagine){  
	$path = "./uploads/images/";
	$img = "";
	
	if ($immagine!="" && file_exists($path.$immagine))
		$img = $path.$immagine;
	else
		$img = "./public/images/avatar.jpg";
	return $img;
}


?>