<?php

namespace Controllers;


use Models\Match;
use Models\Team;


require('./utils/standings.php');

class Dashboard
{
    public function index()
    {
        $matchModel = new Match();
        $teamModel = new Team();
        $standings = [];
        $teams = $teamModel->all();
        $matches = $matchModel->allWithTeamsGrouped($matchModel->allWithTeams());
        $view = 'views/dashboard.php';

        foreach ($matches as $match) {
            $homeTeam = $match->home_team;
            $awayTeam = $match->away_team;
            //si la clé "hometeam" n'existe pas dans le tableau des "standings" (classement) on créer un tableau vide qu'on assigne a la clé hometeam dans standings
            if (!array_key_exists($homeTeam, $standings)) {
                $standings[$homeTeam] = getEmptyStatsArray();
                $standings[$homeTeam]['logo'] = $match->home_team_logo;
            }
            //la même chose mais avec away team
            if (!array_key_exists($awayTeam, $standings)) {
                $standings[$awayTeam] = getEmptyStatsArray();
                    $standings[$awayTeam]['logo'] = $match->away_team_logo;
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

        //compact créer un tableau en associant les variables dans son scope au clé du même noms celle définie dans la fonction.
        return compact('standings', 'matches', 'teams', 'view');
    }
}

