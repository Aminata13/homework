<?php
session_start();
require_once('../functions.php');
if (isset($_SESSION['user'])) {
    $player = $_SESSION['user'];
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../../index.php');
}
if (!isset($_SESSION['statut'])){
    header('Location: ../../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <title>Player</title>
</head>
<body>
    <header class="admin-header">
        <div class="logo"><img src="images/logo-QuizzSA.png" alt=""></div>
        <div class="title title-player">BIENVENUE SUR LA PLATEFORME DE JEU DE QUIZZ <br> JOUER ET TESTER VOTRE NIVEAU DE CULTURE GÉNÉRALE</div>
        <form action="" method="post">
            <input class="button button-admin" type="submit" name="logout" value="Déconnexion">
        </form>
    </header>
    <div class="">
        <?php
            if (isset($player)) {
                echo 'Nom: ' .$player['surname'];
                echo '<br>Prénom: ' .$player['firstname'];
                echo '<br>Profile picture: ' .$player['avatar'];
            }
        ?>
    </div>
</body>
</html>