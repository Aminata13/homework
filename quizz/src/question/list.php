<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Questions</title>
</head>
<body>
<?php
    $questions = get_data('questions');
    $data = get_data('game');
    $nbrQuestions = $data['nbrQuestions'];
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) { 
        if (empty($_POST['nbQuestions'])) {
            $errors['submit'] = "*Veuillez renseigner ce nombre.";
        } else {
            $nbQuestions = (int)test_input($_POST['nbQuestions']);
            if ($nbQuestions < 5) {
                $errors['submit'] = "*Le nombre de questions doit être supérieur à 5.";
            }
        }
        if (empty($errors)) {
            $tab = array('nbrQuestions' => $nbQuestions);
            set_nombre_questions($tab);
        }
    }
?>
    <div class="questions-list-header">
        <form action="" method="post">
            <label for="">Nombre de questions/Jeu</label>
            <input id="nbQuestions" type="text" name="nbQuestions" value="<?= $nbrQuestions ?>">
            <input id="btn-submit" type="submit" name="submit" value="OK">
        </form>
        <div id="number-error" class="error"><?php if(!empty($errors)) {echo $errors['submit']; } ?></div>
    </div>
    <?php
        paginate_questions('index.php?lien=admin&content=questions-list&page=', 5, $questions);
    ?>
    <script>
        document.getElementById('nbQuestions').addEventListener('keyup', function(e){
            document.getElementById('number-error').innerText = "";
                
        });
        document.getElementById('btn-submit').addEventListener('click', function(e){
            var error = false;
            const input = document.getElementById('nbQuestions');
            if (!input.value) {
                error = true;
                document.getElementById('number-error').innerText = "*Veuillez renseigner ce nombre.";
            }
            if (input.value < 5) {
                error = true;
                document.getElementById('number-error').innerText = "*Le nombre de questions doit être supérieur à 5.";
            }
            if(error) {
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>
</html>