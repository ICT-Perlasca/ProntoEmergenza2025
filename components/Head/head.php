<?php

function COMP_head()
    {
        if (isset($_GET['route']))
            $i = sizeof(explode("/", $_GET['route'])) - 1;
        else
            $i=0;
            $stringa = "<head>
                <base href='./".str_repeat("../", $i)."' />
                <link href='./public/css/bootstrap.min.css' rel='stylesheet'/>
                <link rel='icon' type='image/x-icon' href='/prontoemergenza2025/public/images/favicon.png'>
                <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js'></script>
                <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js'></script>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
           
                </head>";
  
        return $stringa;
    }
?>