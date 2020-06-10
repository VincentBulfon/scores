<?php

namespace Models;

class Match
{
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
            if (!$match->is_home) {
                $m = new \stdClass();
                $d = new \DateTime();
                //les parenthèses autour de int, sert à interpréter la valeur de match-date comme un entier
                $d->setTimestamp(((int)$match->date) / 1000);
                $m->match_date = $d;
                $m->away_team = $match->name;
                $m->away_team_goals = $match->goals;
            } else {
                $m->home_team = $match->name;
                $m->home_team_goals = $match->goals;
                $matchesWithTeams[] = $m;
            }
        }

        return $matchesWithTeams;
    }

    function save(\PDO $connection, array $match)
    {
        $insertMatchRequest = 'INSERT INTO matches(`date`, `slug`) VALUES (:date, :slug)';
        $pdoSt = $connection->prepare($insertMatchRequest);
        $pdoSt = $pdoSt->execute([':date' => $match['date'], ':slug' => '']);
        $id = $connection->lastInsertId();
        $insertParticipationRequest = 'INSERT INTO participations(`match_id`, `team_id`, `goals`, `is_home`) VALUES (:match_id, :team_id, :goals, :is_home)';
        $pdoSt = $connection->prepare($insertParticipationRequest);
        var_dump($match);
        $pdoSt->execute([
            ':match_id' => $id,
            ':team_id' => $match['home-team'],
            ':goals' => $match['home-team-goals'],
            ':is_home' => 1
        ]);
        $pdoSt->execute([
            ':match_id' => $id,
            ':team_id' => $match['away-team'],
            ':goals' => $match['away-team-goals'],
            ':is_home' => 0
        ]);

    }
}