<?php
session_start();

header('Content-Type: application/json');

$route = isset($_GET['route']) ? trim($_GET['route'], "/") : '';

switch ($route) {
    case 'api/elencoComunicazioni':
        require_once ("./api/API_elencoComunicazioni.php");
        echo json_encode(API_elencoComunicazioni($_GET, $_POST, $_SESSION));
        break;
    case 'api/segnarecomunicazioneletta':
        require_once ("./api/api_segnare_comunicazione_letta.php");
        echo json_encode(API_segnareComunicazioneLetta($_GET, $_POST, $_SESSION));
        break;
    case 'api/ElencoMezziDisponibili':
        require_once ("./api/API_elencoMezziDisponibili.php");
        echo json_encode(API_elencoMezziDisponibili($_GET, $_POST, $_SESSION));
        break;
    case 'api/GetMezzo':
        require_once ("./api/GetMezzo.php");
        echo json_encode(API_getMezzo($_GET, $_POST, $_SESSION));
        break;
    case 'api/GetUtente':
        require_once ("./api/GetUtente.php");
        echo json_encode(API_getUtente($_GET, $_POST, $_SESSION));
        break;
    case 'api/ritornaUtenti':
        require_once ("./api/API_ritornaUtenti.php");
        echo json_encode(API_ritornaUtenti($_GET, $_POST, $_SESSION));
        break;    
    case 'api/elencoTurniData':
        require_once ("./api/elencoTurniData.php");
        echo json_encode(API_elencoTurniData($_GET, $_POST, $_SESSION));
        break;
    case 'api/elencoDatiTurnoSingolo':
        require_once ("./api/API_elencoDatiTurnoSingolo.php");
        echo json_encode(API_elencoDatiTurnoSingolo($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_popupTurno':
        require_once ("./api/API_popupTurno.php");
        echo json_encode(API_popupTurno($_GET, $_POST, $_SESSION)); 
        break;
    case 'api/API_salvaTurno':
        require_once ("./api/API_salvaTurno.php");
        echo json_encode(API_salvaTurno($_GET, $_POST, $_SESSION)); 
        break;
    case 'api/API_modificaTurno':
        require_once ("./api/API_modificaTurno.php");
        echo json_encode(API_modificaTurno($_GET, $_POST, $_SESSION)); 
        break;
    case 'api/cancellaTurno':
        require_once ("./api/API_cancellaTurno.php");
        echo json_encode(API_cancellaTurno($_GET, $_POST, $_SESSION)); 
        break;
    case 'api/API_elencoCompleanni':
        require_once ("./api/API_elencoCompleanni.php");
        echo json_encode(API_elencoCompleanni($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_elencoEventiPrevisti':
        require_once ("./api/API_elencoEventiPrevisti.php");
        echo json_encode(API_elencoEventiPrevisti($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_elencoOreUtente':
        require_once ("./api/API_elencoOreUtente.php");
        echo json_encode(API_elencoOreUtente($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_elencoOreUtenteMensile':
        require_once ("./api/API_elencoOreUtenteMensile.php");
        echo json_encode(API_elencoOreUtenteMensile($_GET, $_POST, $_SESSION));
        break;  
    case 'api/API_elencoTurniAnnoPrecedente':
        require_once ("./api/API_elencoTurniAnnoPrecedente.php");
        echo json_encode(API_elencoTurniAnnoPrecedente($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_elencoTurniConvalidatiMensile':
        require_once ("./api/API_elencoTurniConvalidatiMensile.php");
        echo json_encode(API_elencoTurniConvalidatiMensile($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_elencoTurniConvalidatiMensileUtente':
        require_once ("./api/API_elencoTurniConvalidatiMensileUtente.php");
        echo json_encode(API_elencoTurniConvalidatiMensileUtente($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_elencoTurniConvalidatiUtente':
        require_once ("./api/API_elencoTurniConvalidatiUtente.php");
        echo json_encode(API_elencoTurniConvalidatiUtente($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_getMesi':
        require_once ("./api/API_getMesi.php");
        echo json_encode(API_getMesi($_GET, $_POST, $_SESSION));
         break;
    case 'api/API_ritornaTurnoUtente_tra_due_date':
        require_once ("./api/API_ritornaTurnoUtente_tra_due_date.php");
        echo json_encode(API_ritornaTurnoUtente_tra_due_date($_GET, $_POST, $_SESSION));
        break;
    case 'api/richiestaRipristino':
        require_once ("./api/richiestaRipristino.php");
        echo json_encode(API_richiestaRipristino($_GET, $_POST, $_SESSION));
        break;
    case 'api/resetPassword':
        require_once ("./api/resetPassword.php");
        echo json_encode(API_resetPassword($_GET, $_POST, $_SESSION));
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint not found"]);
}
?>
