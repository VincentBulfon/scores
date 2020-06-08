<?php

namespace Match;

use Cassandra\Date;

function all(\PDO $connection): array
{
    $matchRequest = 'SELECT * FROM matches ORDER BY date';
    $pdoSt = $connection->query($matchRequest);

    return $pdoSt->fetchAll();
}

function find(\PDO $connection): \stdClass
{
    $matchRequest = 'SELECT FROM matches WHERE id = :id';
    $pdoSt = $connection->prepare($matchRequest);
    $pdoSt = $pdoSt->execute(['id' => $id]);

    return $pdoSt->fetch();
}

function allWithTeams(\PDO $connection): array
{
    $matchesInfosRequest = 'SELECT * FROM matches JOIN participations p on matches.id = p.match_id JOIN teams t on p.team_id = t.id ORDER BY match_id, is_home';
    $pdoSt = $connection->query($matchesInfosRequest);

    return $pdoSt->fetchAll();
}

function allWithTeamsGrouped(array $allWithTeams): array
{
    $matchesWithTeams = [];
    $m = null;
    foreach ($allWithTeams as $match) {
        if(!$match->is_home){
            $m = new \stdClass();
            $d = new \DateTime();
            //les parenthèses autour de int, sert à interpréter la valeur de match-date comme un entier
            $d->setTimestamp(((int) $match->date) / 1000);
            $m->match_date = $d;
            $m->away_team = $match->name;
            $m->away_team_goals = $match->goals;
        }else{
            $m->home_team = $match->name;
            $m->home_team_goals = $match->goals;
            $matchesWithTeams[] = $m;
        }
    }

    return $matchesWithTeams;
}