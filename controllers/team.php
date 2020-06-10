<?php

namespace Controllers\Team;

use function Models\Team\save;

require('models/team.php');

//add link form to add new team from match form #TODO
function store(\PDO $pdo)
{
    //Début de la validation
    //empty(trim($_POST['name'])) peut être remplacé par trim($_POST['name']) === ''
    if (!isset($_POST['name']) || empty(trim($_POST['name']))) {
        $_SESSION['errors']['name'] = 'Vous devez entrez un nom pour une équipe.';
    }
    if (!isset($_POST['slug']) || empty(trim($_POST['name']))) {
        $_SESSION['errors']['slug'] = 'Vous devez entrez un slug pour une équipe.';
    } elseif (strlen($_POST['slug']) != 3) {
        $_SESSION['errors']['slug'] = 'Vous devez entrez un slug de 3 caractères exactement';
    }
    //fin de la validation
    if (!$_SESSION['errors']) {
        $name = $_POST['name'];
        $slug = $_POST['slug'];
        //ajouter de la validation #TODO
        //compact créer un tableau en associant les variables dans son scope au clé du même noms celle définie dans la fonction.
        $team = compact('name', 'slug');
        save($pdo, $team);
        header('Location: index.php');
        exit;
    }
    $_SESSION['old']['name'] = $_POST['name'];
    $_SESSION['old']['slug'] = $_POST['slug'];
    header('Location: index.php?action=create&resource=team');
    exit;
}


function create(): array
{
    $view = './views/team/create.php';

    return compact('view');
}