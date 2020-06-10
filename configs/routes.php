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
        'controller' => 'Page',
        'callback' => 'dashboard'
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

    ]
];