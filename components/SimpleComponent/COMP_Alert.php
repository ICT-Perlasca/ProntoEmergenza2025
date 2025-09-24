<?php
function COMP_Alert($tipoAlert,$message) {
//    $codice="<div class='col-sm-6 col-md-3 text-center alert-secondary' role='alert'>$message</div>";
     $codice="<center><div class='alert $tipoAlert' role='alert'>$message</div></center>";
    return $codice;
}
function COMP_ModalAlert($title, $message){
$codice="<div class='modal' tabindex='-1'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>$title</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <p>$message</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                    <button type='button' class='btn btn-primary'>Save changes</button>
                </div>
                </div>
            </div>
        </div>";
return $codice;
}
?>
<!--
/* alert modale in javascript
// Salva la funzione alert originale
const originalAlert = window.alert;

// Sovrascrivi la funzione alert
window.alert = function(message) {
    // Crea l'elemento div per il modal
    const modal = document.createElement('div');
    modal.style.cssText = `
        width: 30vw; /* Larghezza del modal */
        height: 100px; /* Altezza del modal */
        border: 1px solid #bbb; /* Bordo */
        border-radius: 5px; /* Angoli arrotondati */
        padding: 10px; /* Spaziatura interna */
        background: white; /* Sfondo bianco */
        box-shadow: 0px 0px 8px #0006; /* Ombra */
        position: fixed; /* Posizione fissa */
        top: 20px; /* Distanza dal top */
        right: 0; /* Distanza dal lato destro */
        left: 0; /* Distanza dal lato sinistro */
        margin: auto; /* Centra il modal */
        font-family: "Arial", sans-serif; /* Font */
        color: black; /* Colore del testo */
        z-index: 1000; /* Z-index per visibilità */
        text-align: center; /* Centra il testo */
        line-height: 1.5; /* Interlinea */
    `;

    // Imposta il contenuto HTML del modal
    modal.innerHTML = `<b>Alert</b><br>${message}`;

    // Aggiungi il modal al body del documento
    document.body.appendChild(modal);

    // Aggiungi un listener per rimuovere il modal al click
    modal.addEventListener("click", function() {
        modal.remove();
    });

    // Per il comportamento standard del prompt/confirm, sarebbe necessario aggiungere bottoni e logica,
    // ma per un alert semplice basta la rimozione al click.
    // Se si volessero implementare prompt e confirm, la logica andrebbe più complessa
    // gestendo la creazione dei pulsanti e la pausa dell'esecuzione
    // del resto dello script fino all'interazione dell'utente [2].
};

*/
-->