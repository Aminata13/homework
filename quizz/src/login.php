<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
        $username = "";
        $password = "";
        $file = 'data/users.json';
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
            $username = test_input($_POST["username"]);
            $password = test_input($_POST["password"]);
            if (authenticate($file, $username, $password)) {
                $_SESSION['user'] = get_user($file, $username, $password);
                $_SESSION['statut'] = 'login';
                header('Location: index.php');
            } else {
                $errors['form'] = 'Login ou mot de passe incorrect';
            }
        }
        if (isset($_POST['signup'])) {
            require_once('src/user-registration.php');
        }
    ?>
    <div class="container">
        <form class="form" method="POST" id="login-form">
            <div class="form-header">
                <div class="form-header-text">Login Form</div>
            </div>
            <div class="form-content">
                <div class="form-input"><input type="text" placeholder="Login" error="login-error" name="username" value="<?= $username ?>"></div>
                <div class="form-icon icon1"><img src="public/icones/ic-login.png" alt=""></div>
            </div>
            <div class="error" id="login-error"></div>
            <div class="form-content">
                <div class="form-input"><input type="password" error="password-error" placeholder="Password" name="password" value="<?= $password ?>"></div> 
                <div class="form-icon"><img src="public/icones/ic-password.png" alt=""></div>
            </div>
            <div class="error" id="password-error"><?php if(!empty($errors['form'])){echo $errors['form'];} ?></div>
            <div class="submit">
                <div class="button button1"><input type="submit" name="login" value="Connexion"></div>
            </div>
            <div class="submit">
                <div class="button button2"><input type="submit" name="signup" value="S'inscrire pour jouer?"></div>
            </div>
        </form>
    </div>
    <script>
        const inputs = document.getElementsByTagName('input');
        for (input of inputs) {
            input.addEventListener('keyup', function(e){
                if (e.target.hasAttribute('error')) {
                    var idDivError = e.target.getAttribute('error');
                    document.getElementById(idDivError).innerText = "";
                }
            })
        }
        document.getElementById('login-form').addEventListener('submit', function(e){
            const inputs = document.getElementsByTagName('input');
            console.log('inputs');
            var error = false;
            for (input of inputs) {
                if (input.hasAttribute('error')){
                    var idDivError = input.getAttribute('error');
                    if(!input.value) {
                        error = true;
                        document.getElementById(idDivError).innerText = "Ce champ est obligatoire";
                    }
                }
            }
            if (error) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>
</html>