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
?>
    <div class="questions-list-header">
        <form action="" method="post">
            <label for="">Nombre de questions/Jeu</label>
            <input type="text" name="nbQuestions" value="" id="">
            <input type="submit" value="OK">
        </form>
    </div>
    <?php
        paginate_questions('index.php?lien=home&content=questions-list&page=', 5, $questions);
    ?>
</body>
</html>