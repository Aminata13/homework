<?php
session_start();
require_once('src/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Quizz</title>
</head>
<body>
    <header class="header">
        <div class="logo"><img src="public/img/logo-QuizzSA.png" alt=""></div>
        <div class="title">Le Plaisir de Jouer</div>
    </header>
    <div class="content">
        <?php
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role']=="admin") {
                require_once('src/admin/home.php');
            } else {
                header('Location: src/player/game.php');
            }
        } else {
            require_once('src/login.php');
        }
        ?>
    </div>
</body>
</html>