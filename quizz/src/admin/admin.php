<?php
session_start();
require_once('../tp4-tableaux/functions.php');
if (isset($_SESSION['user'])) {
    $admin = $_SESSION['user'];
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin</title>
</head>
<body>
    <header class="header-admin">
        <div class="title title-admin">CREER ET PARAMETRER VOS QUIZZ</div>
        <form action="" method="post">
            <input class="button button-admin" type="submit" name="logout" value="Déconnexion">
        </form>
    </header>
    <div class="">
        <?php
           if (isset($admin)) {
                echo 'Nom: ' .$admin->surname;
                echo '<br>Prénom: ' .$admin->firstname;
                echo '<br>Profile picture: ' .$admin->picture;
            }
        ?>
    </div>
</body>
</html>