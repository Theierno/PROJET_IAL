<?php
session_start();

// Vérification si l'utilisateur est déjà connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TéléInf</title>
    <link rel="stylesheet" href="../Assets/CSS/style.css">
</head>

<body>
    <header>
        <div class="container">
            <!-- NavBar -->
            <nav class="navbar">
                <div class="admin-navbar">
                    <a href="#" class="nav-branding"> User </a>
                    <h6> Dashborad</h6>
                </div>

                <div class="user">
                <a href="logout.php" class="nav-link"><ion-icon name="log-out-outline" class="icon"></ion-icon>
                        <ion-icon name="person-circle-outline" class="icon"></ion-icon>
                        <?= $_SESSION['username'] ?></a>

                </div>
            </nav>
        </div>
    </header>
