<?php
    require_once('functions.php');
?>
<!DOCTYPE HTML>  
<html lang="fr">
<head>
<title>Exercice 4 - Tableaux</title>
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
    if ($input[myStrlen($input)-1] != '.' && $input[myStrlen($input)-1] != '!' && $input[myStrlen($input)-1] != '?') {
        $errors['input'] = "Une phrase doit se terminer par un point.";
    }
    $inputTab = getSentences($input);
    foreach($inputTab as $sentence) {
      if(myStrlen($sentence)>200) {
        $errors['input'] = "Une phrase ne doit pas contenir plus de 200 caractères";
      } 
    }
     
  }
  
}
?>

<h2>Exercice 4: Tableaux</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Saisissez votre texte:</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <textarea name="input" id="" cols="56" rows="8"><?php echo $input;?></textarea>
    <span class="error">* <?php if(!empty($errors['input'])){echo $errors['input'];} ?></span>
    <br><br>
    <input type="submit" name="submit" value="Envoyer">  
</form>

<?php
if (!empty($_POST) && empty($errors)) {
  $sentences = array();
  $punctuations = array();
  $words = array();
  $word = $input[0];
  for ($i=1; $i < myStrlen($input) ; $i++) {
    if ($input[$i] != ' ' && $input[$i] != '.' && $input[$i] != '!' && $input[$i] != '?'){
      $word = $word.$input[$i];
    } else {
      if ($input[$i] != '.' && $input[$i] != '!' && $input[$i] != '?') {
        if ($word != null) {
          array_push($words, $word);
        }
        $word = null;
      } else {
        array_push($punctuations, $input[$i]);
        $sentence = $words;
        array_push($sentences, $sentence);
        $sentence = null;
        $word = null;
        $words = array();
      }
    }
    if ($i != (myStrlen($input)-1) && ($input[$i+1]=='.' || $input[$i+1]=='!' || $input[$i+1]=='?') && $word != null) {
      array_push($words, $word);
      
    }
  }
  echo "<h2>Voici votre texte corrigé:</h2>";
  echo '<textarea disabled cols="56" rows="8">';
  $sentences[0][0][0] = strtoupper($sentences[0][0][0]);
  foreach ($sentences as $key => $value) {
    if (!empty($value)) {
      for ($i=0; $i < countTab($sentences[$key]) ; $i++) { 
        if ($i != 0 && 
        preg_match("#^'#", $sentences[$key][$i])==0 && 
        preg_match("#'$#", $sentences[$key][$i-1])==0 && 
        preg_match("#^'$#", $sentences[$key][$i-1])==0 &&
        preg_match("#^[;:,]#", $sentences[$key][$i])==0) {
          echo ' ';
        }
        echo $sentences[$key][$i];
      }
      echo $punctuations[$key]. ' ';
      if (!empty($sentences[$key+1])) {
        $sentences[$key+1][0][0] = strtoupper($sentences[$key+1][0][0]);
      }
    }
  }
  echo '</textarea>';
}
?>

</body>
</html>