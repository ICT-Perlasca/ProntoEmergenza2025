<?php  
/*modifica utente: cosa puoi modificare  
    indirizzo, contatti (tel e email), password, immagine profilo, documenti (visualizza quelli esistenti e ne aggiunge),
    ruolo (autista, soccorritore), istruttore (si/no)

*/
/* byprati
se utente non loggato
allora
    vai al login
altrimenti
    se utente loggato ="admin"
    allora

    altrimenti

    fse
    visualizza header
    visualizza titolo "Modifica dati utente"
    se esiste POST
    allora
      api modifica  utente con controll dei dati inseriti in post e restituzione vettore $errori (vettore vuoto se non ci sono errori ed ins effettuato nel db)
    fse
    se esiste POST ed errori è vettore Vuoto  (la seleizone precedente ha modificato i dati nel DB)
    allora
         visualizzazione messaggio  di successo (no form)
    altrimenti
        visualizza form di modifica (comp_modifica) passando vettore errori +POST
    fse
    visualizza footer
fse
*/

session_start();

require_once "funzioniDB.php";
require_once "./components/Footer/footer.php";
require_once "./components/Header/header.php";
require_once "./components/Head/head.php";
require_once "./api/API_modificaUtente.php";
require_once "./components/profiloUtenteSingolo/COMP_modificaUtente.php";
require_once "./components/SimpleComponent/COMP_form.php";

if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{
    $title="Modifica profilo utente";
     $errori = [];
    //if (!isset($_COOKIES['idUtenteUpdate']))
    //dovrei arrivare qui che esiste sempreil cookie !!!
    $idUtente=$_COOKIE['idUtenteUpdate'];
    
    //e non dovrebbe aver senso qui aprirepagina con indicazione nessun utente da modificare

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errori = API_modificaUtente(['idUtente'->$idUtente], $_POST, []);
    }
    if (isset($_POST['via']) && !isset($errori['error'])) {
        //elimino cookie per utente da modificare
       setcookie("idUtenteUpdate",'');
    }
?>
<html>
<?php
    echo COMP_head();  
?>
<body>
<?php
    echo COMP_header($_SESSION);
    
?>
   <!-- <span class="col-8 text-center text-primary">
        <h1>Modifica profilo utente</h1>
    </span>-->
<?php
   
    if (isset($_POST['via']) && !isset($errori['error'])) {
        //fine della modifica perchè no errori dopo update
        echo COMP_formContainerHeader($title,true,"Modifica effettuata con successo!!!!");
        echo COMP_formContainerFooter();    
    }
    else{ //o siamo prima volta(senza post) o con post ma con errori quindi ripresento il form con i dati
        echo COMP_formContainerHeader($title,isset($errori['error']), 'Errori in aggiornamento!!!  modifica i campo indicati!');//messaggiosolo in caso di errori
        echo COMP_modificaUtente($idUtente,$errori, $_POST);
        echo COMP_formFooter("Modifica Utente","btnModifica",false,"/ProntoEmergenza2025");
        echo COMP_formContainerFooter(); 
    }
    echo COMP_Footer();
?>
</body>
</html>

<?php
}
?>
