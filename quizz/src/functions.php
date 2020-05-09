<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
    
    function get_data ($file='users') {
        $data = file_get_contents('data/'.$file.'.json'); 
        return json_decode($data, true);
    }

    function set_data (array $tab, $file='users') {
        $temp = get_data($file);
        array_push($temp, $tab);
        $data = json_encode($temp);
        file_put_contents('data/'.$file.'.json', $data);
    }

    function get_user($login, $password){
        $data = get_data();
        foreach ($data as $element) {
            if ($element['login'] == $login && $element['password'] == $password) {
                return $element;
            }
        }
        return false;
    }

    function set_nombre_questions($nbQuestions) {
        $data = json_encode($nbQuestions);
        file_put_contents('data/game.json', $data);
    }

    function is_login_valid ($login) {
        $data = get_data();
        foreach ($data as $element) {
            if ($element['login'] == $login) {
                return false;
            }
        }
        return true;
    }

    function sign_up(array $user) {
        set_data($user);
        $_SESSION['user'] = $user;
        $_SESSION['statut'] = 'login';
        if ($user['role'] == 'player') {
            header('Location: index.php?lien=game');
        } else {
            header('Location: index.php?lien=home');
        }
    }

    function authenticate($login, $password) {
        $data = get_data();
        foreach ($data as $element) {
            if ($element['login'] == $login && $element['password'] == $password) {
                if ($element['role'] == 'admin'){
                    return 'admin';
                } else {
                    return 'player';
                }
            }
        }
        return 'error';
    }
    
    function log_out() {
        unset($_SESSION['user']);
        unset($_SESSION['statut']);
        session_destroy();
    }

    function is_connected() {
        if (!isset($_SESSION['statut'])){
            header('Location: index.php');
        }
    }

    function upload_image ($file='file') {
        $target_dir = "public/uploads/";
        $target_file = $target_dir . basename($_FILES[$file]["name"]);

        // Check if image file is a actual image or fake image
        if(empty($_FILES[$file]["tmp_name"])) {
            return "Ce fichier n'est pas une image.";
        } else {
            // Check if file already exists
            if (file_exists($target_file)) {
                return "Ce fichier existe déjà.";
            } else {
                // Check file size
                if ($_FILES[$file]["size"] > 500000) {
                    return "Ce fichier est trop large.";
                } else {
                    // if everything is ok, try to upload file
                    move_uploaded_file($_FILES[$file]["tmp_name"], $target_file);
                    return "true";
                }
        
            }
    
        }
        
    }
    function get_players() {
        $users = get_data();
        $list = array();
        foreach ($users as $element) {
            if ($element['role'] == 'player') {
                $list[] = $element;
            }
        }
        for ($i=0; $i<count($list); $i++) {
            for ($j=count($list)-1; $j>=$i+1; $j--) {
                if($list[$j]['score'] > $list[$j-1]['score']) {
                    $temp = $list[$j];
                    $list[$j] = $list[$j-1];
                    $list[$j-1] = $temp;
                }
            }
        }
        return $list;
    }
    function paginate (string $link, int $elementsPerPage, array $tab) {
        $_SESSION['nbrNumbers'] = count($tab);
        $_SESSION['nbrPages'] = ceil($_SESSION['nbrNumbers']/$elementsPerPage);
        if(isset($_GET['page'])) {
            $_SESSION['pageActuelle'] = intval($_GET['page']);
     
            if($_SESSION['pageActuelle'] > $_SESSION['nbrPages']){
                $_SESSION['pageActuelle'] = $_SESSION['nbrPages'];
            }
        }
        else {
            $_SESSION['pageActuelle'] = 1; // La page actuelle est la n°1    
        }
        $_SESSION['firstEntry'] = ($_SESSION['pageActuelle']-1)*$elementsPerPage;
        $_SESSION['finalValue'] = $_SESSION['pageActuelle']*$elementsPerPage;
        if ($_SESSION['finalValue'] > count($tab)) {
            $_SESSION['finalValue'] = count($tab);
        } 
        
        echo '<div class="list-column">';
        echo '<p>Nom</p>';
        $i=$_SESSION['firstEntry'];
        while ($i < $_SESSION['finalValue']) { 
            echo '<div>' .mb_strtoupper($tab[$i]['firstname']). '</div>';
            $i++;
        }
        echo '</div>';
        echo '<div class="list-column">';
        echo '<p>Prénom</p>';
        $i=$_SESSION['firstEntry'];
        while ($i < $_SESSION['finalValue']) { 
            echo '<div>' .$tab[$i]['surname']. '</div>';
            $i++;
        }
        echo '</div>';
        echo '<div class="list-column">';
        echo '<p>Score</p>';
        $i=$_SESSION['firstEntry'];
        while ($i < $_SESSION['finalValue']) { 
            echo '<div>' .$tab[$i]['score']. '</div>';
            $i++;
        }
        echo '</div>';
        echo '</div>';
    
        if ($_SESSION['pageActuelle'] == 1) {
            echo ' <a href="'.$link.($_SESSION['pageActuelle']+1).'" class="btn-next">Suivant</a> ';
        } elseif ($_SESSION['pageActuelle'] == $_SESSION['nbrPages']) {
            echo ' <a href="'.$link.($_SESSION['pageActuelle']-1).'" class="btn-previous">Précédent</a> ';
        } else {
            echo ' <a href="'.$link.($_SESSION['pageActuelle']-1).'" class="btn-previous">Précédent</a> ';
            echo ' <a href="'.$link.($_SESSION['pageActuelle']+1).'" class="btn-next">Suivant</a> ';
        }
     }
    function is_string_inside ($tab, $string) {
        $result = array();
        foreach ($tab as $key => $value) {
            if (strpos($key, $string) !== false) {
                $result[] = $key;
            }
        }
        return $result;
    }
    function create_text_question($inputs) {

    }
    function create_questions($question, $score, $type, $inputs, $tab1, $tab2) {
        $answer['question'] = $question;
        $answer['score'] = $score;
        $answer['type'] = $type;
        if ($type == 'text') {
            $answer['answer']['text'] = $inputs['textarea'];
            $answer['answer']['result'] = true;
        }  elseif ($type == 'simple') {
            $i = 1;
            foreach ($tab1 as $key => $value) {
                $answer['answer'.$i]['text'] = $inputs[$value];
                if ($value == $inputs['simple-answer']) {
                    $answer['answer'.$i]['result'] = true;
                } else {
                    $answer['answer'.$i]['result'] = false;
                }
                $i++;
            }
        } elseif($type == 'multiple') {
            $j = 1;
            foreach ($tab2 as $key => $value) {
                if ($value !== 'textarea') {
                    $answer['answer'.$j]['text'] = $inputs[$value];
                    if (isset($inputs['answer'.$j]) && $value == $inputs['answer'.$j]) {
                        $answer['answer'.$j]['result'] = true;
                    } else {
                        $answer['answer'.$j]['result'] = false;
                    }
                    $j++;
                }
            }
        }
        set_data($answer, 'questions');
    }

    function validate_form_questions($inputs) {
        $errors = array();
        if (empty($inputs["question"])) {
            $errors['question'] = "*Champ Obligatoire";
        } 
        if (empty($inputs["score"])) {
            $errors['score'] = "*Champ Obligatoire";
        } 
        if (empty($inputs["type"])){
            $errors['type'] = "*Champ Obligatoire";
        } else {
            if ($inputs["type"] == "text" && empty($inputs["textarea"])) {
                $errors['text-answer'] = "*Champ Obligatoire";
            } elseif ($inputs["type"] == "simple") {
                if (!isset($inputs['simple-answer'])) {
                    $errors['type'] = "*Veuillez cocher la bonne réponse";
                }
                $simpleAnswers = is_string_inside($inputs, 'label');
                foreach ($simpleAnswers as $key => $value) {
                    if (empty($inputs[$value])) {
                        $errors['simple-answer'] = "*Veuillez remplir tous les champs réponse";
                    break;
                    }
                }
                if (count($simpleAnswers) == 1) {
                    $errors['type'] = "*Veuillez remplir au moins deux champs réponses";
                }
            } elseif ($inputs["type"] == "multiple") {
                $answers = is_string_inside($inputs, 'answer');
                if (count($answers) < 2) {
                    $errors['type'] = "*Veuillez cocher 2 réponses au moins";
                }
                $multipleAnswers = is_string_inside($inputs, 'text');
                foreach ($multipleAnswers as $key => $value) {
                    if ($value!=="textarea" && empty($inputs[$value])) {
                        $errors['multiple-answer'] = "*Veuillez remplir tous les champs réponse";
                    break;
                    }
                }
            }
        }
        return $errors;
    }
    function paginate_questions(string $link, int $elementsPerPage, array $tab) {
        $_SESSION['nbrNumbers'] = count($tab);
        $_SESSION['nbrPages'] = ceil($_SESSION['nbrNumbers']/$elementsPerPage);
        if(isset($_GET['page'])) {
            $_SESSION['pageActuelle'] = intval($_GET['page']);
     
            if($_SESSION['pageActuelle'] > $_SESSION['nbrPages']){
                $_SESSION['pageActuelle'] = $_SESSION['nbrPages'];
            }
        }
        else {
            $_SESSION['pageActuelle'] = 1; // La page actuelle est la n°1    
        }
        $_SESSION['firstEntry'] = ($_SESSION['pageActuelle']-1)*$elementsPerPage;
        $_SESSION['finalValue'] = $_SESSION['pageActuelle']*$elementsPerPage;
        if ($_SESSION['finalValue'] > count($tab)) {
            $_SESSION['finalValue'] = count($tab);
        }  

        echo '<div class="questions-list-container">';
        $i=$_SESSION['firstEntry'];
        while ($i < $_SESSION['finalValue']) { 
            echo '<div class="question-title">'.($i+1).'.'.$tab[$i]['question'].'</div>';
            echo '<div class="answers-list">';
            if ($tab[$i]['type'] == 'text') {
                echo '<input disabled type="text" name="" value="'.$tab[$i]['answer']['text'].'">';
            } elseif ($tab[$i]['type'] == 'simple'){
                $j = 1;
                while(isset($tab[$i]['answer'.$j])) {
                    if($tab[$i]['answer'.$j]['result']) {
                        echo '<div><i class="fa fa-circle"></i> '.$tab[$i]['answer'.$j]['text'].'</div>';
                    } else {
                        echo '<div><i class="fa fa-circle-o"></i> '.$tab[$i]['answer'.$j]['text'].'</div>';
                    }
                    $j++;
                }
            } else {
                $j = 1;
                while(isset($tab[$i]['answer'.$j])) {
                    if($tab[$i]['answer'.$j]['result']) {
                        echo '<div><i class="fa fa-check-square"></i> '.$tab[$i]['answer'.$j]['text'].'</div>';
                    } else {
                        echo '<div><i class="fa fa-square-o"></i> '.$tab[$i]['answer'.$j]['text'].'</div>';
                    }
                    $j++;
                }
            }
            echo '</div>';
            $i++;
        }
        echo '</div>';

        echo '<div class="btn-container">';
        if ($_SESSION['pageActuelle'] == 1) {
            echo ' <a href="'.$link.($_SESSION['pageActuelle']+1).'" class="btn-next">Suivant</a> ';
        } elseif ($_SESSION['pageActuelle'] == $_SESSION['nbrPages']) {
            echo ' <a href="'.$link.($_SESSION['pageActuelle']-1).'" class="btn-previous">Précédent</a> ';
        } else {
            echo ' <a href="'.$link.($_SESSION['pageActuelle']-1).'" class="btn-previous">Précédent</a> ';
            echo ' <a href="'.$link.($_SESSION['pageActuelle']+1).'" class="btn-next">Suivant</a> ';
        }
        echo '</div>';
    }
    function paginate_question(string $link, int $nbrQuestions, array $tab, array $answers = []) {
        $_SESSION['nbrPages'] = $nbrQuestions;
        if(isset($_GET['page'])) {
            $_SESSION['pageActuelle'] = intval($_GET['page']);
     
            if($_SESSION['pageActuelle'] > $_SESSION['nbrPages']){
                $_SESSION['pageActuelle'] = $_SESSION['nbrPages'];
            }
        }
        else {
            $_SESSION['pageActuelle'] = 1; // La page actuelle est la n°1    
        }
        $i = $_SESSION['pageActuelle']-1;
        echo '<div class="game-header">';
        echo '<div class="game-header-title">Question '. ($i+1) .'/'. $nbrQuestions .':</div>';
        echo '<div class="game-header-question">'. $tab[$i]['question'] .'</div></div>';
        echo '<div class="question-score">'. $tab[$i]['score'] .' pts</div>';
        echo '<input form="game-form" class="btn-leave btn-next" type="submit" name="stop" value="Quitter">';
        echo '<div class="game-question">';
        if ($_SESSION['pageActuelle'] == $_SESSION['nbrPages'] || isset($_POST['stop'])) {
            echo '<form action="index.php?lien=player&page=end" method="post" id="game-form">';
        } else {
            echo '<form action="'.$link.($_SESSION['pageActuelle']+1).'" method="post" id="game-form">';
        }

        if ($tab[$i]['type'] == 'text') {
            $text = get_input_value($tab[$i], $answers);
            echo '<label> Réponse: <input type="text" name="answer" value="'. $text .'"></label>';
        } elseif($tab[$i]['type'] == 'simple') {
            $j = 1;
            while(isset($tab[$i]['answer'.$j])) {
                echo '<label>';
                if (is_checked($answers, $tab[$i]['answer'.$j]['text'], $tab[$i]['question'])) {
                    echo '<input checked type="radio" name="answer" value="'.$tab[$i]['answer'.$j]['text'].'"> '.$tab[$i]['answer'.$j]['text'];
                } else {
                    echo '<input type="radio" name="answer" value="'.$tab[$i]['answer'.$j]['text'].'"> '.$tab[$i]['answer'.$j]['text'];
                }
                echo '</label><br>';
                $j++;
            }
        } else {
            $j = 1;
            while(isset($tab[$i]['answer'.$j])) {
                echo '<label>';
                if (is_checked($answers, $tab[$i]['answer'.$j]['text'], $tab[$i]['question'])) {
                    echo '<input checked type="checkbox" name="answer'.$j.'" value="'.$tab[$i]['answer'.$j]['text'].'"> '.$tab[$i]['answer'.$j]['text'];
                } else {
                    echo '<input type="checkbox" name="answer'.$j.'" value="'.$tab[$i]['answer'.$j]['text'].'"> '.$tab[$i]['answer'.$j]['text'];
                }
                echo '</label><br>';
                $j++;
            }
        }

        echo '</form></div>';
        echo '<div class="btn-container">';
        if ($_SESSION['pageActuelle'] == 1) {
            echo '<input form="game-form" class="btn-next" type="submit" name="next" value="Suivant">';
        } elseif ($_SESSION['pageActuelle'] == $_SESSION['nbrPages']) {
            echo ' <a href="'.$link.($_SESSION['pageActuelle']-1).'" class="btn-previous">Précédent</a> ';
            echo '<input form="game-form" class="btn-next" type="submit" name="next" value="Terminer">';
        } else {
            echo ' <a href="'.$link.($_SESSION['pageActuelle']-1).'" class="btn-previous">Précédent</a> ';
            echo '<input form="game-form" class="btn-next" type="submit" name="next" value="Suivant">';
        }
        echo '</div>';
    }

    function generate_questions($nbrQuestions, $user) {
        $questions = get_data('questions');
        $bannedQuestions = get_banned_questions($user);
        $userQuestions = get_user_questions($questions, $bannedQuestions);
        $gameQuestions = array();
        if (count($userQuestions) >= $nbrQuestions) {
            for ($i=0; $i < $nbrQuestions; $i++) { 
                $index = array_rand($userQuestions);
                array_push($gameQuestions, $userQuestions[$index]);
                unset($userQuestions[$index]);
            }
            return $gameQuestions;
        } else {
            return false;
        }
    }
    function get_input_value($tab, $answers){
        if ($tab['type'] == 'text') {
            $i = 0;
            while($i<count($answers)) {
                if ($tab['question'] == $answers[$i]['question']) {
                    return $answers[$i]['answer'];
                }
                $i++;
            }
        } else {
            return false;
        }
    }

    function is_checked($answers, $string, $question){
        foreach ($answers as $key => $value) {
            if (!empty($value) && $value['question'] == $question && isset($value['answer']) && $value['answer'] == $string) {   
                return true;
            } elseif (!empty($value) && $value['question'] == $question && !isset($value['answer'])) {
                $result = is_string_inside($value, 'answer');
                foreach ($result as $k => $v) {
                    if ($value[$v] == $string) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    function get_total_points($questions) {
        $score = 0;
        foreach ($questions as $key => $value) {
            $score += $value['score'];
        }
        return $score;
    }

    function get_good_answers($questions, $question) {
        $tab = array();
        for ($i=0; $i < count($questions) ; $i++) {
            $j = 1;
            while (isset($questions[$i]['answer'.$j]) && $questions[$i]['question'] == $question) {
                if ($questions[$i]['answer'.$j]['result']) {
                    array_push($tab, $questions[$i]['answer'.$j]['text']);
                }
                $j++;
            }
        }
        return $tab;
    }
    function get_users_answers($answers, $question) {
        $tab = array();
        for ($i=0; $i < count($answers) ; $i++) {
            if ($answers[$i]['question'] == $question) {
                $result = is_string_inside($answers[$i], 'answer');
                foreach ($result as $key => $value) {
                    array_push($tab, $answers[$i][$value]);
                }
            }
        }
        return $tab;
    }

    function get_score($questions, $answers, $user) {
        $score = 0;
        for ($i=0; $i < count($questions) ; $i++) { 
            if($questions[$i]['type'] == 'text' && $questions[$i]['answer']['text'] == $answers[$i]['answer'] ) {
                $score += $questions[$i]['score'];
                set_banned_questions($user, $questions[$i]['question']);
            } elseif ($questions[$i]['type'] == 'simple') {
                $userAnswer = get_users_answers($answers, $questions[$i]['question']);
                $goodAnswer = get_good_answers($questions, $questions[$i]['question']);
                if ($userAnswer == $goodAnswer) {
                    $score += $questions[$i]['score'];
                    set_banned_questions($user, $questions[$i]['question']);
                }
            } elseif ($questions[$i]['type'] == 'multiple') {
                $test = true;
                $usersAnswers = get_users_answers($answers, $questions[$i]['question']);
                $goodAnswers = get_good_answers($questions, $questions[$i]['question']);
                if (count($usersAnswers) == count($goodAnswers)) {
                    for ($j=0; $j < count($usersAnswers) ; $j++) { 
                        for ($k=0; $k < count($goodAnswers) ; $k++) {
                            if (!in_array($goodAnswers[$k], $usersAnswers)) {
                                $test = false;
                            break;
                            }
                        }
                    }
                } else {
                    $test = false;
                }
                if ($test) {
                    $score += $questions[$i]['score'];
                    set_banned_questions($user, $questions[$i]['question']);
                }
            }
        }
        return $score;
    }

    function set_score (array $tab, $file='users') {
        $temp = get_data($file);
        foreach ($temp as $key => $value) {
            if ($value['login'] == $tab['login']) {
                $temp[$key]['score'] = $tab['score'];
            }
        }
        $data = json_encode($temp);
        file_put_contents('data/'.$file.'.json', $data);
    }

    function set_banned_questions($user, $question, $file='users') {
        $temp = get_data($file);
        foreach ($temp as $key => $value) {
            if ($value['login'] == $user['login']) {
                $temp[$key]['bannedQuestions'][] = $question;
            }
        }
        $data = json_encode($temp);
        file_put_contents('data/'.$file.'.json', $data);
    }

    function get_banned_questions($user){
        $data = get_data();
        foreach ($data as $element) {
            if ($element['login'] == $user['login']) {
                return $element['bannedQuestions'];
            }
        }
        return false;
    }

    function get_user_questions($questions, $bannedQuestions) {
        foreach ($questions as $key => $value) {
            $i = 0;
            while($i < count($bannedQuestions)) {
                if ($value['question'] == $bannedQuestions[$i]) {
                    unset($questions[$key]);
                }
                $i++;
            }
        }
        return $questions;
    }

?>