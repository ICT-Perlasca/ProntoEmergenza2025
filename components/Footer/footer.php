<?php
    function COMP_Footer() {
        $socials = [
            "sito" => "https://www.prontoemergenza.it/",
            "contatti" => "https://www.prontoemergenza.it/contatti/",
            "servizi" => "https://www.prontoemergenza.it/servizi/",
            "facebook" => "https://www.facebook.com/prontoemergenzaorganizzazionedivolontariato/",
            "instagram" => "https://www.instagram.com/pronto_emergenza_odv/",
            "tik tok" => "https://www.tiktok.com/@prontoemergenza?_t=ZN-8vMvuRcE8vO&_r=1"
        ];

        $socialLinks = "";
        foreach ($socials as $platform => $link) {
            $socialLinks .= '<a href="' . $link . '" class="text-white me-2"><i class="fab fa-' . $platform . '"></i></a>';
        }

        return ' 
            <footer class="bg-dark text-white text-center py-3 mt-5">
                <div class="container">
                    <p class="mb-0">Pronto emergenza</p>
                    <div class="mt-2 d-flex justify-content-center gap-3 flex-wrap">
                        <?php echo $socialLinks; ?>
                    </div>
                </div>
            </footer>';
    }
?>
