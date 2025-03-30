<?php
function COMP_header($user) {

    $links = [
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


            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>


<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
            role="button" data-bs-toggle="dropdown">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>


                </ul>
            </div>
        </nav> 
    ';
}
?>