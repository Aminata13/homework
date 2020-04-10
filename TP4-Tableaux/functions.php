<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
  }

function getPrimeNumbers($n) {
    $primeNumbers = array();
    for ($i=2; $i <= $n ; $i++) { 
        $test = false;
        for ($j=2; $j <= $i/2 ; $j++) { 
            if ($i%$j==0) {
                $test = true;
                break;
            }
        }
        if (!$test) {
            array_push($primeNumbers, $i);
        } 
    }
    return $primeNumbers;
}
 function average($tab){
     $nbrElements = count($tab);
     $somme = 0;
     for ($i=0; $i < $nbrElements ; $i++) { 
        $somme += $tab[$i];
     }
     return $somme / $nbrElements;
 }

 function countTab($tab){
     $i = 0;
     foreach($tab as $tab){
         $i++;
     }
     return $i;
 }
 function myStrlen($var) {
    $i = 0;
    while (isset($var[$i])) {
        $i++;
    }
    return $i;
 }
 function myExplode(array $delimiters, string $string){ //faudrait que le délimiteur soit un tableau
    $stringTab = array();
    $segment = $string[0];
    for ($i=1; $i < strlen($string) ; $i++) { 
        if ($i == (strlen($string)-1)) {
            $segment = $segment.$string[$i];
            array_push($stringTab, $segment);
        }
        if (!is_char_in_string($delimiters, $string[$i])){
            $segment = $segment.$string[$i];
        } else {
            if ($segment != null) {
                array_push($stringTab, $segment);
            }
            $segment = null;
        }
    }
    return $stringTab;
 }
 function is_numberValid(string $string){
    return preg_match('#^(33|7[05-8])[0-9]{7}$#', $string);
 }
 function percentage(int $somme, int $total) {
    return (int)($somme/$total*100);
 }
 function calendar(string $choix, array $tab) {
    foreach ($tab as $key => $value) {
        if ($key == $choix) {
            echo "<table>";
            $i=0;
            while ($i < count($tab[$choix])) { 
                echo "<tr>";
                echo "<td>" .($i+1). "</td>";
                echo "<td>" .$value[$i]. "</td>";
                echo "<td>" .($i+2). "</td>";
                echo "<td>" .$value[$i+1]. "</td>";
                echo "<td>" .($i+3). "</td>";
                echo "<td>" .$value[$i+2]. "</td>";
                echo "</tr>";
                $i += 3;
            } 
            echo "</table>";
        }
    }
 }
 function getSentences(string $string) {
    $punctuations = array('.', '!', '?');
    $stringTab = array();
    $word = $string[0];
    for ($i=1; $i < strlen($string) ; $i++) { 
      while ($i != (strlen($string)-1) && 
      (($string[$i]==' ' && $string[$i+1]==' ') || 
      ($string[$i]==' ' && is_char_in_string($punctuations, $string[$i+1])))){
        $i++;
      }  
      if (!is_char_in_string($punctuations, $string[$i])){
        $word = $word.$string[$i];
      } else {
        if ($word != null) {
          $word = $word.$string[$i];
            if ($i==strlen($string)-1 || (!is_entier($string[$i-1]) && !is_entier($string[$i+1]))) {
              array_push($stringTab, $word);
              $word = null;
            }  
        }
        while ($i != (strlen($string)-1) && $string[$i+1]==' '){
          $i++;
        }
      }
    }
    return $stringTab;
 }
 function paginate (string $link, int $elementsPerPage, string $page, array $tab) {
    $_SESSION['nbrNumbers'] = countTab($tab);
    $_SESSION['nbrPages'] = ceil($_SESSION['nbrNumbers']/$elementsPerPage);
    if(isset($_GET[$page])) {
        $_SESSION['pageActuelle'] = intval($_GET[$page]);
 
        if($_SESSION['pageActuelle'] > $_SESSION['nbrPages']){
            $_SESSION['pageActuelle'] = $_SESSION['nbrPages'];
        }
    }
    else {
        $_SESSION['pageActuelle'] = 1; // La page actuelle est la n°1    
    }
    $_SESSION['firstEntry'] = ($_SESSION['pageActuelle']-1)*$elementsPerPage;
    $_SESSION['finalValue'] = $_SESSION['pageActuelle']*$elementsPerPage;
    if ($_SESSION['finalValue'] > countTab($tab)) {
        $_SESSION['finalValue'] = countTab($tab);
    }
    $i=$_SESSION['firstEntry'];
    while ($i < $_SESSION['finalValue']) { 
        echo '<br><table>';
        for ($j=0; $j < 10 ; $j++) { 
            echo '<tr>';
            for ($k=0; $k < 10 ; $k++) {
                if ($i == $_SESSION['finalValue']){
                break;
                } else {
                    echo '<td>'.$tab[$i].'</td>';
                    $i++;
                }
            }
            echo '</tr>';
        }
        echo '</table>';
    } 
    echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
    for ($i=1; $i<=$_SESSION['nbrPages']; $i++) {
        //On va faire notre condition
        if($i==$_SESSION['pageActuelle']) //S'il s'agit de la page actuelle...
        {
            echo ' [ '.$i.' ] '; 
        }    
        else //Sinon...
        {
            echo ' <a href="'.$link.'?'.$page.'='.$i.'">'.$i.'</a> ';
        }
    }
    echo '</p>';
 }
