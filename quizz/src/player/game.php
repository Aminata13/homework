<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu</title>
</head>
<body>
<?php
    $_SESSION['in'] = true;
    $data = get_data('game');
    $nbrQuestions = $data['nbrQuestions'];

    if (isset($_GET['page'])) {
        $index = (int)($_GET['page']-1);
    } else {
        $index = 0;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['next']) || isset($_POST['stop']))) {
        $answers = array();
        $answers['question'] = $_SESSION['questions'][$index-1]['question'];
        foreach ($_POST as $key => $value) {
            if($key != 'next' && $key != 'stop') {
                $answers[$key] = $value;
            }
        }
        if (isset($_SESSION['answers'])) {
            foreach ($_SESSION['answers'] as $key => $value) {
                if ($value['question'] == $answers['question']) {
                    $questionIndex = $key;
                }
            }
        }
        if (isset($questionIndex)) {
            $_SESSION['answers'][$questionIndex] = $answers;
        } else {
            $_SESSION['answers'][] = $answers;
        }
    }
    if (isset($_POST['stop'])) {
        header('Location: index.php?lien=player&page=end');
    }
    
    if (!isset($_GET['page'])) {
        paginate_question('index.php?lien=player&page=', $nbrQuestions, $_SESSION['questions']);
    } else {
        paginate_question('index.php?lien=player&page=', $nbrQuestions, $_SESSION['questions'], $_SESSION['answers']);
    }
?>

</body>
</html>