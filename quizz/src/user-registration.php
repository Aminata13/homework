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
    ?>
    <div class="user-form">
        <form class="form" method="POST" id="login-form">
            <div class="form-inputs">
                <div class="user-form-header">
                    <div class="user-form-title">S'INSCRIRE</div>
                    <div class="text">Pour tester votre niveau de culture générale</div>
                </div>
                <hr>
                <div class="input-container">
                    <label class="form-label" for="">Prénom</label>
                    <div class="user-form-input"><input type="text" name="surname" id=""></div>
                </div>
                <div class="input-container">
                    <label class="form-label" for="">Nom</label>
                    <div class="user-form-input"><input type="text" name="surname" id=""></div>
                </div>
                <div class="input-container">
                    <label class="form-label" for="">Login</label>
                    <div class="user-form-input"><input type="text" name="surname" id=""></div>
                </div>
                <div class="input-container">
                    <label class="form-label" for="">Mot de passe</label>
                    <div class="user-form-input"><input type="password" name="surname" id=""></div>
                </div>
                <div class="input-container">
                    <label class="form-label" for="">Confirmer mot de passe</label>
                    <div class="user-form-input"><input type="password" name="surname" id=""></div>
                </div>
                <div class="submit">
                    <div class="submit-text">Avatar</div>
                    <div><input class="btn-file" type="submit" value="Choisir un fichier" name=""></div>
                    <div><input class="btn-signup" type="submit" value="Créer compte" name=""></div>
                </div>
            </div>
            <div class="form-avatar">
                <div class="avatar"><img src="public/img/img5.jpg" alt=""></div>
                <div class="avatar-legend">Avatar du joueur</div>
            </div>
        </form>
    </div>
    <script>
    </script>
</body>
</html>