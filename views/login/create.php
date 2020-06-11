<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion à l'administration</title>
</head>
<body>
<div>
    <a href="index.php">Premier League 2020</a>
</div>
<h1>Connectez vous à l'administration</h1>
<form action="index.php" method="post">
    <div>
        <label for="email">Votre email&nbsp;:</label>
        <input type="text" id="email" name="email">
    </div>
    <?php if(isset($_SESSION['errors']['email'])): ?>
        <div>
            <p><?= $_SESSION['errors']['email'] ?></p>
        </div>
    <?php endif; ?>
    <div>
        <label for="pwd">Entrez votre mot de passe (au moins 8 lettres, 1 majuscule et 1 chiffre)&nbsp;:</label>
        <input type="text" id="pwd" name="password">
    </div>
    <?php if(isset($_SESSION['errors']['password'])): ?>
        <div>
            <p><?= $_SESSION['errors']['password'] ?></p>
        </div>
    <?php endif; ?>
    <input type="hidden" name="action" value="check">
    <input type="hidden" name="resource" value="login">
    <input type="submit" value="M'identifier">
</form>
</body>
</html>
