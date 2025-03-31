<?php
function COMP_header($user) {

    $links = $user['tipoUtente'] == 'admin' ? adminLinks() : volontarioLinks();
    
    $user['image'] = "https://fakeimg.pl/440x320/282828/eae0d0/?retina=1";

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
                    '.renderLinks($links).'
                </ul>

                <ul class="navbar-nav pl-3">
                    <li class="nav-item dropdown">
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

function renderLinks($links){
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

function adminLinks(){
    return [
        [
            "url" => "home",
            "title" => "Home"
        ],
        [
            "url" => "home",
            "title" => "Utenti",
            "sub" => [
                [
                    "url" => "utenti/agg",
                    "title" => "Aggiunta utenti"
                ]
            ]
        ]
    ];
}
function volontarioLinks(){
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
                    "url" => "utenti/agg",
                    "title" => "Aggiunta utenti"
                ]
            ]
        ]
    ];
}
?>