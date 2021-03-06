<?php

return [
    [
        'method' => 'POST',
        'action' => 'store',
        'resource' => 'match',
        'controller' => 'Match',
        //callback va recupérer la fonction dans le bon namespace
        'callback' => 'store'
    ],
    [
        'method' => 'POST',
        'action' => 'store',
        'resource' => 'team',
        'controller' => 'Team',
        'callback' => 'store'
    ],
    [
        'method' => 'GET',
        'action' => '',
        'resource' => '',
        'controller' => 'Dashboard',
        'callback' => 'index'
    ],
    [
        'method' => 'GET',
        'action' => 'create',
        'resource' => 'team',
        'controller' => 'Team',
        'callback' => 'create'

    ],
    [
        'method' => 'GET',
        'action' => 'create',
        'resource' => 'match',
        'controller'=>'Match',
        'callback' => 'create'

    ],
    [
        'method'=>'GET',
        'action'=>'view',
        'resource'=>'login-form',
        'controller'=>'Login',
        'callback'=>'create'
    ],
    [
        'method'=>'GET',
        'action'=>'create',
        'resource'=>'register-form',
        'controller'=>'Register',
        'callback'=>'create'
    ],
    [
        'method'=>'POST',
        'action'=>'check',
        'resource'=>'login',
        'controller'=>'Login',
        'callback'=>'check'
    ],
    [
        'method'=>'POST',
        'action'=>'logout',
        'resource'=>'login',
        'controller'=>'Login',
        'callback'=>'delete'
    ],
    [
        'method'=>'POST',
        'action'=>'store',
        'resource'=>'user',
        'controller'=>'Register',
        'callback'=>'store'
    ]
];