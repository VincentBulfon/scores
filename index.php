<?php
session_start();

require('./vendor/autoload.php');

require('./configs/config.php');
require('./utils/dbaccess.php');



$route = require('utils/router.php');

require('controllers/' . $route['controller-file'] . '.php');

$data = call_user_func($route['callback'], getConnection());
//extrait les données d'un tableau et donne comme nom de variable les clé du tableau
extract($data, EXTR_OVERWRITE);

require($view);

$_SESSION['errors'] = [];
$_SESSION['old'] = [];