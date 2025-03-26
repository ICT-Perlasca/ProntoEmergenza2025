<?php
session_start();

$_SESSION['idUtente'] = 1;
$_SESSION['nome'] = "Mario";
$_SESSION['cognome'] = "Rossi";
$_SESSION['status'] = 'volontario';
$_SESSION['tipoUtente'] = 'admin';


echo "Loggato come amministratore Mario Rossi (volontario)";