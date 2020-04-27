<?php
session_start();
require_once('src/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Quizz</title>
</head>
<body>
    <header class="header">
        <div class="logo"><a href="index.php"><img src="public/img/logo-QuizzSA.png" alt="logo du jeu"></a></div>
        <div class="title">Le Plaisir de Jouer</div>
    </header>
    <div class="content">
        <?php
        if (isset($_GET['lien'])) {
            if ($_GET['lien']=="home") {
                require_once('src/admin/home.php');
            } elseif($_GET['lien']=="game") {
                require_once('src/player/game.php');
            } elseif ($_GET['lien']=="signup") {
                $_SESSION['message'] = 'Pour tester votre niveau de culture générale';
                $_SESSION['legend'] = 'Avatar du joueur';
                require_once('src/user-registration.php');
            }
        } else {
            if (!isset($_SESSION['statut']) && isset($_GET['statut']) && isset($_GET['statut'])=='logout') {
                log_out();
            }
            require_once('src/login.php');
        }
        ?>
    </div>
</body>
</html>