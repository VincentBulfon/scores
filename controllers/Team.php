<?php

namespace Controllers;

use Intervention\Image\Exception\NotWritableException;
use Intervention\Image\ImageManagerStatic;
use Models\Model;
use function Models\Team\save;

class Team extends Model
{
    function create(): array
    {
        $view = './views/team/create.php';

        return compact('view');
    }

    //add link form to add new team from match form #TODO
    function store()
    {
        //Début de la validation
        if (
            !isset($_FILES['logo']['error']) ||
            is_array($_FILES['logo']['error'])
        ) {
            $_SESSION['errors']['logo'] = 'Tentavie d‘attaque, entrez un fichier valide';
            header('Location: index.php?resource=team?action=create');
            exit();
        }

        switch ($_FILES['logo']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                $_SESSION['errors']['logo'] = 'Aucun fichers envoyé';
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $_SESSION['errors']['logo'] = 'La taille maximale de fichier est dépassée';
                break;
            default:
                $_SESSION['errors']['logo'] = 'Erreur inconnue';
        }

        if ($_FILES['logo']['size'] > 32000000) {
            $_SESSION['errors']['logo'] = 'La taille maximale de fichier est dépassée';
        }

        //empty(trim($_POST['name'])) peut être remplacé par trim($_POST['name']) === ''
        if (!isset($_POST['name']) || empty(trim($_POST['name']))) {
            $_SESSION['errors']['name'] = 'Vous devez entrez un nom pour une équipe.';
        }
        if (!isset($_POST['slug']) || empty(trim($_POST['name']))) {
            $_SESSION['errors']['slug'] = 'Vous devez entrez un slug pour une équipe.';
        } elseif (strlen($_POST['slug']) != 3) {
            $_SESSION['errors']['slug'] = 'Vous devez entrez un slug de 3 caractères exactement';
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($_FILES['logo']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
            $_SESSION['errors']['logo'] = 'Le fichier fourni nest pas du type attendu';
        }

        $full_file_path = './assets/images/full/';
        $thumbs_file_path = './assets/images/thumbs/';
        $file_name = sprintf('%s.%s',
            sha1_file($_FILES['logo']['tmp_name']),
            $ext
        );

        ImageManagerStatic::configure();
        $image = ImageManagerStatic::make($_FILES['logo']['tmp_name']);

        if ($image->width() >= 400 &&
            $image->width() <= 1600 &&
            $image->width() >= 400 &&
            $image->width() <= 1600) {


            $thumb = ImageManagerStatic::make($_FILES['logo']['tmp_name']);

            $image->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $thumb->resize(60, 60, function ($constraint) {
                $constraint->aspectRatio();
            });

            try {
                $image->save($full_file_path . $file_name);
                $thumb->save($thumbs_file_path . $file_name);
            } catch (NotWritableException $e) {
                $_SESSION['errors']['logo'] = 'Le fichier n‘a pas pu être enregistré sur le serveur. Contacter l‘administrateur';
                header('Location: index.php?resource=team?action=create');

                exit();
            }

        } else {
            $_SESSION['errors']['logo'] = 'Le fichier fourni ne respecte pas les contraintes de tailles';
        }

        echo 'File is uploaded successfully.';

        $name = $_POST['name'];
        $slug = $_POST['slug'];
        //fin de la validation
        if (!$_SESSION['errors']) {
            //ajouter de la validation #TODO
            //compact créer un tableau en associant les variables dans son scope au clé du même noms celle définie dans la fonction.
            $teamModel = new \Models\Team();
            $team = compact('name', 'slug', 'file_name');
            $teamModel->save($team);
            header('Location: index.php');
            exit;
        }
        $_SESSION['old']['name'] = $_POST['name'];
        $_SESSION['old']['slug'] = $_POST['slug'];
        header('Location: index.php?action=create&resource=team');
        exit;
    }
}
