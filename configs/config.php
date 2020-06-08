<?php
//défini le chemin vers la db, on accède à la variable serveru document root qui donne la racine du
define('DB_PATH', $_SERVER['DOCUMENT_ROOT'].'/data/scores.sqlite');
define('TODAY', (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('M jS, Y'));
define('FILE_PATH', 'matches.csv');