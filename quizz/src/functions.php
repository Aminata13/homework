<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    function authenticate($file, $login, $password) {
        $data = file_get_contents($file); 
        $obj = json_decode($data);
        foreach ($obj as $element) {
            if ($element->login == $login && $element->password == $password) {
                return true;
            }
        }
        return false;
    }
    function get_user($file, $login, $password){
        $data = file_get_contents($file); 
        $obj = json_decode($data);
        foreach ($obj as $element) {
            if ($element->login == $login && $element->password == $password) {
                return $element;
            }
        }
        return false;
    }
?>