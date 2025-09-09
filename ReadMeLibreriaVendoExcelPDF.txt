ProntoEmergenza2025-master/
	components/
		SimpleComponent/
			COMP_DataToExcel.php 
	pages/
		test_excel.php
	composer.json
	vendor  



installazione librerie composer

questi passaggi non sono tutti necessari perché alcuni servono solo per scaricare e gestire i vari file e librerie che saranno gestite dal server

scaricare il setup di composer
aprirlo e configurarlo:
	bisogna dirgli di utulizzare il php.exe di xampp (solitamente viene rilevato automaticamente)

finita la configurazione bisogna andare sulla cartella del progetto aprire il cmd e creare il composer.json attraverso il comando : composer init

(-------------------------------------------esempio di configurazione:--------------------------------------------------
C:\xampp\htdocs\progetti\ProntoEmergenza2025-master>composer init

  Welcome to the Composer config generator

This command will guide you through creating your composer.json config.

Package name (<vendor>/<name>) [utente/pronto-emergenza2025-master]: TheRealGava/pronto-emergenza2025
The package name TheRealGava/pronto-emergenza2025 is invalid, it should be lowercase and have a vendor name, a forward slash, and a package name, matching: [a-z0-9_.-]+/[a-z0-9_.-]+
Package name (<vendor>/<name>) [utente/pronto-emergenza2025-master]: therealgava/pronto-emergenza2025
Description []: Sistema di gestione emergenze per il progetto 2025
Author [n to skip]: Leonardo Gavarini <leogavarini@gmail.com>
Minimum Stability []: beta
Package Type (e.g. library, project, metapackage, composer-plugin) []: project
License []:

Define your dependencies.

Would you like to define your dependencies (require) interactively [yes]? no
Would you like to define your dev dependencies (require-dev) interactively [yes]? no
Add PSR-4 autoload mapping? Maps namespace "Therealgava\ProntoEmergenza2025" to the entered relative path. [src/, n to skip]: n

{
    "name": "therealgava/pronto-emergenza2025",
    "description": "Sistema di gestione emergenze per il progetto 2025",
    "type": "project",
    "authors": [
        {
            "name": "Leonardo Gavarini",
            "email": "leogavarini@gmail.com"
        }
    ],
    "minimum-stability": "beta",
    "require": {}
}

Do you confirm generation [yes]? yes
-----------------------------------------------------------------------------------------------------------------------------)

finita la configurazione del json per evitare errori prima di scaricare le librerie bisogna molto probabilmente andare nel file php.ini e andare sulla voce ;exstension=zip e togliere il ";" per abilitarlo 

caricare le librerie necessarie:
composer require phpoffice/phpspreadsheet

scaricate le librerie verrà creato una cartella vendor contenente tutte le librerie e le dipendenze e verrà fatto un update del file composer.json 

per utilizzare le librerie bastera utilizzare la seguente intestazione all'inizio del file 

<?php
require 'vendor/autoload.php';

 

        