<?php
session_start();

require('./vendor/autoload.php');

require('./configs/config.php');


$route = require('utils/router.php');

//fait office de use déclaré en inline
$controllerName = 'Controllers\\' . $route['controller'];

$controller = new $controllerName;


$data = call_user_func([$controller, $route['callback']]);
//extrait les données d'un tableau et donne comme nom de variable les clé du tableau
extract($data, EXTR_OVERWRITE);

require($view);

$_SESSION['errors'] = [];
$_SESSION['old'] = [];