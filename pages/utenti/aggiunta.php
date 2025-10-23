<?php
/* byprati
se utente non loggato
allora
    vai al login
altrimenti
    visualizza header
    visualizza titolo "Inserimento nuovo utente"???
    se esiste POST
    allora
      apiinserimento utente con controll dei dati inseriti in post e restituzione vettore $errori (vettore vuoto se non ci sono errori ed ins effettuato nel db)
    fse
    se esiste POST ed errori è vettore Vuoto  (la seleizone precedente ha ins i dati nel DB)
    allora
         visualizzazione messaggio  di successo (no form)
    altrimenti
        visualizza form di registrazione passando vettore errori +POST
    fse
    visualizza footer
fse
*/
session_start();

require_once "funzioniDB.php";
require_once "./components/Footer/footer.php";
require_once "./components/Header/header.php";
require_once "./components/Head/head.php";
require_once "./api/apiRegistrazione/API_inserimentoUtente.php";
require_once "./components/formRegistrazione/COMP_formRegistrazione.php";

if(!isset($_SESSION['idUtente'])){
    header("Location: login");
}else{


    echo COMP_head();
    
?>
<body>
<?php
    echo COMP_header($_SESSION);
?>

    <span class="col-8 text-center text-primary">
        <h1>Inserimento nuovo utente</h1>
    </span>
<?php
    $errori = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errori = API_inserimentoUtente([], $_POST, []);
    }
    if (isset($_POST['nome']) && !isset($errori['error'])) {
        
    // TODO: Invio notifica via email all'utente stesso per la validazione dello username da parte dell'utente

        //style="font-weight: bold; font-size: 1.1rem;" nel div??? eliminato by prati
        echo '<div class="alert alert-success mb-4" role="alert">
              Utente registrato con successo.
              </div>';
        //byprati: convalida dell'utente perchè inserito by admin
        $strsq="update utenti set validato=1 where idUtente=?";
        $valori=[$idUtente];
        $tipi=[PDO::PARAM_INT];
        $rowQuery=db_query($strsql,$valori,$tipi);
    }
    else{

        echo COMP_formRegistrazione($errori, $_POST,false);
    }
    echo COMP_Footer();
?>

</body>

</html>

<?php
}
?>