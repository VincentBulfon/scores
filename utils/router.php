<?php

$routes = require ('configs/routes.php');

$method = $_SERVER['REQUEST_METHOD']; //GET ou POST
$methodName = '_' . $method; //_GET ou _POST
//ici on souhaite accéder à la varible $_POST ou $_GET pour ce faire un peut utiliser la valeur d'une variable comme nom de variable. Ce qui veut dire que dans le cas présent que si la varible methodName vaut '_GET' ou '_POST' elle sera équivalente à $_GET ou $_POST à son appel dans $action
$action = $$methodName['action'] ?? '';
$resource = $$methodName['resource'] ?? '';

//use permet de donner accès au varibles hors du scope d'une fonction
$route = array_filter($routes, function ($r) use ($method, $action, $resource) {
    return $r['method'] === $method && $r['action'] === $action && $r['resource'] === $resource;
});

if(!$route){
    header('Location: index.php');
    exit();
}

return reset($route);