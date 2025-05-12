<?php
require_once("./funzioniDB.php");
require_once("richiestaRipristino.php");

function API_resetPassword($get, $post, $session) {

    $psw = $post['psw'];
    $confPsw = $post['confPsw'];
    $messaggio = "";

    if (isset($psw, $confPsw)) {
        if (strlen($psw) > 8 && preg_match('/[0-9]/', $psw) && preg_match('/[\W_]/', $psw)) {
            if ($psw === $confPsw) {
                $token = base64_decode($post['token']);

                list($email, $hash) = explode("-", $token);

                if (checkEmail($email) > 0 && md5($email) === $hash) {

                    $sql = "UPDATE utenti SET password=? WHERE email=?";
                    $res = db_query($sql, [$psw, $email], [PDO::PARAM_STR, PDO::PARAM_STR]);
                    if(!empty($res["error"])) {
                        $messaggio = $res["error"];
                    } else {
                        $messaggio = "password modificata.";
                    }
                    
                } else {
                    echo "email manomessa.";
                }
            } else {
		        $messaggio = "le password non coincidono.";
	        }
        } else {
	        $messaggio = "la password deve contenere almeno un numero e un carattere speciale, oltre ad essere di almeno 8 caratteri.";
	    }
    }

    return $messaggio;
}
?>