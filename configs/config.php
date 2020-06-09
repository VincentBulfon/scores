<?php
//défini le chemin vers la db, on accède à la variable serveru document root qui donne la racine du
define('DB_PATH', $_SERVER['DOCUMENT_ROOT'] . '/data/scores.sqlite');
define('TODAY', (\Carbon\Carbon::now('Europe/Brussels')->locale('fr_BE')->isoFormat('dddd DD MMMM YYYY')));
