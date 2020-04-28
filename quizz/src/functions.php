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
                    return 'home';
                } else {
                    return 'game';
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
                echo '<input disabled type="text" name="" id="" value="'.$tab[$i]['answer']['text'].'">';
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
?>