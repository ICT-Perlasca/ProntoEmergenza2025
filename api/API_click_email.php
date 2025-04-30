<?php
    require_once "../funzioniDB.php";
    $idU = $_GET['id'];
    $data = $_GET['data'];
    $idUHash = $_GET['idUHash'];
    $dataHash = $_GET['dataHash'];
    $idHashAttuale = md5($idU);
    $dataHashAttuale = md5($data);

    if($idUHash === md5($idU) && $dataHash === $md5($data))
    {
        $dataora = new DateTime('now', new DateTimeZone('Europe/Rome'));
        $dataora->format('Y-m-d H:i:s');
        $query = "SELECT dataoraInvioEmail FROM Utenti WHERE idUtente = ? AND dataInvioEmail = ?";
        $valori = [$idU, $data];
        $tipi = ["PDO::PARAM_INT", "PDO::PARAM_STR"];
        $dataInvio = db_query($query, $valori, $tipi);
        if()
    }
    else
    {
?>
    <html>
    <head>
        <base href='./".str_repeat("../", $i)."' />
        <link href='./public/css/bootstrap.min.css' rel='stylesheet'/>
        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js'></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
    </head>
    <body>
        <div class="alert alert-danger" role="alert">Link non valido</div>
    </body>
    </html>
<?php
    }
?>