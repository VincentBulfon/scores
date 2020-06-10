<?php

namespace Models;

class Team extends Model
{
    function all(): array
    {
        $teamRequest = 'SELECT * FROM teams ORDER BY name';
        //ici pas besoin de perpare et execute car on utilise la requête qu'une seule fois pour une requête utilisée de multiples fois un doit utiliser prepare and execute cela nous fait ganger du temps et des perfs sur le serveur
        $pdoSt = $this->pdo->query($teamRequest);

        return $pdoSt->fetchAll();
    }

    function find(string $id): \stdClass
    {
        $teamRequest = 'SELECT * FROM teams WHERE id = :id';
        $pdoSt = $this->pdo->prepare($teamRequest);
        $pdoSt->execute([':id' => $id]);

        return $pdoSt->fetch();
    }


    function findByName(string $name)
    {
        $teamRequest = 'SELECT * FROM teams WHERE name = :name';
        $pdoSt = $this->pdo->prepare($teamRequest);
        $pdoSt = $pdoSt->execute([':name' => $name]);

        return $pdoSt->fetch();
    }


    function save(array $team)
    {
        try {
            $insertTeamRequest = 'INSERT INTO teams(`name`, `slug`) VALUES (:name, :slug)';
            $pdoSt = $this->pdo->prepare($insertTeamRequest);
            $pdoSt->execute([':name' => $team['name'], ':slug' => $team['slug']]);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}

