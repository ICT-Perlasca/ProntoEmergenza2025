<?php
    //ATTENZIONE: LA GRAFICA NON E' STATA PERFEZIONATA
    require_once("./funzioniDB.php");
    require_once ("./api/API_SlotTurni.php");
    require_once ("./components/Head/head.php");
    require_once ("./components/Header/header.php");
   // require_once ("./components/SimpleComponent/COMP_popup.php");
    require_once ("./components/SimpleComponent/COMP_form.php");
    require_once ("./components/Footer/footer.php");

    session_start();

    if(!isset($_SESSION['idUtente']) || $_SESSION['tipoUtente'] != 'admin'){ //Controlla se l'utente NON è un admin
        header("Location: /ProntoEmergenza2025/login"); //e lo reindirizza al login se non lo è
    }else{
        //byprati: visualizza header della pagina(comune alle due pagine visualizzate con questo script)

        echo"<html>";
        echo COMP_head();  //stampa dell'head
        echo "<body>";
        echo COMP_header($_SESSION); //stampa dell'header
        echo COMP_formContainerHeader("Nuovo mese in programmazione", false,"");

        //se è settato $_POST['mese'] x cui mese già selezionato 
        if (isset($_POST['mese'])){
            //byprati:eseguoinserimento turni
            $esito = API_SlotTurni([], $_POST, $_SESSION); //altrimenti controlla se i turni sono stati inseriti correttamente
            /*byprati:
            visualizza messaggio[testo]
            se esito['status'] ='ok'
            allora
                invia le email ai vari volontari per mese in programmazione
                visualizza messaggio "email inviate per avviso ai volontari"
            fse
            */
            //byprati: visualizza la pagina2 di risposta dopo inserimento slot ed invio email
            echo $esito['testo']."<br>";
            if($esito['status']='ok')
                echo "dovrei inviare le email<br>";        
        }
        else{ //byprati: visualizza la pagina1 con il form per indicare mese da programmare

//$mesi = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre']; //definizione dei mesi

            
            echo '<form method=POST name=form>';  
//stampa della combo per selezionare il mese dove inserire i turni
/*echo '<select name="mese" class="form-select form-select-lg mb-3" aria-label="Large select example">';
echo '<option selected>Scegli il mese dei turni da inserire</option>';
for($i=1; $i<=12; $i++) {
    echo '<option value="'.$i.'">'.$mesi[$i-1].'';
    echo '</option>';
}
echo '</select>';
*/
//byprati: visualizza mese da programmare come mese-data-attuale+1 (anno+1 solo se mese attuale=12)
//alla pressione di conferma crea tutte le nple della tabella turni118
            $meseAttuale=date('m');
            $annoAttuale=date('Y');
            $meseDaProgrammare=($meseAttuale+1)%12;
            $anno=($meseAttuale==12)?$annoAttuale+1:$annoAttuale;
            echo "<div class='row g-3 align-items-center'>
            <div class='col-auto'><label for='meseProgrammare' class='form-label'>Mese da programmare:</label></div>
            <div class='col-auto'><input type='text' name=mese class='form-control' id='meseProgrammare' value=$meseDaProgrammare readonly></div>
            </div><br>
            <div class='row g-3 align-items-center'>
            <div class='col-auto'><label for='annoProgrammare' class='form-label'>Anno da programmare:</label></div>
            <div class='col-auto'><input type='text' name=anno class='form-control' id='annoProgrammare' value=$anno readonly></div>
            </div>";
//echo '<button type=submit>Prova</button>'; //bottone per inviare i dati (usato solamente per testare il corretto funzioamento del codice)
/*
?>
<!-- Bottone per aprire il popup -->
<button type="submit class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#popupConferma">
    Conferma mese
</button>

<?php

echo '</form>';
*/
            echo COMP_formFooter("Conferma Mese","btn",false,"/ProntoEmergenza2025");
//echo '<div>' .$esito. '</div>'; //stampa dell'esito
/*echo COMP_Popup(  //stampa bottone di popup (ATTENZIONE: non è stato realizzato il poter inserire i turni tramite questo bottone)
    'popupConferma',
    'Sei sicuro?',
    'Vuoi davvero procedere con questa azione?',
    "alert('Hai confermato!')"
);*/

    }
    //byprati: visualizza footer della pagina (comune alle due pagine)
    echo COMP_formContainerFooter();
    echo COMP_Footer();
    echo "</body></html>"; 
}
?>