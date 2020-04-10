<?php
    require_once('functions.php');
?>
<!DOCTYPE HTML>  
<html lang="fr">
<head>
<title>Exercice 5 - Tableaux</title>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$input = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["input"])) {
    $errors['input'] = "Veuillez remplir ce champ";
  } else {
    $input = test_input($_POST["input"]);
    if (!preg_match("#^[0-9\s;-]+$#", $input)) {
        $errors['input'] = "La saisie ne doit comporter que des chiffres.";
    } 
  }
}
?>

<h2>Exercice 5: Tableaux</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Saisissez les différents numéros séparés par une virgule, un espace ou un tiret. Un numéro valide doit contenir 9 chiffres. <strong>Exemple: 775472319</strong>.</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <textarea name="input" id="" cols="56" rows="8"><?= $input ?></textarea>
    <span class="error">* <?php if(!empty($errors['input'])){echo $errors['input'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Envoyer">  
</form>

<?php
if (!empty($_POST) && empty($errors)) {
    $delimiters = array(' ', '-', ';');
    $inputTab = myExplode($delimiters, $input);
    $numbers = array (
        'orange' => array(),
        'expresso' => array(),
        'free' => array(),
        'promobile' => array()
    );
    foreach ($inputTab as $element) {
        if(is_numberValid($element)==1 && 
        (($element[0]==3 && $element[1]==3) || 
        ($element[0]==7 && $element[1]==7) || 
        ($element[0]==7 && $element[1]==8))) {
            array_push($numbers['orange'], $element);
        } else {
            if (is_numberValid($element)==1 && ($element[0]==7 && $element[1]==0)) {
                array_push($numbers['expresso'], $element);
            } else {
                if (is_numberValid($element)==1 && ($element[0]==7 && $element[1]==6)) {
                    array_push($numbers['free'], $element);
                } else {
                    if (is_numberValid($element)==1 && ($element[0]==7 && $element[1]==5)) {
                        array_push($numbers['promobile'], $element);
                    }
                }
            }
        }
    }
    $validNumbers = countTab($numbers['orange'])+countTab($numbers['expresso'])+countTab($numbers['free'])+countTab($numbers['promobile']);
    $invalidNumbers = countTab($inputTab)-$validNumbers;
    $invalidNumbersRate = percentage($invalidNumbers, countTab($inputTab));
    if ($validNumbers != 0) {
        echo "<h2>" .$invalidNumbersRate. "% des numéros sont invalides.</h2>";
        echo "<h2>" .(percentage(countTab($numbers['orange']), $validNumbers)). "% des numéros sont de l'opérateur Orange.</h2>";
        echo "<h2>" .(percentage(countTab($numbers['expresso']), $validNumbers)). "% des numéros sont de l'opérateur Expresso.</h2>";
        echo "<h2>" .(percentage(countTab($numbers['free']), $validNumbers)). "% des numéros sont de l'opérateur Free.</h2>";    
        echo "<h2>" .(percentage(countTab($numbers['promobile']), $validNumbers)). "% des numéros sont de l'opérateur ProMobile.</h2>";    
    }
    
}
?>

</body>
</html>