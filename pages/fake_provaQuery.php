<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>prova query select, insert, update delete</title>
</head>
<body>
    <h2>Query di prova</h2>
<?php
require_once("../funzioniDB.php");
$strsql="insert into comunicazioni (dataEmissione, titolo, testo, dataScadenza,idTipo, idUtente) values ('2025-06-16','prova comunicazione','questa è ua comunicazione di prova','2025-10-10',2, 1)";
echo"<br>query da realizzare:<br>$strsql<br>";
$ris=db_Query($strsql,[],[]);
echo "<br> risultato dalla query<br>";
print_r($ris);

$strsql="insert into utenticomunicazioni(idUtente,idComunicazione) values(3,".$ris['lastId'].")";

echo"<br>query da realizzare:<br>$strsql<br>";
$ris=db_Query($strsql,[],[]);
echo "<br> risultato dalla query<br>";
print_r($ris);

?>
</body>
</html>
