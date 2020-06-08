<?php

namespace Match;

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
    $matchesInfosRequest = 'SELECT * FROM matches JOIN participations p on matches.id = p.match_id JOIN teams t on p.team_id = t.id ORDER BY match_id';
    $pdoSt = $connection->query($matchesInfosRequest);
}