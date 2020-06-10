<?php

namespace Controllers\Match;

use function Models\Match\save;

require('models/match.php');
require('models/team.php');

function store(\PDO $pdo)
{

    $matchDate = $_POST['match-date'];
    $homeTeam = $_POST['home-team'];
    $awayTeam = $_POST['away-team'];
    $homeTeamGoals = $_POST['home-team-goals'];
    $awayTeamGoals = $_POST['away-team-goals'];

    $match = [
        'date' => $matchDate,
        'home-team' => $homeTeam,
        'home-team-goals' => $homeTeamGoals,
        'away-team-goals' => $awayTeamGoals,
        'away-team' => $awayTeam
    ];

    save($pdo, $match);
    header('Location: index.php');
    exit;
}

function create(\PDO $pdo)
{
    $view = 'views/match/create.php';
    $teams = \Models\Team\all($pdo);
    return compact('view', 'teams');
}