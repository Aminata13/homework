<?php
require_once('functions.php');
$tab = array(1, 2, 3, 4, 5, 6, 7, 8);
$string = 'Je vais au marche.';
var_dump(is_sentence_valid($string));
var_dump(myStrlen($tab));
var_dump(myStrlen($string));
var_dump(strlen($string));
$month = array(
    'french'=>array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"), 
    'english'=>array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
);
var_dump(myStrlen($month));
var_dump(myToLower('9'));
$char = '';
$chaine = array('bonjour', 'la', 'mifa');
for ($i=0; isset($chaine[$i]); $i++) { 
    $char = $char.$chaine[$i] ;
}
$text = 'Im still alive! Thanks god. I need 2.5 dollars. La note de Fatou est 10. Tout le monde a la moyenne.';
var_dump(get_sentence($text));
$sentence = '       La note  de Fatou,  je l \' a connais .     ';
var_dump($sentence);
var_dump(trim_sentence($sentence));
?>