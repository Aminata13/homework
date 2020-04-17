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
    
    function get_data ($file) {
        $data = file_get_contents($file); 
        return json_decode($data, true);
    }

    function authenticate($file, $login, $password) {
        $data = get_data($file);
        foreach ($data as $element) {
            if ($element['login'] == $login && $element['password'] == $password) {
                return true;
            }
        }
        return false;
    }
    function get_user($file, $login, $password){
        $data = get_data($file);
        foreach ($data as $element) {
            if ($element['login'] == $login && $element['password'] == $password) {
                return $element;
            }
        }
        return false;
    }
?>