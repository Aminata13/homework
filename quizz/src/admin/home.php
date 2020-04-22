<?php
is_connected();
if (isset($_SESSION['user'])) {
    $admin = $_SESSION['user'];
}
if (isset($_POST['logout'])) {
    session_destroy();
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
        <a class="button button-admin" href="index.php?statut=logout">Déconnexion</a>
    </header>
    <div class="admin-content">
        <div class="menu">
            <div class="menu-header">
                <div class="avatar"><img src="<?= $admin['avatar'] ?>" alt=""></div>
                <div class="text surname"><?php echo mb_strtoupper($admin['surname']); ?></div>
                <div class="text firstname"><?php echo mb_strtoupper($admin['firstname']); ?></div>
            </div>
            <div class="menu-content">
                <div class="menu-tab">
                    <div class="tab-title">
                        <a href="index.php?lien=home&amp;content=questions-list">Liste des Questions</a>
                    </div>
                    <div class="icon-tab"><img src="public/icones/ic-liste.png" alt=""></div>
                </div>
                <div class="menu-tab">
                    <div class="tab-title"> 
                        <a href="index.php?lien=home&amp;content=create-admin">Créer Admin</a>
                    </div>
                    <div class="icon-tab"><img src="public/icones/ic-ajout.png" alt=""></div>
                </div>
                <div class="menu-tab active">
                    <div class="tab-title">
                        <a href="index.php?lien=home&amp;content=players">Liste des Joueurs</a>
                    </div>
                    <div class="icon-tab"><img src="public/icones/ic-liste-active.png" alt=""></div>
                </div>
                <div class="menu-tab">
                    <div class="tab-title">
                        <a href="index.php?lien=home&amp;content=create-question">Créer Questions</a>
                    </div>
                    <div class="icon-tab"><img src="public/icones/ic-ajout.png" alt=""></div>
                </div>
            </div>
        </div>
        <div class="container">
            <?php
            if (isset($_GET['content'])) {
                if ($_GET['content'] == 'questions-list') {
                    require_once('src/question/list.php');
                } elseif ($_GET['content'] == 'create-admin') {
                    $_SESSION['message'] = 'Pour proposer des quizz';
                    $_SESSION['legend'] = 'Avatar admin';
                    require_once('src/user-registration.php');
                } elseif ($_GET['content'] == 'players') {
                    require_once('src/player/list.php');
                } elseif ($_GET['content'] == 'create-question') {
                    require_once('src/question/new.php');
                }
            } else {
                require_once('src/question/list.php');
            }
            ?>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("a[href*='" + window.location.href + "']").addClass("active");
        });
    </script>
</body>
</html>