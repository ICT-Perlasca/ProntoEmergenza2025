<?php
    //ATTENZIONE: LA GRAFICA NON E' STATA PERFEZIONATA
    require_once("./funzioniDB.php");
    require_once ("./api/API_SlotTurni.php");

    session_start();

    if(!isset($_SESSION['idUtente']) || $_SESSION['tipoUtente'] != 'admin'){ //Controlla se l'utente NON è un admin
        header("Location: /ProntoEmergenza2025/login"); //e lo reindirizza al login se non lo è
    }else{
        //se è settato $_POST['mese'] x cui mese già selezionato 
        if (isset($_POST['mese'])){
            $esito = API_SlotTurni([], $_POST['mese'], $_SESSION); //altrimenti controlla se i turni sono stati inseriti correttamente
            if($esito)
                $esito = "Turni inseriti correttamente";
            else
                $esito = "Errore nell'inserimento dei turni";
        }
?>
<html>
<?php
require_once ("./components/Head/head.php");

echo COMP_head();  //stampa dell'head

?>
<body>
<?php
    require_once ("./components/Header/header.php");
  //  require_once ("./components/SimpleComponent/popup.php");
    require_once ("./components/Footer/footer.php");

echo COMP_header($_SESSION); //stampa dell'header

$mesi = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre']; //definizione dei mesi

echo '<form method=POST name=form>';  //stampa della combo per selezionare il mese dove inserire i turni
echo '<select name="mese" class="form-select form-select-lg mb-3" aria-label="Large select example">';
echo '<option selected>Scegli il mese dei turni da inserire</option>';
for($i=1; $i<=12; $i++) {
    echo '<option value="'.$i.'">'.$mesi[$i-1].'';
    echo '</option>';
}
echo '</select>';
//echo '<button type=submit>Prova</button>'; //bottone per inviare i dati (usato solamente per testare il corretto funzioamento del codice)


/*echo COMP_Popup(  //stampa bottone di popup (ATTENZIONE: non è stato realizzato il poter inserire i turni tramite questo bottone)
    'popupConferma',
    'Sei sicuro?',
    'Vuoi davvero procedere con questa azione?',
    "alert('Hai confermato!')"
);*/
?>
<!-- Bottone per aprire il popup -->
<button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#popupConferma">
    Conferma mese
</button>

<?php
echo '</form>';
//echo '<div>' .$esito. '</div>'; //stampa dell'esito
echo '<br><br>';
echo COMP_Footer(); //stampa del footer
?>
</body>
</html>
<?php
    }
?>