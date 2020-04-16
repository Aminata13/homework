<?php
session_start();
require_once('../tp4-tableaux/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <?php
        $username = "";
        $password = "";
        $file = 'login.json';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST['username'])) {
              $errors['username'] = "Veuillez remplir ce champ";
            }
            if (empty($_POST['password'])) {
                $errors['password'] = "Veuillez remplir ce champ";
            }
            if(empty($errors) && !authenticate($file, $_POST['username'], $_POST['password'])) {
                $errors['username'] = "Login ou mot de passe incorrect";
            }
            $username = test_input($_POST["username"]);
            $password = test_input($_POST["password"]);
        }
    ?>
    <header class="header">
        <div class="logo"><img src="images/logo-QuizzSA.png" alt=""></div>
        <div class="title">Le Plaisir de Jouer</div>
    </header>
    <div class="content">
        <div class="form-login">
            <form class="form" method="POST">
                <div class="form-header">
                    <div class="form-header-text">Login Form</div>
                </div>
                <span class="error"><?php if(!empty($errors['username'])){echo $errors['username'];} ?></span>
                <div class="form-content">
                    <div class="form-input"><input type="text" placeholder="Login" name="username" value="<?= $username ?>"></div>
                    <div class="form-icon icon1"><img src="images/icônes/ic-login.png" alt=""></div>
                </div>
                <span class="error"><?php if(!empty($errors['password'])){echo $errors['password'];} ?></span>
                <div class="form-content">
                    <div class="form-input"><input type="password" placeholder="Password" name="password" value="<?= $password ?>"></div> 
                    <div class="form-icon"><img src="images/icônes/ic-password.png" alt=""></div>
                </div>
                <div class="submit">
                    <div class="button button1"><input type="submit" name="login" value="Connexion"></div>
                </div>
                <div class="submit">
                    <div class="button button2"><input type="submit" name="signup" value="S'inscrire pour jouer?"></div>
                </div>
            </form>
        </div>
    </div>

<?php
    if (isset($_POST['login']) && empty($errors)) {
        $_SESSION['user'] = get_user($file, $username, $password);
        if ($_SESSION['user']->role == 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: player.php');
        }
    }
?>
</body>
</html>