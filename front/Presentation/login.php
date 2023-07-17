<?php
session_start();
require_once  __DIR__.'/../Controller/LoginControlleur.php';

$login = new LoginControlleur();

$login->waitingConnection();



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TéléInf</title>
    <link rel="stylesheet" href="../Assets/CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="POST" action="login.php" class="login-form">
        <h3>Connectez-vous</h3>

        <label for="username" class="login-label">Nom d'utilisateur</label>
        <input type="text" name="username" class="login-input" placeholder="ex : halima" id="username">

        <label for="password" class="login-label">Mot de passe</label>
        <input type="password" class="login-input" name="password" placeholder="Votre mot de passe" id="password">
        <a href="#" class="login-link">Mot de passe oublié ?</a>

        <button class="login-button">Se connecter</button>
       
    </form>

</body>
</html>
