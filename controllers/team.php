<?php

namespace Controllers\Team;

use function Models\Team\save;

require('models/team.php');

//add link form to add new team from match form #TODO
function store(\PDO $pdo)
{
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    //ajouter de la validation #TODO
    //compact créer un tableau en associant les variables dans son scope au clé du même noms celle définie dans la fonction.
    $team = compact('name', 'slug');

    save($pdo, $team);
    header('Location: index.php');
    exit;
}
