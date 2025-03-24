<?php
function api_login($get,$post,&$session){
require_once "..\\namespace\\global.php";
//require_once "..\\namespace\\db.php"; 
//use lib\DB;
require_once "funzioniDB.php";

$responseArray = array(         //qui invio false come risultato (quindi un errore) e come tipoErr invio log ossia
    'risultato' => 'false',		//un errore nei dati inseriti dall'utente
    'tipoErr' => 'log'
);
if (isset($post["user"]) && isset($post["psw"])) {
    try {
       // $db = new DB();
    
        $sql = "SELECT idUtente,nome, cognome, istruttore, status, tipoUtente, immagine FROM utenti WHERE username=? and password=?;";
        //$parameters = [[':user', $user], [':psw', $psw]    ];
    //echo $sql."<br>";
        $result = api_querySelect($sql,[$post["user"],$post["psw"]], [PDO::PARAM_STR,PDO::PARAM_STR]);
    //print_r ($result);
        /*
            La sessione conterrà i seguenti dati: nome, cognome, idUtente, istruttore,status e tipoUtente. Questi sono anche
            i nomi utilizzati negli indici (sono gli stessi nomi degli attributi nel database). Lo status contiene:
            volontario, dipendente o corsista; tipoUtente contiene:admin o user; istruttore contiene 0 o 1 (1 se è un istruttore
            0 se non lo è); idUtente contiene un numero che rappresenta univocamente un utente.
        
        */
        if ($result && is_array($result) && count($result) > 0) {
            //            x mantenere la sessione attiva x 30 giorni

            /*$lifetime = 30 * 24 * 60 * 60;
            session_set_cookie_params($lifetime);
            ini_set('session.gc_maxlifetime', $lifetime);*/
            

/*          $lifetime = 30 * 24 * 60 * 60;
            ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
            ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
            ini_set('session.save_path', '../sessions');
    */
            $user = $result[0];
            $session['nome']=$user['nome'];
            $_SESSION['cognome']=$user['cognome'];
            $_SESSION['idUtente']=$user['idUtente'];
            $_SESSION['istruttore']=$user['istruttore'];
            $_SESSION['status']=$user['status'];
            $_SESSION['tipoUtente']=$user['tipoUtente'];
            $_SESSION['immagine']=$user['immagine'];
            $responseArray['risultato'] = 'true';
            $responseArray['utente'] = ($user['tipoUtente'] == 'admin') ? 'admin' : 'user';
        } else {
            $responseArray['risultato'] = 'false';
            $responseArray['tipoErr'] = 'log';
        }
    } catch (PDOException $e) {
        $responseArray['risultato'] = 'false';
        $responseArray['tipoErr'] = 'sistema: accesso al DB';
       
    } finally {
        if (isset($db)) $db->close();
    }    
}

return $responseArray;
}

//per la prova
session_start();
echo api_login([],['user'=>'ciao','psw'=>'ciao'],$_SESSION);
?>