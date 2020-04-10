<?php
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
                <div class="form-content">
                    <div class="form-input"><input type="text" placeholder="Login" name="size" value="<?php echo $username;?>"></div>
                    <div class="form-icon icon1"><img src="images/icônes/ic-login.png" alt=""></div>
                </div>
                <div class="form-content">
                    <div class="form-input"><input type="text" placeholder="Password" name="size" value="<?php echo $password;?>"></div> 
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
</body>
</html>