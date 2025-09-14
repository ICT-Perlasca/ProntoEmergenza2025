<?php
    function COMP_Footer() {
        $socials = [
            "web" => "https://www.prontoemergenza.it/",
            "email"=>"mailto:info@prontoemergenza.it",
            "contatti" => "https://www.prontoemergenza.it/contatti/",
            "servizi" => "https://www.prontoemergenza.it/servizi/",
            "facebook" => "https://www.facebook.com/prontoemergenzaorganizzazionedivolontariato/",
            "instagram" => "https://www.instagram.com/pronto_emergenza_odv/",
            "tik tok" => "https://www.tiktok.com/@prontoemergenza?_t=ZN-8vMvuRcE8vO&_r=1"
        ];

        $socialLinks = "";
        foreach ($socials as $platform => $link) {
            switch($platform){
                case 'web':
                    $iconClass="fas fa-globe";
                    break;
                case 'contatti':
                    $iconClass="fas fa-phone";
                    break;
                case 'servizi':
                    $iconClass="fas fa-briefcase-medical";
                    break;
                case 'email':
                    $iconClass="fas fa-envelope";
                    break;
                case 'facebook':
                    $iconClass="fab fa-facebook";
                    break;
                case 'instagram':
                    $iconClass="fab fa-instagram";
                    break;
                case 'tik-tok':
                    $iconClass="fab fa-tiktok";
                    break;

            }
           $socialLinks .= '<a href=' . $link . ' class="text-white me-2"  target=_blank><i class="'. $iconClass .'"></i></a>&nbsp;';
        } 
        
        return '
            <footer class="bg-dark text-white text-center py-3">
                <div class="container">
                    <p class="mb-0 text-center">
                    Pronto Emergenza - Organizzazione di Volontariato<br>
                    Loc.tà Fondi, 1, 25071 Agnosine (BS)<br>
                    Tel. 0365/826210 - Fax: 0365/1871098<br>
                    C.F. 96022920175<br>
                    WebMaster: Claudia Prati, docente Informatica "I.I.S. Perlasca", Vobarno(BS)<br>
                    con la collaborazione delle classi 5AI-5BI-5AG as 2023-2024 , 5AI-5BI as 2024-2025</p>
                    <div class="mt-2 d-flex justify-content-center gap-3 flex-wrap">'.$socialLinks.'
                    </div>
                </div>
            </footer>';
    }
?>
