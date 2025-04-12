<?php
function COMP_header($user) {

    $links = $user['tipoUtente'] == 'admin' ? _adminLinks() : _volontarioLinks();
    
    return '
        <link rel="stylesheet" href="./public/css/header.css" type="text/css"/>
        <script type="text/javascript" src="./public/js/header.js"></script>
    
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="navbar-brand">
                <img src="./public/images/logo-ambulanza.png" class=""/>
            </div>
            <button 
                class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" 
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    '._renderLinks($links).'
                </ul>

                <ul class="navbar-nav pl-md-3">
                    <li class="nav-item dropdown d-flex justify-content-end">
                        <div class="nav-link dropdown-toggle d-flex align-items-center" 
                            id="userDropdown" 
                            role="button" data-bs-toggle="dropdown"
                        >
                            <span class="mx-2">
                                '.$user['cognome'].' '.$user['nome'].'
                            </span>
                            <img src="'.$user['image'].'" alt="Avatar" class="rounded-circle" width="40" height="40">
                        </div>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Profilo</a></li>
                            <li><a class="dropdown-item" href="#">Impostazioni</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>';
}

function _renderLinks($links){
    $html = "";

    foreach ($links as $k => $l){
        if(isset($l['sub'])){
            $html .= '<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" 
                    href="'.$l['url'].'" 
                    id="headerDropdown'.$k.'" 
                    role="button" 
                    data-bs-toggle="dropdown"
                >
                    '.$l['title'].'
                </a>
                <div class="dropdown-menu" aria-labelledby="headerDropdown'.$k.'">';

                foreach ($l['sub'] as $s){
                    $html .= '<a class="dropdown-item" href="'.$s['url'].'">'.$s['title'].'</a>';
                }
            $html .= '
                </div>
            </li>';
        }else{
            $html .= '<li class="nav-item">
                <a class="nav-link" href="'.$l['url'].'">'.$l['title'].'</a>
            </li>';
        }
    }
    return $html;
}

function _adminLinks(){
    return [
        [
            "url" => "home",
            "title" => "Home"
        ],
        [
            "url" => "bacheca",
            "title" => "Bacheca",
            "sub" => [
                [
                    "url" => "bacheca/elenco",
                    "title" => "Elenco comunicazioni"
                ],
                [
                    "url" => "bacheca/aggiunta",
                    "title" => "Aggiunta comunicazione"
                ]
            ]
        ],
        [
            "url" => "turni",
            "title" => "Turni",
            "sub" => [
                [
                    "url" => "turni/utente",
                    "title" => "Elenco turni di un utente"
                ],
                [
                    "url" => "turni/visualizza-disponibilita",
                    "title" => "Visualizza disponibilità"
                ],
                [
                    "url" => "turni/inserimento",
                    "title" => "Inserimento turno"
                ],
                [
                    "url" => "turni/scoperti",
                    "title" => "Turni scoperti"
                ],
                [
                    "url" => "turni/fissi",
                    "title" => "Turni fissi"
                ],
                [
                    "url" => "turni/convalida",
                    "title" => "Convalida turni"
                ],
                [
                    "url" => "turni/mese",
                    "title" => "Scelta mese"
                ],
                [
                    "url" => "turni/disponibilita",
                    "title" => "Inserimento disponibilità"
                ]
            ]
        ],
        [
            "url" => "utenti",
            "title" => "Utenti",
            "sub" => [
                [
                    "url" => "utenti/aggiunta",
                    "title" => "Aggiunta utente"
                ],
                [
                    "url" => "utenti/vidimazione",
                    "title" => "Vidimazione utente"
                ],
                [
                    "url" => "utenti/assenze",
                    "title" => "Inserimento assenze"
                ],
                [
                    "url" => "utenti/ore",
                    "title" => "Conteggio ore"
                ],
                [
                    "url" => "utenti/permessi",
                    "title" => "Visualizzazione permessi"
                ],
                [
                    "url" => "utenti/straordinarie",
                    "title" => "Visualizzazione straordinarie"
                ],
                [
                    "url" => "utenti/ore-minime",
                    "title" => "Modifica ore minime"
                ]
            ]
        ],
        [
            "url" => "report",
            "title" => "Reportistica",
            "sub" => [
                [
                    "url" => "report/turni-utenti",
                    "title" => "Turni utente"
                ],
                [
                    "url" => "report/turni-convalidati",
                    "title" => "Turni convalidati"
                ],
                [
                    "url" => "report/turni",
                    "title" => "Storico turni"
                ],
                [
                    "url" => "report/compleanni",
                    "title" => "Compleanni nel mese"
                ],
                [
                    "url" => "report/eventi",
                    "title" => "Eventi"
                ]
            ]
        ],
        [
            "url" => "assistenza",
            "title" => "Assistenza",
            "sub" => [
                [
                    "url" => "assistenza/aggiunta",
                    "title" => "Nuovo evento"
                ],
                [
                    "url" => "assistenza/aggiunta-personale",
                    "title" => "Nuovo evento personale"
                ]
            ]
        ],
        [
            "url" => "mezzi",
            "title" => "Mezzi",
            "sub" => [
                [
                    "url" => "mezzi/aggiunta",
                    "title" => "Nuovo mezzi"
                ],
                [
                    "url" => "mezzi/elenco",
                    "title" => "Elenco mezzi"
                ],
                [
                    "url" => "mezzi/storico",
                    "title" => "Storico mezzi"
                ]
            ]
        ]
    ];
}
function _volontarioLinks(){
    return [
        [
            "url" => "home",
            "title" => "Home"
        ],
        [
            "url" => "bacheca",
            "title" => "Bacheca",
            "sub" => [
                [
                    "url" => "bacheca/elenco",
                    "title" => "Elenco comunicazioni"
                ],
                [
                    "url" => "bacheca/to-admin",
                    "title" => "Invio comunicazione all'admin"
                ]
            ]
        ],
        [
            "url" => "turni",
            "title" => "Turni",
            "sub" => [
                [
                    "url" => "turni/elenco",
                    "title" => "Elenco turni"
                ],
                [
                    "url" => "turni/inserimento",
                    "title" => "Inserimento turno"
                ],
                [
                    "url" => "turni/fissi",
                    "title" => "Turni fissi"
                ],
                [
                    "url" => "turni/disponibilita",
                    "title" => "Inserimento disponibilità"
                ]
            ]
        ]
    ];
}
?>