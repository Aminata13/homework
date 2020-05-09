<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score</title>
</head>
<body>
<?php
    $questions = $_SESSION['questions'];
    $index = count($_SESSION['questions']);
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['next']) && $_SESSION['in']) {
        $answer= array();
        $answer['question'] = $_SESSION['questions'][$index-1]['question'];
        foreach ($_POST as $key => $value) {
            if($key != 'next') {
                $answer[$key] = $value;
            }
        }
        if (isset($_SESSION['answers'])) {
            foreach ($_SESSION['answers'] as $key => $value) {
                if ($value['question'] == $answer['question']) {
                    $questionIndex = $key;
                }
            }
        }
        if (isset($questionIndex)) {
            $_SESSION['answers'][$questionIndex] = $answer;
        } else {
            $_SESSION['answers'][] = $answer;
        }
        $_SESSION['in'] = false;
    }
    $answers = $_SESSION['answers'];
    $user = get_user($_SESSION['user']['login'], $_SESSION['user']['password']);
    $score = get_score($questions, $answers, $user);
    $totalPoints  = get_total_points($questions);
    if ($score > $user['score']) {
        $user['score'] = $score;
        set_score($user);
    }
    
?>
<div class="page-score-container">
    
    <?php
        if ($score >= ($totalPoints/2)) {
            echo '<div class="alert-msg success-msg"><i class="fa fa-check"></i> Bravo :) Quizz réussi !</div>';
        } else {
            echo '<div class="alert-msg error-msg"><i class="fa fa-times-circle"></i> Dommage :( Vous ferez mieux la prochaine fois !</div>';
        }

        foreach ($questions as $key => $value) {
            echo '<div class="score-title">Question '. ($key+1) .'</div>
            <hr>
            <div class="score-question">'. $value['question'] .'</div>';
            if($value['type'] == 'text') {
                $text = get_input_value($value, $answers);
                echo '<label>';
                if ($text == $value['answer']['text']) {
                    echo '<i class="fa fa-check" aria-hidden="true"></i>';
                } else {
                    echo '<i class="fa fa-times" aria-hidden="true"></i>';
                }
                echo '<input disabled type="text" value="'. $text .'">
                </label>';
            } elseif($value['type'] == 'simple') {
                $j = 1;
                while(isset($value['answer'.$j])) {
                    echo '<label>';
                    if (is_checked($answers, $value['answer'.$j]['text'], $value['question'])) {
                        if ($value['answer'.$j]['result']) {
                            echo '<i class="fa fa-check" aria-hidden="true"></i>';
                        } else {
                            echo '<i class="fa fa-times" aria-hidden="true"></i>';
                        }
                        echo '<input checked disabled type="radio"> '.$value['answer'.$j]['text'];
                    } else {
                        echo '<i class="fa fa-check" style="opacity:0" aria-hidden="true"></i>';
                        echo '<input disabled type="radio"> '.$value['answer'.$j]['text'];
                    }
                    echo '</label><br>';
                    $j++;
                }
            } else {
                $k = 1;
                while(isset($value['answer'.$k])) {
                    echo '<label>';
                    if (is_checked($answers, $value['answer'.$k]['text'], $value['question'])) {
                        if ($value['answer'.$k]['result']) {
                            echo '<i class="fa fa-check" aria-hidden="true"></i>';
                        } else {
                            echo '<i class="fa fa-times" aria-hidden="true"></i>';
                        }
                        echo '<input checked disabled type="checkbox"> '.$value['answer'.$k]['text'];
                    } else {
                        echo '<i class="fa fa-check" style="opacity:0" aria-hidden="true"></i>';
                        echo '<input disabled type="checkbox"> '.$value['answer'.$k]['text'];
                    }
                    echo '</label><br>';
                    $k++;
                }
            }
        }
    ?>
    <div class="card final-score">Score: <?= $score ?>/<?= $totalPoints ?></div>
</div>
</body>
</html>