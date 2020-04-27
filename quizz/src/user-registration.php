<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
</head>
<body>
    <?php
        $message = '';
        $legend = '';
        $user = array(
            'surname' => '',
            'firstname' => '',
            'login' => '',
            'password' => ''
        );
        if (isset($_SESSION['message']) && isset($_SESSION['legend'])) {
            $message = $_SESSION['message'];
            $legend = $_SESSION['legend'];
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
            $user['login'] = test_input($_POST["username"]);
            $user['password'] = test_input($_POST["password"]);
            $user['surname'] = test_input($_POST["surname"]);
            $user['firstname'] = test_input($_POST["firstname"]);
            if ($_POST['password'] == $_POST['confirmation']) {
                if (is_login_valid($_POST['username'])) {
                    if (!empty($_FILES['file']['name'])) {
                        $result = upload_image();
                        if ($result == 'true') {
                            if (isset($_GET['lien']) && $_GET['lien'] == 'signup') {
                                $user['role'] = 'player';
                            } else {
                                $user['role'] = 'admin';
                            }
                            $target_dir = "public/uploads/";
                            $target_file = $target_dir . basename($_FILES["file"]["name"]);
                            $user['avatar'] = $target_file;
                            sign_up($user);
                        } else {
                            $errors['file'] = $result;
                        }
                    } else {
                        $errors['file'] = '*Veuillez choisir un avatar.';
                    }
                } else {
                    $errors['username'] = 'Ce login existe déjà';
                }
            } else {
                $errors['password'] = 'Les deux mots de passe ne sont pas identiques';
            }
        }
    ?>
    <div class="user-form">
        <form class="form" method="POST" id="signup-form" enctype="multipart/form-data">
            <div class="form-inputs">
                <div class="user-form-header">
                    <div class="user-form-title">S'INSCRIRE</div>
                    <div class="text"><?= $message ?></div>
                </div>
                <hr>
                <div class="input-container">
                    <label class="form-label" for="">Prénom</label>
                    <div class="user-form-input"><input type="text" error="surname-error" name="surname" value="<?= $user['surname']?>" id=""></div>
                </div>
                <div class="user-form-error" id="surname-error"></div>
                <div class="input-container">
                    <label class="form-label" for="">Nom</label>
                    <div class="user-form-input"><input type="text" error="firstname-error" name="firstname" value="<?= $user['firstname']?>"></div>
                </div>
                <div class="user-form-error" id="firstname-error"></div>
                <div class="input-container">
                    <label class="form-label" for="">Login</label>
                    <div class="user-form-input"><input type="text" error="login-error" name="username" value="<?= $user['login']?>"></div>
                </div>
                <div class="user-form-error" id="login-error"><?php if(!empty($errors['username'])){echo $errors['username'];} ?></div>
                <div class="input-container">
                    <label class="form-label" for="">Mot de passe</label>
                    <div class="user-form-input"><input type="password" error="password-error" name="password" value="<?= $user['password']?>"></div>
                </div>
                <div class="user-form-error" id="password-error"></div>
                <div class="input-container">
                    <label class="form-label" for="">Confirmer mot de passe</label>
                    <div class="user-form-input"><input type="password" error="confirmation-error" name="confirmation" value="<?php if(!empty($_POST)) {echo $_POST['confirmation'];} ?>"></div>
                </div>
                <div class="user-form-error" id="confirmation-error"><?php if(!empty($errors['password'])){echo $errors['password'];} ?></div>
                <div class="submit">
                    <div class="submit-text">Avatar</div>
                    <div>
                        <label class="btn-file">
                            <input type="file" name="file" id="inpFile" accept="image/jpeg, image/png">Choisir un fichier
                        </label>
                    </div>
                    <div><input class="btn-signup" type="submit" value="Créer compte" name="signup"></div>
                </div>
            </div>
            <div class="form-avatar" id="avatar">
                <div class="avatar"><img src="public/img/account.png" alt="User Avatar" class="img-preview"></div>
                <div class="avatar-legend"><?= $legend ?></div>
                <div class="user-form-error upload" id="upload-error"><?php if(!empty($errors['file'])){echo $errors['file'];} ?></div>
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
        document.getElementById('signup-form').addEventListener('submit', function(e){
            const inputs = document.getElementsByTagName('input');
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
        const inpFile = document.getElementById('inpFile');
        const avatar = document.getElementById('avatar');
        const previewAvatar = avatar.querySelector(".img-preview");
        inpFile.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener('load', function(){
                    console.log(this);
                    previewAvatar.setAttribute('src', this.result);
                });
                reader.readAsDataURL(file);
                document.getElementById('upload-error').innerText = "";
            } else {
                previewAvatar.setAttribute('src', 'public/img/account.png');
                document.getElementById('upload-error').innerText = "*Veuillez choisir un avatar.";
            }
        });
        
    </script>
</body>
</html>