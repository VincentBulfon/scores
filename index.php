<?php

use function Team\all as allTeams;
use function Match\allWithTeams as allMatchesWithTeams;
use function Match\allWithTeamsGrouped as allWithTeamsGrouped;
use function Match\save as saveMatch;

require('vendor/autoload.php');

require('./configs/config.php');
require('./utils/dbaccess.php');
require('models/team.php');
require('models/match.php');
require('utils/standings.php');

$pdo = getConnection();


/*
 * tt les requêtes sont caractérisées par :
 * -méthode get ou post
 * -action [CRUD]
 * -ressource [team/match]
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['resource'])) {
        if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {
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

            saveMatch($pdo, $match);
            header('Location: index.php');
            exit;
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    //la première fois qu'on arrive sur le serveur c'est une requête GET qui est evoyée on doit donc vérifier ce résultat
    if (!isset($_GET['action']) || !isset($_GET['resource'])) {
        $standings = [];
        $teams = allTeams($pdo);
        $matches = allWithTeamsGrouped(allMatchesWithTeams($pdo));


        foreach ($matches as $match) {
            $homeTeam = $match->home_team;
            $awayTeam = $match->away_team;
            //si la clé "hometeam" n'existe pas dans le tableau des "standings" (classement) on créer un tableau vide qu'on assigne a la clé hometeam dans standings
            if (!array_key_exists($homeTeam, $standings)) {
                $standings[$homeTeam] = getEmptyStatsArray();
            }
            //la même chose mais avec away team
            if (!array_key_exists($awayTeam, $standings)) {
                $standings[$awayTeam] = getEmptyStatsArray();
            }
            //on ajoute un match joué à "hometeam"et un a "awayteam"
            $standings[$homeTeam]['games']++;
            $standings[$awayTeam]['games']++;

            //si égalité on ajoute un point pour chaque équipe, ainsi qu'une égalité au compteur de chacune d'entre elles
            if ($match->home_team_goals === $match->away_team_goals) {
                $standings[$homeTeam]['points']++;
                $standings[$awayTeam]['points']++;
                $standings[$homeTeam]['draws']++;
                $standings[$awayTeam]['draws']++;
                //si hometeam à gagné on ajoute un point à celle ci ainsi qu'une victoire et on ajoute une défaite à la team adverse
            } elseif ($match->home_team_goals > $match->away_team_goals) {
                $standings[$homeTeam]['points'] += 3;
                $standings[$homeTeam]['wins']++;
                $standings[$awayTeam]['losses']++;
                //opposé du cas précédent
            } else {
                $standings[$awayTeam]['points'] += 3;
                $standings[$awayTeam]['wins']++;
                $standings[$homeTeam]['losses']++;
            }
            //on ajoute les goals à hometeam et awayteam pour garder le calssement à jour
            $standings[$homeTeam]['GF'] += $match->home_team_goals;
            $standings[$homeTeam]['GA'] += $match->away_team_goals;
            $standings[$awayTeam]['GF'] += $match->away_team_goals;
            $standings[$awayTeam]['GA'] += $match->home_team_goals;
            $standings[$homeTeam]['GD'] = $standings[$homeTeam]['GF'] - $standings[$homeTeam]['GA'];
            $standings[$awayTeam]['GD'] = $standings[$awayTeam]['GF'] - $standings[$awayTeam]['GA'];


        }


        uasort($standings, function ($a, $b) {
            if ($a['points'] === $b['points']) {
                return 0;
            }
            return $a['points'] > $b['points'] ? -1 : 1;
        });
    } else {
        header('Location: index.php');
        //le exit est très important ça après une redirection le code continue de s'exécuter normalement
        exit();
    }
} else {
    header('Location: index.php');
    //le exit est très important ça après une redirection le code continue de s'exécuter normalement
    exit();
}


require('views/scores.view.php');
