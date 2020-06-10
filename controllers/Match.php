<?php

namespace Controllers;



use Models\Team;

class Match{
    function store(\PDO $pdo)
    {
        $matchModel = new \Models\Match();
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

        $matchModel->save($pdo, $match);
        header('Location: index.php');
        exit;
    }

    function create(\PDO $pdo)
    {
        $teamModel = new Team();
        $view = 'views/match/create.php';
        $teams = $teamModel->all($pdo);
        return compact('view', 'teams');
    }
}

