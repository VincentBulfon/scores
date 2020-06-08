<?php
function all(PDO $connection): array
{
    $teamRequest = 'SELECT * FROM teams ORDER BY name';
    //ici pas besoin de perpare et execute car on utilise la requête qu'une seule fois pour une requête utilisée de multiples fois un doit utiliser prepare and execute cela nous fait ganger du temps et des perfs sur le serveur
    $pdoSt = $connection->query($teamRequest);

    return $pdoSt->fetchAll();
}

function find(PDO $connection, string $id): stdClass
{
    $teamRequest = 'SELECT * FROM teams WHERE id = :id';
    $pdoSt = $connection->prepare($teamRequest);
    $pdoSt->execute([':id' => $id]);

    return $pdoSt->fetchAll();
}

