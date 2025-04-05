<?php
session_start();

header('Content-Type: application/json');

$route = isset($_GET['route']) ? trim($_GET['route'], "/") : '';

switch ($route) {
    case 'api/elencoComunicazioni':
        require_once ("./api/elencoComunicazioni.php");
        echo json_encode(API_elencoComunicazioni($_GET, $_POST, $_SESSION));
        break;
    case 'api/ElencoMezziDisponibili':
            require_once ("./api/ElencoMezziDisponibili.php");
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
    case 'api/RitornaUtenti':
        require_once ("./api/RitornaUtenti.php");
        echo json_encode(API_RitornaUtenti($_GET, $_POST, $_SESSION));
        break;            

    default:
        http_response_code(404);
        echo json_encode(["error" => "Endpoint not found"]);
}
?>
