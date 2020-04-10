<?php
    require_once('functions.php');
?>
<!DOCTYPE HTML>  
<html lang="fr">
<head>
<title>Exercice 3 - Tableaux</title>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$N = "";
$mot = "";
$formvalid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["N"]) && $_POST['N']!='0') {
    $errors['N'] = "Veuillez remplir ce champ.";
  } else {
    $N = test_input($_POST["N"]);
    if (!(myIsNumeric($N))) {
      $errors['N'] = "Le nombre doit être un entier.";
    } elseif ($N<2 || $N>10) {
      $errors['N'] = "Le nombre doit être compris entre 2 et 10.";
    } else {
        $formvalid=true;
    }
  }
}
if (isset($_POST['submit']) && $_POST['submit'] == 'Envoyer') {
  for ($i=0; $i < $N; $i++) {
    if (empty($_POST['mot'.$i])) {
      $errors['mot'.$i] = "Veuillez remplir ce champ.";
    } else {
      $mot = test_input($_POST["mot".$i]);
      if(myStrlen($mot)>20) {
        $errors['mot'.$i] = "Un mot ne doit pas contenir plus de 20 lettres.";
      } else {
        if (!is_word_valide($mot)) {
          $errors['mot'.$i] = "Un mot ne doit contenir que des lettres.";
        } else {
          if (myStrlen($mot)<2) {
            $errors['mot'.$i] = "Un mot doit contenir au moins deux lettres.";
          }
        }
      }
    }
  }
}
?>

<h2>Exercice 3: Tableaux</h2>
<p><span class="error">* champ obligatoire</span></p>
<p>Saisissez le nombre de mots N que vous souhaitez entrer. N doit être compris entre 2 et 10.</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    Entrer N : <input type="text" name="N" value="<?= $N ?>">
    <span class="error">* <?php if(!empty($errors['N'])){echo $errors['N'];} ?></span>
    <br><br>
    <input type="submit" name="generate" value="Générer les champs">
    <br><br> 
    <?php
        if($formvalid) {
            for ($i=0; $i < $N; $i++) { 
    ?>
    <?php echo 'Mot N°'.($i+1); ?> : <input type="text" name="mot<?= $i ?>" value="<?php if (isset($_POST['mot'.$i])) {echo $_POST['mot'.$i];}?>">
    <span class="error">* <?php if(!empty($errors['mot'.$i])){echo $errors['mot'.$i];} ?></span><br>
    <br><br>
    <?php
            }
    ?>
    <input type="submit" name="submit" value="Envoyer">
    <?php
        }
    ?>
</form>

<?php
if (isset($_POST['submit']) && empty($errors)) {
    $compteur = 0;
    for ($i=0; $i < $N; $i++) { 
        if (is_char_in_string($_POST['mot'.$i], 'm') || is_char_in_string($_POST['mot'.$i], 'M')){
            $compteur++;
        }
    }
    echo "<h2>Vous avez saisi ".$N." Mot(s) dont " .$compteur. " avec la lettre M.</h2>" ;
}
?>

</body>
</html>