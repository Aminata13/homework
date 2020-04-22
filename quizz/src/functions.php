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
        $temp = get_data();
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
?>