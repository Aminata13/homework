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
 function myExplode(string $delimiter, string $string){
    $stringTab = array();
    $segment = $string[0];
    for ($i=1; $i < strlen($string) ; $i++) { 
        if ($i == (strlen($string)-1)) {
            $segment = $segment.$string[$i];
            array_push($stringTab, $segment);
        }
        if ($string[$i] != $delimiter){
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
    return preg_match('#^(33|7[06-8])[0-9]{7}$#', $string);
 }
 function percentage(int $somme, int $total) {
    return (int)($somme/$total*100);
 }
 function myStrlen(string $string) {
    $i = 0;
    while (isset($string[$i])) {
        $i++;
    }
    return $i;
 }
?>