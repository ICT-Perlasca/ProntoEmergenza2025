<?php
session_start();

$_SESSION['idUtente'] = 1;
$_SESSION['nome'] = "Mario";
$_SESSION['cognome'] = "Rossi";
$_SESSION['status'] = 'volontario';
$_SESSION['tipoUtente'] = 'user';
$_SESSION['image'] = "https://fakeimg.pl/440x320/282828/eae0d0/?retina=1";

echo "Loggato come utente Mario Rossi (volontario)";