function is_entier($char) {
    return ($char>='0' && $char<='9');
}
function myIsNumeric($char) {
    for ($i=0; isset($char[$i]); $i++) { 
        if (!($char[$i]>='0' && $char[$i]<='9')){
            return false;
        }
    }
    return ($char>0);
}
function isLower(string $char) {
    return ($char>='a' && $char<= 'z');
}
function isUpper(string $char) {
    return ($char>='A' && $char<= 'Z');
}
function isAlphabeticCharacter(string $char) {
    return (isLower($char) || isUpper($char));
}
function is_word_valide ($char) {
    for ($i=0; isset($char[$i]); $i++) { 
        if(!isAlphabeticCharacter($char[$i])) {
            return false;
        }
    }
    return true;
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
function myToLower (string $char){
    $alphabet = alphabet();
    foreach ($alphabet as $key => $value) {
        if ($char == $value) {
            return $key;
        }
    }
    return $char;
}
function myToUpper (string $char){
    $alphabet = alphabet();
    foreach ($alphabet as $key => $value) {
        if ($char == $key) {
            return $value;
        }
    }
    return $char;
}
function myToLowerString(string $char) {
    for ($i=0; isset($char[$i]); $i++) { 
        $char[$i] = myToLower($char[$i]);
    }
    return $char;
}
function myToUpperString(string $char) {
    for ($i=0; isset($char[$i]); $i++) { 
        $char[$i] = myToUpper($char[$i]);
    }
    return $char;
}
function is_char_in_string($char, $c) {
    for ($i=0; $i < myStrlen($char) ; $i++) { 
        if($c == $char[$i]) {
            return true;
        }
    }
    return false;
}
function count_char_in_string($char, $c) {
    $compteur = 0;
    for ($i=0; $i < myStrlen($char) ; $i++) { 
        if(in_char_in_string($char[$i], $c)) {
            $compteur++;
        }
    }
    return $compteur;
}
function my_trim_debut($char) {
    $result = '';
    $i=0;
    while ($char[$i] == ' ' && $i < myStrlen($char)){
        $i++;
    }
    for ($j=$i; $j < myStrlen($char) ; $j++) { 
        $result = $result.$char[$j];
    }
    return $result;

}
function my_trim_fin($char) {
    $result = '';
    $i=myStrlen($char)-1;
    while ($char[$i] == ' ' && $i > 0 ){
        $i--;
    }
    for ($j=0; $j <= $i ; $j++) { 
        $result = $result.$char[$j];
    }
    return $result;

}
function my_trim ($char, $choix='') {
    if (isset($choix) && $choix=='debut') {
        return my_trim_debut($char);
    } else {
        if (isset($choix) && $choix=='fin') {
            return my_trim_fin($char);
        } else {
            $result = my_trim_debut($char);
            $result = my_trim_fin($result);
        }
    }
    return $result;
}
function is_sentence_valid ($sentence) {
    return (preg_match('#^[A-Z](.+)[.?!]$#', $sentence) && myStrlen($sentence)<200);
}
function get_sentence ($text) {
    return preg_split('#([.?!]([^0-9]))#', $text, 0, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
}
function trim_sentence ($sentence) {
    $sentence = preg_replace('#(^\s+)|(\s+$)#', '', $sentence);
    $sentence = preg_replace('#\s\s+#', ' ', $sentence);
    return $sentence;
}
?>