<?php
/*
select U.cognome, U.nome, R.nome, R.descrizione
from (utenti as U inner join utentiruoli as UR on UR.idUtente=U.idUtente)inner join ruoli as R on UR.idRuolo=R.idRuolo
where U.nome=?
order by U.cognome,U.nome
 

insert into tipicomunicazione (nome) values ("Compleanno")
INSERT INTO `mezzi` (`idMezzo`, `modello`, `targa`, `dataImmatricolazione`, `dataRevisione`, `scadAssicurazione`, `scadRevisione`, `scadBollo`, `tipoMezzo`) VALUES (NULL, 'Kuga', 'rt444EE', '2024-09-09', NULL, '2025-04-15', '2026-04-15', '2025-08-13', 'macchina');
update utenti set Via="G. Perlsca", numero="17/c" where cognome=? and nome=?

delete from mezzi where idMezzo=?
*/
include "funzioniDB.php";
//$strSql="select U.cognome, U.nome, R.nome as Nomeruolo, R.descrizione from (utenti as U inner join utentiruoli as UR on UR.idUtente=U.idUtente)inner join ruoli as R on UR.idRuolo=R.idRuolo  where U.nome=? order by U.cognome,U.nome";
//$strSql="insert into tipicomunicazione (nome) values ('Compleanno')";
//$strSql="update utenti set Via='G. Perlsca', numero='17/c' where cognome=? and nome=?";
$strSql="delete from mezzi where idMezzo=?";

$vet= api_query($strSql,[11],[PDO::PARAM_INT]);
print_r($vet);
echo "<br><br>".json_encode($vet);

?>