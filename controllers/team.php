<?php

namespace Controllers\Team;

use function Models\Team\save as saveTeam;

function store(\PDO $pdo)
{
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    //ajouter de la validation #TODO
    $team = compact('name', 'slug');

    saveTeam($pdo, $team);
    header('Location: index.php');
    exit;
}
