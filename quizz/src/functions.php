<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
    
    function alphabet() {
        $alphabet = array();
        $i=0;
        $c='a';  
        $C='A';
        while($c<='z' && $C <= 'Z' && $i<26) {
            $alphabet[$c] = $C;
            $c++;
            $C++;  
            $i++;  
        }
        return $alphabet;
    }

    function my_to_upper (string $char){
        $alphabet = alphabet();
        foreach ($alphabet as $key => $value) {
            if ($char == $key) {
                return $value;
            }
        }
        return $char;
    }

    function my_to_upper_string(string $char) {
        for ($i=0; isset($char[$i]); $i++) { 
            $char[$i] = my_to_upper($char[$i]);
        }
        return $char;
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
?>