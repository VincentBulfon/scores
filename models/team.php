<?php

namespace Models\Team;

function all(\PDO $connection): array
{
    $teamRequest = 'SELECT * FROM teams ORDER BY name';
    //ici pas besoin de perpare et execute car on utilise la requête qu'une seule fois pour une requête utilisée de multiples fois un doit utiliser prepare and execute cela nous fait ganger du temps et des perfs sur le serveur
    $pdoSt = $connection->query($teamRequest);

    return $pdoSt->fetchAll();
}

function find(\PDO $connection, string $id): \stdClass
{
    $teamRequest = 'SELECT * FROM teams WHERE id = :id';
    $pdoSt = $connection->prepare($teamRequest);
    $pdoSt->execute([':id' => $id]);

    return $pdoSt->fetch();
}


function findByName(\PDO $connection, string $name)
{
    var_dump($name);
    die();
    $teamRequest = 'SELECT * FROM teams WHERE name = :name';
    $pdoSt = $connection->prepare($teamRequest);
    $pdoSt = $pdoSt->execute([':name' => $name]);

    return $pdoSt->fetch();
}


function save(\PDO $connection, array $team): bool
{
    try {
        $insertTeamRequest = 'INSERT INTO teams(`name`, `slug`) VALUES (:name, :slug)';
        $pdoSt = $connection->prepare($insertTeamRequest);
        $pdoSt->execute([':name' => $team['name'], ':slug' => $team['slug']]);
    }catch(\PDOException $e){
        die($e->getMessage());
    }
}