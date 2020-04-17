<?php
if (isset($_SESSION['user'])) {
    $admin = $_SESSION['user'];
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
}
if (!isset($_SESSION['statut'])){
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <title>Admin</title>
</head>
<body>
    <header class="admin-header">
        <div class="title title-admin">CREER ET PARAMETRER VOS QUIZZ</div>
        <form action="" method="post">
            <input class="button button-admin" type="submit" name="logout" value="Déconnexion">
        </form>
    </header>
    <div class="admin-content">
        <div class="menu">
            <div class="menu-header">
                <div class="avatar"><img src="public/img/img5.jpg" alt=""></div>
                <div class="text surname"><?php echo my_to_upper_string($admin['surname']); ?></div>
                <div class="text firstname"><?php echo my_to_upper_string($admin['firstname']); ?></div>
            </div>
            <div class="menu-content">
                <div class="menu-tab">
                    <div class="tab-title">Liste des Questions</div>
                    <div class="icon-tab"><img src="public/icones/ic-liste.png" alt=""></div>
                </div>
                <div class="menu-tab">
                    <div class="tab-title">Créer Admin</div>
                    <div class="icon-tab"><img src="public/icones/ic-ajout.png" alt=""></div>
                </div>
                <div class="menu-tab active">
                    <div class="tab-title">Liste des Joueurs</div>
                    <div class="icon-tab"><img src="public/icones/ic-liste-active.png" alt=""></div>
                </div>
                <div class="menu-tab">
                    <div class="tab-title">Créer Joueur</div>
                    <div class="icon-tab"><img src="public/icones/ic-ajout.png" alt=""></div>
                </div>
            </div>
        </div>
        <div class="container">
            <?php
                require_once('src/player/list.php');
            ?>
        </div>
    </div>
</body>
</html>