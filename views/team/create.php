<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create</title>
</head>
<body>
<div>
    <a href="index.php">Premier League 2020</a>
</div>
<h1>Création d'une équipe</h1>
<form action="index.php" method="post">
    <div>
        <label for="team">Nom de l'équipe :</label>
        <input type="text" name="name" id="team">
    </div>
    <div>
        <label for="slug">Slug (3 lettres ni plus ni moins)</label>
        <input type="text" name="slug" id="slug">
    </div>
    <input type="hidden" name="action" value="store" id="">
    <input type="hidden" name="resource" value="team" id="">
    <input type="submit" name="enregister cette équipe">
</form>
</body>
</html>