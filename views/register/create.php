<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Créer un compte d'administration</title>
</head>
<body>
<div>
    <a href="index.php">Premier League 2020</a>
</div>
<h1>Créer un compte d'administration</h1>
<form action="index.php" method="post">
    <div>
        <label for="email">Votre email&nbsp;:</label>
        <input type="text" id="email" name="email">
    </div>
    <div>
        <label for="name">Votre nom&nbsp;:</label>
        <input type="text" id="name" name="name">
    </div>
    <?php if(isset($_SESSION['errors']['name'])): ?>
        <div>
            <p><?= $_SESSION['errors']['name'] ?></p>
        </div>
    <?php endif; ?>
    <div>
        <label for="pwd">Créer votre mot de passe (au moins 8 lettres, 1 majuscule et 1 chiffre)&nbsp;:</label>
        <input type="password" id="pwd" name="password">
    </div>
    <div>
        <label for="confirm_pwd">Confirmez votre mot de passe&nbsp;:</label>
        <input type="password" id="confirm_pwd" name="confirm_password">
    </div>
    <?php if(isset($_SESSION['errors']['confirm_password'])): ?>
        <div>
            <p><?= $_SESSION['errors']['confirm_password'] ?></p>
        </div>
    <?php endif; ?>
    <input type="hidden" name="action" value="store">
    <input type="hidden" name="resource" value="user">
    <input type="submit" value="M'enregistrer">
</form>
</body>
</html>
