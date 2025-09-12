<?php
session_start();

header('Content-Type: application/json');

$route = isset($_GET['route']) ? trim($_GET['route'], "/") : '';

switch ($route) {
    case 'api/elencoComunicazioni':
        require_once ("./api/API_ElencoComunicazioni.php");
        echo json_encode(API_elencoComunicazioni($_GET, $_POST, $_SESSION));
        break;
    case 'api/segnarecomunicazioneletta':
        require_once ("./api/api_segnare_comunicazione_letta.php");
        echo json_encode(API_segnareComunicazioneLetta($_GET, $_POST, $_SESSION));
        break;
    case 'api/ElencoMezziDisponibili':
        require_once ("./api/API_ElencoMezziDisponibili.php");
        echo json_encode(API_ElencoMezziDisponibili($_GET, $_POST, $_SESSION));
        break;
    case 'api/GetMezzo':
        require_once ("./api/GetMezzo.php");
        echo json_encode(API_GetMezzo($_GET, $_POST, $_SESSION));
        break;
    case 'api/GetUtente':
        require_once ("./api/GetUtente.php");
        echo json_encode(API_GetUtente($_GET, $_POST, $_SESSION));
        break;
    case 'api/ritornaUtenti':
        require_once ("./api/API_RitornaUtenti.php");
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
    case 'api/salvaTurno':
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
    case 'api/API_ElencoCompleanni':
        require_once ("./api/API_ElencoCompleanni.php");
        echo json_encode(API_ElencoCompleanni($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_ElencoEventiPrevisti':
        require_once ("./api/API_ElencoEventiPrevisti.php");
        echo json_encode(API_ElencoEventiPrevisti($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_ElencoOreUtente':
        require_once ("./api/API_ElencoOreUtente.php");
        echo json_encode(API_ElencoOreUtente($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_ElencoOreUtenteMensile':
        require_once ("./api/API_ElencoOreUtenteMensile.php");
        echo json_encode(API_ElencoOreUtenteMensile($_GET, $_POST, $_SESSION));
        break;  
    case 'api/API_ElencoTurniAnnoPrecedente':
        require_once ("./api/API_ElencoTurniAnnoPrecedente.php");
        echo json_encode(API_ElencoTurniAnnoPrecedente($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_ElencoTurniConvalidatiMensile':
        require_once ("./api/API_ElencoTurniConvalidatiMensile.php");
        echo json_encode(API_ElencoTurniConvalidatiMensile($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_ElencoTurniConvalidatiMensileUtente':
        require_once ("./api/API_ElencoTurniConvalidatiMensileUtente.php");
        echo json_encode(API_ElencoTurniConvalidatiMensileUtente($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_ElencoTurniConvalidatiUtente':
        require_once ("./api/API_ElencoTurniConvalidatiUtente.php");
        echo json_encode(API_ElencoTurniConvalidatiUtente($_GET, $_POST, $_SESSION));
        break;
    case 'api/API_GetMesi':
        require_once ("./api/API_GetMesi.php");
        echo json_encode(API_GetMesi($_GET, $_POST, $_SESSION));
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
