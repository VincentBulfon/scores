<?php

namespace Controllers;



use Models\Team;

class Match{
    static function store()
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

        $matchModel->save($match);
        header('Location: index.php');
        exit;
    }

    static function create()
    {
        $teamModel = new Team();
        $view = 'views/match/create.php';
        $teams = $teamModel->all();
        return compact('view', 'teams');
    }
}

